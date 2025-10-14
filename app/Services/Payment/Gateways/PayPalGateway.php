<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalGateway implements PaymentGatewayInterface
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $apiUrl;
    protected bool $isSandbox;

    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
        $this->isSandbox = config('services.paypal.sandbox', true);
        $this->apiUrl = $this->isSandbox 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';
    }

    /**
     * Get PayPal access token
     *
     * @return string
     */
    protected function getAccessToken(): string
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post("{$this->apiUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token'];
        }

        throw new \Exception('Failed to get PayPal access token: ' . $response->body());
    }

    /**
     * Initiate payment with PayPal
     *
     * @param array $paymentData
     * @return array
     */
    public function initiatePayment(array $paymentData): array
    {
        try {
            $accessToken = $this->getAccessToken();

            $response = Http::withToken($accessToken)
                ->post("{$this->apiUrl}/v2/checkout/orders", [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'reference_id' => $paymentData['regCode'],
                            'description' => $paymentData['description'],
                            'custom_id' => $paymentData['regCode'],
                            'amount' => [
                                'currency_code' => $paymentData['currency'],
                                'value' => number_format($paymentData['amount'], 2, '.', ''),
                            ],
                        ],
                    ],
                    'application_context' => [
                        'brand_name' => config('app.name'),
                        'locale' => 'en-US',
                        'landing_page' => 'BILLING',
                        'shipping_preference' => 'NO_SHIPPING',
                        'user_action' => 'PAY_NOW',
                        'return_url' => $paymentData['return_url'],
                        'cancel_url' => $paymentData['cancel_url'],
                    ],
                    'payer' => [
                        'email_address' => $paymentData['customer_email'],
                        'name' => [
                            'given_name' => explode(' ', $paymentData['customer_name'])[0] ?? '',
                            'surname' => explode(' ', $paymentData['customer_name'])[1] ?? '',
                        ],
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Get approval URL
                $approvalUrl = null;
                foreach ($data['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approvalUrl = $link['href'];
                        break;
                    }
                }
                
                return [
                    'status' => 'initiated',
                    'reference_no' => $paymentData['regCode'],
                    'order_id' => $data['id'] ?? null,
                    'payment_url' => $approvalUrl,
                    'redirect_url' => $approvalUrl,
                ];
            }

            throw new \Exception('PayPal order creation failed: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('PayPal payment initiation error', [
                'error' => $e->getMessage(),
                'payment_data' => $paymentData,
            ]);

            throw $e;
        }
    }

    /**
     * Verify PayPal payment callback
     *
     * @param array $callbackData
     * @return array
     */
    public function verifyPayment(array $callbackData): array
    {
        try {
            $orderId = $callbackData['token'] ?? $callbackData['order_id'] ?? null;
            
            if (!$orderId) {
                throw new \Exception('Order ID not found in callback');
            }

            $accessToken = $this->getAccessToken();

            // Capture the order
            $response = Http::withToken($accessToken)
                ->post("{$this->apiUrl}/v2/checkout/orders/{$orderId}/capture");

            if ($response->successful()) {
                $data = $response->json();
                
                $status = $data['status'] ?? '';
                $verified = $status === 'COMPLETED';
                
                $captureId = null;
                $referenceId = null;
                $amount = null;
                $currency = null;

                if (isset($data['purchase_units'][0])) {
                    $purchaseUnit = $data['purchase_units'][0];
                    $referenceId = $purchaseUnit['reference_id'] ?? null;
                    
                    if (isset($purchaseUnit['payments']['captures'][0])) {
                        $capture = $purchaseUnit['payments']['captures'][0];
                        $captureId = $capture['id'] ?? null;
                        $amount = $capture['amount']['value'] ?? null;
                        $currency = $capture['amount']['currency_code'] ?? null;
                    }
                }
                
                return [
                    'verified' => $verified,
                    'status' => $status,
                    'reference_no' => $referenceId,
                    'order_id' => $orderId,
                    'capture_id' => $captureId,
                    'amount' => $amount,
                    'currency' => $currency,
                    'raw_data' => $data,
                ];
            }

            // If capture fails, try to get order details
            $detailsResponse = Http::withToken($accessToken)
                ->get("{$this->apiUrl}/v2/checkout/orders/{$orderId}");

            if ($detailsResponse->successful()) {
                $orderData = $detailsResponse->json();
                
                return [
                    'verified' => false,
                    'status' => $orderData['status'] ?? 'unknown',
                    'order_id' => $orderId,
                    'error' => 'Order not completed',
                    'raw_data' => $orderData,
                ];
            }

            throw new \Exception('Failed to verify PayPal payment');

        } catch (\Exception $e) {
            Log::error('PayPal payment verification error', [
                'error' => $e->getMessage(),
                'callback_data' => $callbackData,
            ]);

            return [
                'verified' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get PayPal payment status
     *
     * @param string $referenceNo (order_id)
     * @return array
     */
    public function getPaymentStatus(string $referenceNo): array
    {
        try {
            $accessToken = $this->getAccessToken();

            $response = Http::withToken($accessToken)
                ->get("{$this->apiUrl}/v2/checkout/orders/{$referenceNo}");

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'status' => $data['status'] ?? 'unknown',
                    'order_id' => $referenceNo,
                    'data' => $data,
                ];
            }

            throw new \Exception('Failed to retrieve payment status');

        } catch (\Exception $e) {
            Log::error('PayPal get payment status error', [
                'error' => $e->getMessage(),
                'reference_no' => $referenceNo,
            ]);

            throw $e;
        }
    }

    /**
     * Process refund with PayPal
     *
     * @param string $referenceNo (capture_id)
     * @param float $amount
     * @return array
     */
    public function refundPayment(string $referenceNo, float $amount): array
    {
        try {
            $accessToken = $this->getAccessToken();

            $response = Http::withToken($accessToken)
                ->post("{$this->apiUrl}/v2/payments/captures/{$referenceNo}/refund", [
                    'amount' => [
                        'value' => number_format($amount, 2, '.', ''),
                        'currency_code' => 'USD', // Should be dynamic based on original payment
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'refund_id' => $data['id'] ?? null,
                    'status' => $data['status'] ?? null,
                    'data' => $data,
                ];
            }

            throw new \Exception('Refund failed: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('PayPal refund error', [
                'error' => $e->getMessage(),
                'reference_no' => $referenceNo,
                'amount' => $amount,
            ]);

            throw $e;
        }
    }

    /**
     * Get gateway name
     *
     * @return string
     */
    public function getGatewayName(): string
    {
        return 'PayPal';
    }
}

