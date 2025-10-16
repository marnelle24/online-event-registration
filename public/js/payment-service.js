/**
 * Payment Service Helper
 * Frontend JavaScript helper for payment gateway integration
 */

class PaymentService {
    constructor(confirmationCode) {
        this.confirmationCode = confirmationCode;
        this.baseUrl = '/api';
    }

    /**
     * Get available payment methods
     * @returns {Promise<Object>}
     */
    async getPaymentMethods() {
        try {
            const response = await fetch(`${this.baseUrl}/payment-methods/${this.confirmationCode}`);
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Failed to load payment methods');
            }
            
            return data;
        } catch (error) {
            console.error('Error fetching payment methods:', error);
            throw error;
        }
    }

    /**
     * Process payment with selected method
     * @param {string} paymentMethod - Payment method key (hitpay, stripe, paypal, bank_transfer)
     * @param {Object} additionalData - Additional payment data if needed
     * @returns {Promise<Object>}
     */
    async processPayment(paymentMethod, additionalData = {}) {
        try {
            const response = await fetch(`${this.baseUrl}/process-payment/${this.confirmationCode}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({
                    payment_method: paymentMethod,
                    ...additionalData
                })
            });

            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Payment processing failed');
            }
            
            return data;
        } catch (error) {
            console.error('Error processing payment:', error);
            throw error;
        }
    }

    /**
     * Handle payment method selection and initiate payment
     * @param {string} paymentMethod
     * @returns {Promise<void>}
     */
    async initiatePayment(paymentMethod) {
        try {
            // Show loading state
            this.showLoading();

            // Process payment
            const result = await this.processPayment(paymentMethod);

            // Handle different payment methods
            switch (paymentMethod) {
                case 'bank_transfer':
                    this.handleBankTransfer(result.data);
                    break;
                    
                case 'hitpay':
                case 'stripe':
                case 'paypal':
                    this.handleGatewayRedirect(result.data);
                    break;
                    
                default:
                    throw new Error('Unknown payment method');
            }
        } catch (error) {
            this.hideLoading();
            this.showError(error.message);
        }
    }

    /**
     * Handle bank transfer instructions
     * @param {Object} data
     */
    handleBankTransfer(data) {
        this.hideLoading();
        
        if (data.instructions) {
            this.showBankTransferModal(data.instructions);
        }
    }

    /**
     * Handle payment gateway redirect
     * @param {Object} data
     */
    handleGatewayRedirect(data) {
        if (data.redirect_url || data.payment_url) {
            const url = data.redirect_url || data.payment_url;
            window.location.href = url;
        } else {
            this.hideLoading();
            this.showError('Payment URL not received');
        }
    }

    /**
     * Handle bank transfer instructions
     * @param {Object} data
     */
    handleBankTransfer(data) {
        this.hideLoading();
        
        if (data.instructions) {
            // Bank transfer modal is now handled by the Blade component
            // The calling page should handle showing the modal with the instructions
            console.log('Bank transfer instructions received:', data.instructions);
        }
    }

    /**
     * Show loading state
     */
    showLoading() {
        // You can implement your loading UI here
        const loader = document.getElementById('payment-loader');
        if (loader) {
            loader.classList.remove('hidden');
        }
    }

    /**
     * Hide loading state
     */
    hideLoading() {
        const loader = document.getElementById('payment-loader');
        if (loader) {
            loader.classList.add('hidden');
        }
    }

    /**
     * Show error message
     * @param {string} message
     */
    showError(message) {
        // You can implement your error UI here
        alert(message); // Simple fallback
        console.error('Payment error:', message);
    }
}

// Make PaymentService available globally
window.PaymentService = PaymentService;

// Example usage:
// const paymentService = new PaymentService('EVENT2025_001');
// paymentService.initiatePayment('stripe');

