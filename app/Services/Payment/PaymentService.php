<?php

namespace App\Services\Payment;

use App\Models\Registrant;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Gateways\BankTransferGateway;
use App\Services\Payment\Gateways\HitPayGateway;
use App\Services\Payment\Gateways\PayPalGateway;
use App\Services\Payment\Gateways\StripeGateway;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmedMail;

class PaymentService
{
    protected array $gateways = [];

    public function __construct()
    {
        $this->registerGateways();
    }

    /**
     * Register all available payment gateways
     */
    protected function registerGateways(): void
    {
        $this->gateways = [
            'hitpay' => new HitPayGateway(),
            'paypal' => new PayPalGateway(),
            'stripe' => new StripeGateway(),
            'bank_transfer' => new BankTransferGateway(),
        ];
    }

    public function getBankDetails(): array
    {
        $gateway = $this->getGateway('bank_transfer');
        return $gateway->getBankDetailsStructured();
    }

    /**
     * Get a specific payment gateway
     *
     * @param string $gatewayName
     * @return PaymentGatewayInterface
     * @throws \Exception
     */
    public function getGateway(string $gatewayName): PaymentGatewayInterface
    {
        if (!isset($this->gateways[$gatewayName])) {
            throw new \Exception("Payment gateway '{$gatewayName}' not found.");
        }

        return $this->gateways[$gatewayName];
    }

    /**
     * Process payment for a registrant
     *
     * @param Registrant $registrant
     * @param string $paymentMethod
     * @param array $additionalData
     * @return array
     */
    public function processPayment(Registrant $registrant, string $paymentMethod, array $additionalData = []): array
    {
        try 
        {
            $gateway = $this->getGateway($paymentMethod);

            // Prepare payment data
            $paymentData = $this->preparePaymentData($registrant, $additionalData);

            // Log payment attempt
            Log::info('Processing payment', [
                'registrant_id' => $registrant->id,
                'confirmationCode' => $registrant->confirmationCode,
                'payment_method' => $paymentMethod,
                'amount' => $registrant->netAmount,
            ]);

            // Initiate payment with the gateway
            $response = $gateway->initiatePayment($paymentData);

            // Update registrant with payment information
            $this->updateRegistrantPaymentInfo($registrant, $paymentMethod, $response);

            Log::info('Payment processing successful', [
                'registrant_id' => $registrant->id,
                'confirmationCode' => $registrant->confirmationCode,
                'payment_method' => $paymentMethod,
                'amount' => $registrant->netAmount,
                'response' => $response,
            ]);

            return [
                'success' => true,
                'gateway' => $paymentMethod,
                'data' => $response,
            ];

        } catch (\Exception $e) {
            Log::error('Payment processing failed', [
                'registrant_id' => $registrant->id,
                'payment_method' => $paymentMethod,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'gateway' => $paymentMethod,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Verify payment callback
     *
     * @param string $paymentMethod
     * @param array $callbackData
     * @return array
     */
    public function verifyPaymentCallback(string $paymentMethod, array $callbackData): array
    {
        try 
        {
            $gateway = $this->getGateway($paymentMethod);
            
            Log::info('Verifying payment callback', [
                'payment_method' => $paymentMethod,
                'callback_data' => $callbackData,
            ]);

            $result = $gateway->verifyPayment($callbackData);
            
            // If payment is verified, update registrant status
            if ($result['verified'] && !empty($result['reference_no'])) 
            {
                Log::info('Payment verification successful', [  
                    'payment_method' => $paymentMethod,
                    'reference_no' => $result['reference_no'],
                    'result' => $result,
                ]);

                $confirmed = $this->confirmPayment($result['reference_no'], $result);

                Log::info('Payment confirmation successful', [
                    'payment_method' => $paymentMethod,
                    'reference_no' => $result['reference_no'],
                    'result' => $result,
                    'confirmed' => $confirmed,
                ]);

            }

            return $result;

        } 
        catch (\Exception $e) 
        {
            Log::error('Payment verification failed', [
                'payment_method' => $paymentMethod,
                'error' => $e->getMessage(),
            ]);

            return [
                'verified' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Confirm payment and update registrant status
     *
     * @param string $referenceNo
     * @param array $paymentDetails
     * @return bool
     */
    public function confirmPayment(string $referenceNo, array $paymentDetails = []): bool
    {
        
        try {
            $registrant = Registrant::where('confirmationCode', $referenceNo)->first();

            if (!$registrant) {
                Log::warning('Registrant not found for payment confirmation', [
                    'reference_no' => $referenceNo,
                ]);
                return false;
            }

            // Prepare update data
            $updateData = [
                'regCode' => $this->generateRegCode($registrant->programme->programmeCode),
                'paymentStatus' => 'paid',
                'regStatus' => 'confirmed',
                'payment_completed_at' => now(),
            ];

            $updateData['payment_verified_by'] = isset($paymentDetails['verified_by']) ? $paymentDetails['verified_by'] : $registrant->paymentOption.'_api_system';
            $updateData['payment_verified_at'] = isset($paymentDetails['verified_at']) ? $paymentDetails['verified_at'] : now();
            $updateData['approvedDate'] = isset($paymentDetails['approvedDate']) ? $paymentDetails['approvedDate'] : now();
            $updateData['approvedBy'] = isset($paymentDetails['approvedBy']) ? $paymentDetails['approvedBy'] : $registrant->paymentOption.'_api_system';
            $updateData['confirmedBy'] = isset($paymentDetails['confirmedBy']) ? $paymentDetails['confirmedBy'] : $registrant->paymentOption.'_api_system';
            
            // Merge payment metadata with payment status and details
            $existingMetadata = $registrant->payment_metadata ?? [];
            $metadataUpdate = [
                'confirmed_at' => now()->toIso8601String(),
            ];
            
            // Store payment status from verification result
            if (isset($paymentDetails['status'])) {
                $metadataUpdate['payment_status'] = $paymentDetails['status'];
            }
            
            // Store payment request ID if available
            if (isset($paymentDetails['payment_request_id'])) {
                $metadataUpdate['payment_request_id'] = $paymentDetails['payment_request_id'];
            }
            
            // Store payment ID if available
            if (isset($paymentDetails['payment_id'])) {
                $metadataUpdate['payment_id'] = $paymentDetails['payment_id'];
            }
            
            // Store all confirmation details
            if (!empty($paymentDetails)) {
                $metadataUpdate['confirmation_details'] = $paymentDetails;
            }
            
            $updateData['payment_metadata'] = array_merge($existingMetadata, $metadataUpdate);

            // Update registrant payment status
            $mainRegistrant = $registrant->update($updateData);

            // Update group members if this is a group registration
            if ($registrant->groupRegistrationID) {
                $groupMembers = $registrant->groupMembers();

                foreach ($groupMembers as $index => $member) {
                    // Generate unique payment reference for each group member
                    // For group registrations, use groupRegistrationID as base
                    // Format: GROUPID_GM01, GROUPID_GM02, etc.
                    $memberPaymentRef = $registrant->groupRegistrationID . '_GM' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    
                    $member->update([
                        'regCode' => $this->generateRegCode($registrant->programCode),
                        'regStatus' => 'confirmed',
                        'paymentStatus' => 'group_member_paid',
                        'paymentReferenceNo' => $memberPaymentRef,
                        'payment_gateway' => $registrant->payment_gateway,
                        'payment_transaction_id' => $registrant->payment_transaction_id,
                        'payment_completed_at' => now(),
                        'payment_verified_at' => now(),
                        'payment_verified_by' => $registrant->paymentOption.'_api_system',
                        'approvedDate' => now(),
                        'approvedBy' => $registrant->paymentOption.'_api_system',
                        'confirmedBy' => $registrant->paymentOption.'_api_system',
                        'payment_metadata' => array_merge($member->payment_metadata ?? [], [
                            'group_payment_confirmed' => true,
                            'main_registrant_ref' => $referenceNo,
                            'main_registrant_code' => $registrant->confirmationCode,
                            'group_registration_id' => $registrant->groupRegistrationID,
                            'confirmed_at' => now()->toIso8601String(),
                        ]),
                    ]);
                }

                Log::info('Updated group members payment status', [
                    'main_registrant_id' => $registrant->id,
                    'main_registrant_code' => $registrant->confirmationCode,
                    'main_registrant_ref' => $referenceNo,
                    'group_registration_id' => $registrant->groupRegistrationID,
                    'group_members_count' => $groupMembers->count(),
                    'member_refs' => $groupMembers->pluck('paymentReferenceNo')->toArray(),
                ]);
            }

            Log::info('Payment confirmed successfully', [
                'registrant_id' => $registrant->id,
                'confirmationCode' => $registrant->confirmationCode,
                'reference_no' => $referenceNo,
            ]);

            // after the main registrant updated, update the promocode and promotion counters
            if ($mainRegistrant) 
            {
                // if there is promocode, update and increment the usedCount field
                if ($registrant->promocode) 
                    $registrant->promocode->increment('usedCount');

                // if there is promotion increment the counter field
                if ($registrant->promotion)
                    $registrant->promotion->increment('counter');

                // Send confirmation email
                try {
                    // Reload registrant with all relationships for email
                    $registrantWithRelations = Registrant::with(['programme.ministry', 'promocode', 'promotion'])
                        ->find($registrant->id);

                    if ($registrantWithRelations) {
                        Mail::to($registrantWithRelations->email)->send(new RegistrationConfirmedMail($registrantWithRelations));
                        
                        // Update email status
                        $registrantWithRelations->emailStatus = true;
                        $registrantWithRelations->save();

                        Log::info('Registration confirmation email sent', [
                            'registrant_id' => $registrant->id,
                            'email' => $registrantWithRelations->email,
                        ]);
                    }
                } catch (\Exception $e) {
                    // Log email error but don't fail the payment confirmation
                    Log::error('Failed to send registration confirmation email', [
                        'registrant_id' => $registrant->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            return true;
        } 
        catch (\Exception $e) 
        {
            Log::error('Payment confirmation failed', [
                'reference_no' => $referenceNo,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Prepare payment data from registrant information
     *
     * @param Registrant $registrant
     * @param array $additionalData
     * @return array
     */
    protected function preparePaymentData(Registrant $registrant, array $additionalData = []): array
    {
        return array_merge([
            'registrant_id' => $registrant->id,
            'confirmationCode' => $registrant->confirmationCode,
            'amount' => $registrant->netAmount,
            'currency' => 'SGD', // Singapore Dollar - ISO 4217 currency code
            'description' => "Registration for {$registrant->programme->title}",
            'customer_email' => $registrant->email,
            'customer_name' => "{$registrant->firstName} {$registrant->lastName}",
            'customer_phone' => $registrant->contactNumber,
            'customer_address' => $registrant->address ?? '',
            'contact_email' => $registrant->programme->contactEmail,
            'redirect_url' => route('payment.callback'),
            'webhook_url' => route('payment.webhook'),
        ], $additionalData);
    }

    /**
     * Update registrant with payment information
     *
     * @param Registrant $registrant
     * @param string $paymentMethod
     * @param array $response
     * @return void
     */
    protected function updateRegistrantPaymentInfo(Registrant $registrant, string $paymentMethod, array $response): void
    {
        $updateData = [
            'paymentOption' => $paymentMethod,
            'payment_gateway' => $paymentMethod,
            'payment_initiated_at' => now(),
        ];

        // Update payment reference number if provided
        if (isset($response['reference_no'])) {
            $updateData['paymentReferenceNo'] = $response['reference_no'];
        }

        // Update payment transaction ID if provided
        if (isset($response['payment_id'])) {
            $updateData['payment_transaction_id'] = $response['payment_id'];
            $updateData['payment_transaction_id'] = $response['payment_id'];
        } 
        else if (isset($response['reference_no']) && $paymentMethod === 'bank_transfer') {
            $updateData['payment_transaction_id'] = $response['reference_no'];
        }
        elseif (isset($response['session_id'])) {
            $updateData['payment_transaction_id'] = $response['session_id'];
        } elseif (isset($response['order_id'])) {
            $updateData['payment_transaction_id'] = $response['order_id'];
        }

        // Store payment metadata
        $updateData['payment_metadata'] = [
            'gateway_response' => $response,
            'initiated_at' => now()->toIso8601String(),
        ];

        // Update payment status if it's bank transfer (pending verification)
        if ($paymentMethod === 'bank_transfer') {
            $updateData['paymentStatus'] = 'pending_verification';
        }

        $registrant->update($updateData);
    }

    /**
     * Get all available payment methods
     *
     * @return array
     */
    public function getAvailablePaymentMethods(): array
    {
        return [
            [
                'key' => 'hitpay',
                'name' => 'HitPay',
                'description' => 'Pay with credit/debit card, PayNow, or e-wallets',
                'icon' => 'hitpay-icon',
                'enabled' => config('services.hitpay.enabled', false),
            ],
            [
                'key' => 'bank_transfer',
                'name' => 'Bank Transfer',
                'description' => 'Direct bank transfer',
                'icon' => 'bank-icon',
                'enabled' => true,
            ],
            // [
            //     'key' => 'stripe',
            //     'name' => 'Stripe',
            //     'description' => 'Pay with credit/debit card',
            //     'icon' => 'stripe-icon',
            //     'enabled' => config('services.stripe.enabled', false),
            // ],
            // [
            //     'key' => 'paypal',
            //     'name' => 'PayPal',
            //     'description' => 'Pay with PayPal account',
            //     'icon' => 'paypal-icon',
            //     'enabled' => config('services.paypal.enabled', false),
            // ],
        ];
    }

    private function generateRegCode($programmeCode)
    {
        // Count existing registrants for this programme
        $count = Registrant::where('programCode', $programmeCode)->count();
        
        // Increment to get the current registrant number
        $registrantNumber = $count + 1;
        
        // Pad with zeros (3 digits)
        $paddedNumber = str_pad($registrantNumber, 3, '0', STR_PAD_LEFT);
        
        // Generate registration code: PROGRAMMECODE_XXX
        $regCode = $programmeCode . '_' . $paddedNumber;
        
        // Check if regCode already exists (safety check)
        while (Registrant::where('regCode', $regCode)->exists()) {
            $registrantNumber++;
            $paddedNumber = str_pad($registrantNumber, 3, '0', STR_PAD_LEFT);
            $regCode = $programmeCode . '_' . $paddedNumber;
        }

        return $regCode;
    }
}

