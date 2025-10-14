<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StripeGateway implements PaymentGatewayInterface
{
    protected string $secretKey;
    protected string $publicKey;
    protected string $apiUrl = 'https://api.stripe.com/v1';

    public function __construct()
    {
        $this->secretKey = config('services.stripe.secret_key');
        $this->publicKey = config('services.stripe.public_key');
    }

    /**
     * Initiate payment with Stripe
     *
     * @param array $paymentData
     * @return array
     */
    public function initiatePayment(array $paymentData): array
    {
        try {
            // Create a Stripe Checkout Session
            $response = Http::withBasicAuth($this->secretKey, '')
                ->asForm()
                ->post("{$this->apiUrl}/checkout/sessions", [
                    'payment_method_types[]' => 'card',
                    'line_items[0][price_data][currency]' => strtolower($paymentData['currency']),
                    'line_items[0][price_data][product_data][name]' => $paymentData['description'],
                    'line_items[0][price_data][unit_amount]' => (int)($paymentData['amount'] * 100), // Amount in cents
                    'line_items[0][quantity]' => 1,
                    'mode' => 'payment',
                    'success_url' => $paymentData['return_url'] . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => $paymentData['cancel_url'],
                    'customer_email' => $paymentData['customer_email'],
                    'client_reference_id' => $paymentData['regCode'],
                    'metadata[regCode]' => $paymentData['regCode'],
                    'metadata[registrant_id]' => $paymentData['registrant_id'],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'status' => 'initiated',
                    'reference_no' => $paymentData['regCode'],
                    'session_id' => $data['id'] ?? null,
                    'payment_url' => $data['url'] ?? null,
                    'redirect_url' => $data['url'] ?? null,
                    'public_key' => $this->publicKey,
                ];
            }

            throw new \Exception('Stripe checkout session creation failed: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('Stripe payment initiation error', [
                'error' => $e->getMessage(),
                'payment_data' => $paymentData,
            ]);

            throw $e;
        }
    }

    /**
     * Verify Stripe payment callback
     *
     * @param array $callbackData
     * @return array
     */
    public function verifyPayment(array $callbackData): array
    {
        try {
            $sessionId = $callbackData['session_id'] ?? null;
            
            if (!$sessionId) {
                throw new \Exception('Session ID not found in callback');
            }

            // Retrieve the session from Stripe
            $response = Http::withBasicAuth($this->secretKey, '')
                ->get("{$this->apiUrl}/checkout/sessions/{$sessionId}");

            if ($response->successful()) {
                $session = $response->json();
                
                $verified = $session['payment_status'] === 'paid';
                
                return [
                    'verified' => $verified,
                    'status' => $session['payment_status'] ?? 'unknown',
                    'reference_no' => $session['client_reference_id'] ?? null,
                    'payment_id' => $session['payment_intent'] ?? null,
                    'amount' => $session['amount_total'] / 100, // Convert from cents
                    'currency' => strtoupper($session['currency'] ?? ''),
                    'customer_email' => $session['customer_details']['email'] ?? null,
                    'raw_data' => $session,
                ];
            }

            throw new \Exception('Failed to retrieve Stripe session');

        } catch (\Exception $e) {
            Log::error('Stripe payment verification error', [
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
     * Get Stripe payment status
     *
     * @param string $referenceNo
     * @return array
     */
    public function getPaymentStatus(string $referenceNo): array
    {
        try {
            // Search for payment intent by metadata
            $response = Http::withBasicAuth($this->secretKey, '')
                ->get("{$this->apiUrl}/payment_intents", [
                    'limit' => 1,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // This is a simplified implementation
                // In production, you should store the payment_intent_id in your database
                return [
                    'status' => 'unknown',
                    'reference_no' => $referenceNo,
                    'message' => 'Please store payment_intent_id for accurate status retrieval',
                ];
            }

            throw new \Exception('Failed to retrieve payment status');

        } catch (\Exception $e) {
            Log::error('Stripe get payment status error', [
                'error' => $e->getMessage(),
                'reference_no' => $referenceNo,
            ]);

            throw $e;
        }
    }

    /**
     * Process refund with Stripe
     *
     * @param string $referenceNo (payment_intent_id)
     * @param float $amount
     * @return array
     */
    public function refundPayment(string $referenceNo, float $amount): array
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->asForm()
                ->post("{$this->apiUrl}/refunds", [
                    'payment_intent' => $referenceNo,
                    'amount' => (int)($amount * 100), // Amount in cents
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
            Log::error('Stripe refund error', [
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
        return 'Stripe';
    }
}

