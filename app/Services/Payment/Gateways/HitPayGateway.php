<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HitPayGateway implements PaymentGatewayInterface
{
    protected string $apiKey;
    protected string $apiUrl;
    protected bool $isSandbox;

    public function __construct()
    {
        $this->apiKey = config('services.hitpay.api_key');
        $this->isSandbox = config('services.hitpay.sandbox', true);
        $this->apiUrl = $this->isSandbox 
            ? 'https://api.sandbox.hit-pay.com/v1' 
            : 'https://api.hit-pay.com/v1';
    }

    /**
     * Initiate payment with HitPay
     *
     * @param array $paymentData
     * @return array
     */
    public function initiatePayment(array $paymentData): array
    {
        try 
        {
            $response = Http::withHeaders([
                'X-BUSINESS-API-KEY' => $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])
            ->asForm()
            ->post("{$this->apiUrl}/payment-requests", [
                'email' => $paymentData['customer_email'],
                'amount' => number_format($paymentData['amount'], 2, '.', ''),
                'currency' => $paymentData['currency'],
                'purpose' => $paymentData['description'],
                'reference_number' => $paymentData['confirmationCode'],
                'redirect_url' => $paymentData['return_url'],
                'webhook' => $paymentData['webhook_url'],
                'name' => $paymentData['customer_name'],
                'phone' => $paymentData['customer_phone'],
                'expiry_date' => Carbon::now()->addDays(3)->format('Y-m-d H:i:s'),
            ]);

            if ($response->successful()) 
            {
                $data = $response->json();

                return [
                    'status' => 'initiated',
                    'data' => $data,
                    'reference_no' => $data['reference_number'] ?? $paymentData['confirmationCode'],
                    'payment_id' => $data['id'] ?? null,
                    'payment_url' => $data['url'] ?? null,
                    'redirect_url' => $data['redirect_url'] ?? null,
                    'expires_at' => $data['expiry_date'] ?? null,
                ];
            }

            throw new \Exception('HitPay payment initialization failed: ' . $response->body());

        } 
        catch (\Exception $e) 
        {
            Log::error('HitPay payment initiation error', [
                'error' => $e->getMessage(),
                'payment_data' => $paymentData,
            ]);

            throw $e;
        }
    }

    /**
     * Verify HitPay payment callback
     *
     * @param array $callbackData
     * @return array
     */
    public function verifyPayment(array $callbackData): array
    {
        try 
        {
            // HitPay sends HMAC signature for verification
            $hmacSignature = $callbackData['hmac'] ?? null;

            if (!$hmacSignature) {
                throw new \Exception('HMAC signature not found in callback');
            }

            // Remove hmac from data for verification
            $dataToVerify = $callbackData;
            unset($dataToVerify['hmac']);

            // Sort data alphabetically by key
            ksort($dataToVerify);

            // Create data string
            $dataString = implode('', array_values($dataToVerify));

            // Calculate HMAC
            $calculatedHmac = hash_hmac('sha256', $dataString, config('services.hitpay.salt'));

            // Verify HMAC
            if (!hash_equals($calculatedHmac, $hmacSignature)) {
                throw new \Exception('Invalid HMAC signature');
            }

            // Check payment status
            $status = $callbackData['status'] ?? '';
            
            $verified = in_array($status, ['completed', 'success']);

            return [
                'verified' => $verified,
                'status' => $status,
                'reference_no' => $callbackData['reference_number'] ?? null,
                'payment_id' => $callbackData['payment_id'] ?? null,
                'amount' => $callbackData['amount'] ?? null,
                'currency' => $callbackData['currency'] ?? null,
                'raw_data' => $callbackData,
            ];

        }
        catch (\Exception $e) 
        {
            Log::error('HitPay payment verification error', [
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
     * Get HitPay payment status
     *
     * @param string $referenceNo
     * @return array
     */
    public function getPaymentStatus(string $referenceNo): array
    {
        try {
            $response = Http::withHeaders([
                'X-BUSINESS-API-KEY' => $this->apiKey,
            ])->get("{$this->apiUrl}/payment-requests/{$referenceNo}");

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'status' => $data['status'] ?? 'unknown',
                    'reference_no' => $data['reference_number'] ?? $referenceNo,
                    'amount' => $data['amount'] ?? null,
                    'currency' => $data['currency'] ?? null,
                    'data' => $data,
                ];
            }

            throw new \Exception('Failed to retrieve payment status');

        } catch (\Exception $e) {
            Log::error('HitPay get payment status error', [
                'error' => $e->getMessage(),
                'reference_no' => $referenceNo,
            ]);

            throw $e;
        }
    }

    /**
     * Process refund with HitPay
     *
     * @param string $referenceNo
     * @param float $amount
     * @return array
     */
    public function refundPayment(string $referenceNo, float $amount): array
    {
        try {
            $response = Http::withHeaders([
                'X-BUSINESS-API-KEY' => $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->asForm()->post("{$this->apiUrl}/refund", [
                'payment_id' => $referenceNo,
                'amount' => number_format($amount, 2, '.', ''),
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
            Log::error('HitPay refund error', [
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
        return 'HitPay';
    }
}

