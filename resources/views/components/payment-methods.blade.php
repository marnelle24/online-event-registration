@props(['regCode', 'amount', 'currency' => 'SGD'])

<div class="payment-methods-container" x-data="paymentMethodsComponent('{{ $regCode }}')">
    <!-- Loading State -->
    <div id="payment-loader" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-600">Processing payment...</p>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="space-y-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Payment Method</h3>
        
        <!-- Payment Amount Summary -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-gray-700 font-medium">Total Amount:</span>
                <span class="text-2xl font-bold text-blue-900">{{ $currency }} {{ number_format($amount, 2) }}</span>
            </div>
        </div>

        <!-- Payment Methods Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="paymentMethods.length > 0">
            <template x-for="method in paymentMethods" :key="method.key">
                <div 
                    @click="selectPaymentMethod(method.key)"
                    :class="{'border-blue-500 bg-blue-50': selectedMethod === method.key, 'border-gray-300': selectedMethod !== method.key}"
                    class="border-2 rounded-lg p-4 cursor-pointer hover:border-blue-400 transition-colors duration-200"
                    x-show="method.enabled"
                >
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-white border-2 border-gray-300 flex items-center justify-center">
                                <svg x-show="selectedMethod === method.key" class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <h4 class="text-base font-semibold text-gray-900" x-text="method.name"></h4>
                            <p class="text-sm text-gray-600 mt-1" x-text="method.description"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Error Message -->
        <div x-show="errorMessage" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="ml-3 text-sm text-red-800" x-text="errorMessage"></p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
            <button 
                type="button"
                onclick="window.history.back()"
                class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Back
            </button>
            <button 
                type="button"
                @click="processPayment"
                :disabled="!selectedMethod || processing"
                :class="{'opacity-50 cursor-not-allowed': !selectedMethod || processing}"
                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-medium"
            >
                <span x-show="!processing">Proceed to Payment</span>
                <span x-show="processing">Processing...</span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function paymentMethodsComponent(regCode) {
        return {
            regCode: regCode,
            paymentService: null,
            paymentMethods: [],
            selectedMethod: null,
            processing: false,
            errorMessage: null,

            init() {
                this.paymentService = new PaymentService(this.regCode);
                this.loadPaymentMethods();
                
                // Make paymentService available globally for modal actions
                window.paymentService = this.paymentService;
            },

            async loadPaymentMethods() {
                try {
                    const data = await this.paymentService.getPaymentMethods();
                    this.paymentMethods = data.payment_methods.filter(method => method.enabled);
                    
                    // Auto-select first enabled method
                    if (this.paymentMethods.length > 0) {
                        this.selectedMethod = this.paymentMethods[0].key;
                    }
                } catch (error) {
                    this.errorMessage = 'Failed to load payment methods. Please refresh the page.';
                    console.error('Error loading payment methods:', error);
                }
            },

            selectPaymentMethod(methodKey) {
                this.selectedMethod = methodKey;
                this.errorMessage = null;
            },

            async processPayment() {
                if (!this.selectedMethod || this.processing) {
                    return;
                }

                this.processing = true;
                this.errorMessage = null;

                try {
                    await this.paymentService.initiatePayment(this.selectedMethod);
                } catch (error) {
                    this.processing = false;
                    this.errorMessage = error.message || 'Payment processing failed. Please try again.';
                }
            }
        }
    }
</script>
@endpush

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #bank-transfer-modal,
        #bank-transfer-modal * {
            visibility: visible;
        }
        #bank-transfer-modal {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
@endpush

