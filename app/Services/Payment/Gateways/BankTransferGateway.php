<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Str;

class BankTransferGateway implements PaymentGatewayInterface
{
    /**
     * Initiate bank transfer payment (returns instructions)
     *
     * @param array $paymentData
     * @return array
     */
    public function initiatePayment(array $paymentData): array
    {
        // Generate a unique reference number for tracking
        $referenceNo = $paymentData['regCode'] . '_' . strtoupper(Str::random(6));

        return [
            'status' => 'pending_transfer',
            'reference_no' => $referenceNo,
            'payment_method' => 'bank_transfer',
            'instructions' => $this->getBankTransferInstructions($paymentData, $referenceNo),
        ];
    }

    /**
     * Get bank transfer instructions
     *
     * @param array $paymentData
     * @param string $referenceNo
     * @return array
     */
    protected function getBankTransferInstructions(array $paymentData, string $referenceNo): array
    {
        // Get bank details
        $bankDetails = $this->getBankDetails();

        // Build steps array
        $steps = [];
        
        // Only include bank details step if bank details exist
        if (!empty($bankDetails)) {
            $steps[] = [
                'step' => count($steps) + 1,
                'title' => 'Bank Details',
                'content' => $bankDetails,
            ];
        }
        
        $steps[] = [
            'step' => count($steps) + 1,
            'title' => 'Transfer Amount',
            'content' => "Please transfer exactly <strong>{$paymentData['currency']} " . number_format($paymentData['amount'], 2) . "</strong>",
        ];
        
        $steps[] = [
            'step' => count($steps) + 1,
            'title' => 'Reference Number',
            'content' => "Use this reference number in your transfer: <strong>{$referenceNo}</strong><br>This helps us identify your payment.",
        ];
        
        $steps[] = [
            'step' => count($steps) + 1,
            'title' => 'Send Proof',
            'content' => "After making the transfer, please send your payment proof (screenshot or receipt) to:<br><strong>" . config('mail.from.address', 'payments@example.com') . "</strong><br>Include your registration code: <strong>{$paymentData['regCode']}</strong>",
        ];
        
        $steps[] = [
            'step' => count($steps) + 1,
            'title' => 'Confirmation',
            'content' => "Once we verify your payment (usually within 1-2 business days), you will receive a confirmation email.",
        ];

        return [
            'title' => 'Bank Transfer Instructions',
            'amount' => $paymentData['amount'],
            'currency' => $paymentData['currency'],
            'reference_no' => $referenceNo,
            'bank_details' => $this->getBankDetailsStructured(),
            'steps' => $steps,
            'important_notes' => [
                'Please ensure the exact amount is transferred to avoid delays in processing.',
                'Keep your transfer receipt for your records.',
                'Payment verification may take 1-2 business days.',
                'You will receive a confirmation email once payment is verified.',
            ],
        ];
    }

    /**
     * Get bank account details as structured array
     *
     * @return array
     */
    protected function getBankDetailsStructured(): array
    {
        $bankConfig = config('services.bank_transfer');
        
        return [
            'bank_name' => $bankConfig['bank_name'] ?? '',
            'account_name' => $bankConfig['account_name'] ?? '',
            'account_number' => $bankConfig['account_number'] ?? '',
            'swift_code' => $bankConfig['swift_code'] ?? '',
            'branch_code' => $bankConfig['branch_code'] ?? '',
            'routing_number' => $bankConfig['routing_number'] ?? '',
            'iban' => $bankConfig['iban'] ?? '',
        ];
    }

    /**
     * Get bank account details from configuration (HTML format)
     *
     * @return string
     */
    protected function getBankDetails(): string
    {
        // Get bank transfer configuration
        $bankConfig = config('services.bank_transfer');
        
        // Define the bank detail fields and their display labels in order of importance
        $bankFields = [
            'bank_name' => 'Bank Name',
            'account_name' => 'Account Name', 
            'account_number' => 'Account Number',
            'swift_code' => 'SWIFT Code',
            'branch_code' => 'Branch Code',
            'routing_number' => 'Routing Number',
            'iban' => 'IBAN',
        ];
        
        $details = '';
        $hasAnyDetails = false;
        
        // Loop through each bank field and add to details if it exists and is not empty
        foreach ($bankFields as $configKey => $displayLabel) 
        {
            $value = $bankConfig[$configKey] ?? '';
            
            if (!empty($value)) 
            {
                $details .= "<strong>{$displayLabel}:</strong> {$value}<br>";
                $hasAnyDetails = true;
            }
        }
        
        // Return empty string if no bank details are configured
        return $hasAnyDetails ? $details : '';
    }

    /**
     * Verify bank transfer payment
     * Note: This requires manual verification by admin
     *
     * @param array $callbackData
     * @return array
     */
    public function verifyPayment(array $callbackData): array
    {
        // Bank transfers require manual verification
        // This method would be called by admin after verifying the payment
        
        return [
            'verified' => $callbackData['verified'] ?? false,
            'status' => $callbackData['status'] ?? 'pending_verification',
            'reference_no' => $callbackData['reference_no'] ?? null,
            'verified_by' => $callbackData['verified_by'] ?? null,
            'verified_at' => $callbackData['verified_at'] ?? now(),
            'notes' => $callbackData['notes'] ?? null,
        ];
    }

    /**
     * Get bank transfer payment status
     *
     * @param string $referenceNo
     * @return array
     */
    public function getPaymentStatus(string $referenceNo): array
    {
        // This would check the database for manual verification status
        return [
            'status' => 'pending_verification',
            'reference_no' => $referenceNo,
            'message' => 'Bank transfer requires manual verification by administrator',
        ];
    }

    /**
     * Process refund for bank transfer
     *
     * @param string $referenceNo
     * @param float $amount
     * @return array
     */
    public function refundPayment(string $referenceNo, float $amount): array
    {
        // Bank transfer refunds would be processed manually
        return [
            'success' => false,
            'message' => 'Bank transfer refunds must be processed manually. Please contact administrator.',
            'reference_no' => $referenceNo,
            'amount' => $amount,
        ];
    }

    /**
     * Get gateway name
     *
     * @return string
     */
    public function getGatewayName(): string
    {
        return 'Bank Transfer';
    }
}

