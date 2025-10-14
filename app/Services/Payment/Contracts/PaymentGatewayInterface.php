<?php

namespace App\Services\Payment\Contracts;

interface PaymentGatewayInterface
{
    /**
     * Initialize payment with the gateway
     *
     * @param array $paymentData
     * @return array
     */
    public function initiatePayment(array $paymentData): array;

    /**
     * Verify payment callback
     *
     * @param array $callbackData
     * @return array
     */
    public function verifyPayment(array $callbackData): array;

    /**
     * Get payment status
     *
     * @param string $referenceNo
     * @return array
     */
    public function getPaymentStatus(string $referenceNo): array;

    /**
     * Process refund
     *
     * @param string $referenceNo
     * @param float $amount
     * @return array
     */
    public function refundPayment(string $referenceNo, float $amount): array;

    /**
     * Get gateway name
     *
     * @return string
     */
    public function getGatewayName(): string;
}

