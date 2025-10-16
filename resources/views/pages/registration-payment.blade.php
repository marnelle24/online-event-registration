@section('title', 'Payment Required')
{{-- @push('scripts')
    @vite(['resources/js/payment-service.js'])
@endpush --}}
<x-guest-layout>
    <!-- Load Payment Service Script Before Alpine Initializes -->
    <script src="{{ asset('js/payment-service.js') }}"></script>
    <script>
        // Define Alpine component before Alpine initializes
        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentPageData', (confirmationCode) => ({
                confirmationCode: confirmationCode,
                paymentService: null,
                processing: false,
                errorMessage: null,
                showBankTransferModal: false,
                bankTransferInstructions: {
                    bank_details: null
                },
                loadingBankDetails: false,

                init() {
                    this.paymentService = new PaymentService(this.confirmationCode);
                    // Make paymentService available globally for modal actions
                    window.paymentService = this.paymentService;
                    
                    // Pre-load bank transfer instructions to populate bank details
                    // this.loadBankTransferDetails();
                },

                async loadBankTransferDetails() {
                    this.loadingBankDetails = true;
                    try {
                        console.log('Pre-loading bank transfer details...');
                        const result = await this.paymentService.processPayment('bank_transfer');
                        
                        if (result.success && result.data && result.data.instructions) {
                            this.bankTransferInstructions = result.data.instructions;
                        }
                    } catch (error) {
                        console.error('Error loading bank details:', error);
                        // Silently fail - config defaults will be shown
                    } finally {
                        this.loadingBankDetails = false;
                    }
                },

                async processHitPayPayment() {
                    if (this.processing) return;

                    this.processing = true;
                    this.errorMessage = null;

                    try {
                        // Process payment with HitPay
                        const result = await this.paymentService.processPayment('hitpay');

                        if (result.success && result.data.redirect_url) {
                            // Redirect to HitPay payment page
                            window.location.href = result.data.redirect_url;
                        } else {
                            throw new Error('Payment gateway did not return a valid URL');
                        }
                    } catch (error) {
                        this.processing = false;
                        this.errorMessage = error.message || 'Payment processing failed. Please try again.';
                        console.error('Payment error:', error);

                        // Scroll to error message
                        this.$nextTick(() => {
                            this.$el.querySelector('[x-show="errorMessage"]')?.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'center' 
                            });
                        });
                    }
                },

                async processBankTransfer() 
                {
                    try 
                    {
                        console.log('Processing bank transfer...');
                        // If instructions are already loaded, just show the modal
                        if (this.bankTransferInstructions?.bank_details && this.bankTransferInstructions?.steps) {
                            console.log('Using cached bank transfer instructions');
                            this.showBankTransferModal = true;
                            return;
                        }

                        // Otherwise, fetch the instructions
                        console.log('Fetching bank transfer instructions...');
                        const result = await this.paymentService.processPayment('bank_transfer');
                        console.log('Bank transfer result:', result);

                        if (result.success && result.data && result.data.instructions) {
                            this.bankTransferInstructions = result.data.instructions;
                            this.showBankTransferModal = true;
                            console.log('Modal opened with instructions');
                        } else {
                            throw new Error('Failed to load bank transfer instructions');
                        }
                    } 
                    catch (error) 
                    {
                        console.error('Bank transfer error:', error);
                        this.errorMessage = error.message || 'Failed to process bank transfer. Please try again.';
                    } 
                }
            }));
        });
    </script>

    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-100/70 to-white/30 py-12" x-data="paymentPageData('{{ $registrant->confirmationCode }}')">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Payment Header -->
            <div class="bg-white rounded-lg shadow-lg border-t-4 {{ $isPaid ? 'border-green-500' : 'border-orange-500' }} overflow-hidden mb-8 p-8">
                <div class="flex items-center justify-center mb-6">
                    @if($isPaid)
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    @else
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    @endif
                </div>
                
                @if($isPaid)
                    <h1 class="text-3xl font-bold text-center text-slate-800 mb-2">Payment Completed</h1>
                    <p class="text-center text-slate-600 mb-6">Your payment has been successfully processed</p>
                    
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                        <p class="text-sm text-slate-600 mb-2">{{ $registrant->groupRegistrationID ? 'Group Confirmation Code' : 'Your Confirmation Code' }}</p>
                        <p class="text-3xl font-bold text-green-700 tracking-wider">{{ $registrant->groupRegistrationID ?? $registrant->confirmationCode }}</p>
                        {{-- <p class="text-sm text-green-600 mt-2">✓ Payment Status: {{ ucfirst(str_replace('_', ' ', $registrant->paymentStatus)) }}</p> --}}
                    </div>
                @else
                    <h1 class="text-3xl font-bold text-center text-slate-800 mb-2">Payment Required</h1>
                    <p class="text-center text-slate-600">Complete your payment to confirm your registration.</p>
                    @if(!$registrant->groupRegistrationID && $registrant->netAmount > 0)
                        <p class="text-center text-slate-600 mb-6">Registration code will be generated after payment is completed.</p>
                    @endif
                    
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 text-center">
                        <p class="text-sm text-slate-600 mb-2">{{ $registrant->groupRegistrationID ? 'Group Confirmation Code' : 'Your Confirmation Code' }}</p>
                        <p class="text-3xl font-bold text-orange-700 tracking-wider">{{ $registrant->groupRegistrationID ?? $registrant->confirmationCode }}</p>
                    </div>
                @endif
            </div>

            <!-- Programme Details -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4 pb-2 border-b">Programme Details</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-slate-500">Programme</p>
                        <p class="text-lg font-semibold text-slate-800">{{ $registrant->programme->title }}</p>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Date</p>
                            <p class="font-medium text-slate-800">{{ $registrant->programme->programmeDates }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Time</p>
                            <p class="font-medium text-slate-800">{{ $registrant->programme->programmeTimes }}</p>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        @if($registrant->programme->address)
                            <div>
                                <p class="text-sm text-slate-500">Location</p>
                                <p class="font-medium text-slate-800">{{ $registrant->programme->location }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-slate-500">Price</p>
                            <p class="font-medium text-slate-800">{{ $registrant->programme->price > 0 ? '$'.number_format($registrant->programme->price, 2) : 'Free' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registrant Information -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4 pb-2 border-b">Registrant Information</h2>
                
                <!-- Main Registrant -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-slate-700 mb-3">
                        @if($registrant->groupRegistrationID)
                            Main Registrant
                        @else
                            Your Details
                        @endif
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Name</p>
                            <p class="font-medium text-slate-800">{{ $registrant->title }} {{ $registrant->firstName }} {{ $registrant->lastName }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Email</p>
                            <p class="font-medium text-slate-800">{{ $registrant->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Contact Number</p>
                            <p class="font-medium text-slate-800">{{ $registrant->contactNumber }}</p>
                        </div>
                        @if($registrant->nric)
                        <div>
                            <p class="text-sm text-slate-500">NRIC/Passport</p>
                            <p class="font-medium text-slate-800">{{ $registrant->nric }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Group Members -->
                @if(count($groupMembers) > 0)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-slate-700 mb-4">Group Members ({{ count($groupMembers) }})</h3>
                    <div class="space-y-2">
                        @foreach($groupMembers as $index => $member)
                            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                <p class="font-semibold text-slate-800 mb-2">Member {{ $index + 2 }}</p>
                                <div class="grid md:grid-cols-3 gap-3 text-sm">
                                    <div>
                                        <p class="text-slate-600">Name</p>
                                        <p class="font-semibold text-lg text-slate-800">{{ $member->title }} {{ $member->firstName }} {{ $member->lastName }}</p>
                                        @if($member->groupRegistrationID && $member->paymentStatus == 'group_member_paid')
                                            <span class="text-xs text-slate-600 font-bold">Code:</span>
                                            <span class="text-xs text-green-600 font-bold">{{ $member->paymentReferenceNo }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-slate-600">Email</p>
                                        <p class="font-semibold text-lg text-slate-800">{{ $member->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-600">Contact</p>
                                        <p class="font-semibold text-lg text-slate-800">{{ $member->contactNumber }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Payment Summary -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4 pb-2 border-b">Payment Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Programme Fee:</span>
                        <span class="font-semibold text-slate-800 @if($registrant->programme->active_promotion) line-through @endif">${{ number_format($registrant->price, 2) }}</span>
                    </div>
                    @if($registrant->programme->active_promotion)
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 capitalize italic">{{ $registrant->programme->active_promotion->title }}</span>
                            <span class="font-semibold text-green-600">${{ number_format($registrant->programme->discounted_price, 2) }}</span>
                        </div>
                    @endif
                    
                    @if($registrant->promocode)
                        <div class="text-sm text-slate-600">
                            <p>Promo Code: <span class="font-medium text-slate-800">{{ $registrant->promocode->promocode }}</span></p>
                        </div>
                    @endif
                    <div class="border-t pt-3 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-slate-800">Total Amount Due:</span>
                            <span class="text-3xl font-bold text-green-600">${{ number_format($registrant->netAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Completed Info (Shown only if paid) -->
            @if($isPaid)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4 pb-2 border-b">Payment Information</h2>
                
                <div class="space-y-4">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-green-800 mb-2">Payment Successful</h3>
                                <p class="text-sm text-green-700 mb-3">Your payment has been processed and your registration is confirmed.</p>
                                
                                <div class="space-y-2 text-sm">
                                    @if($registrant->paymentReferenceNo)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Payment Reference:</span>
                                        <span class="font-semibold text-slate-800">{{ $registrant->paymentReferenceNo }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($registrant->payment_gateway)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Payment Method:</span>
                                        <span class="font-semibold text-slate-800">{{ ucfirst(str_replace('_', ' ', $registrant->payment_gateway)) }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($registrant->payment_completed_at)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Payment Date:</span>
                                        <span class="font-semibold text-slate-800">{{ $registrant->payment_completed_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Payment Methods (Hidden if already paid) -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 p-6" @if(!$isPaid) style="display: block;" @else style="display: none;" @endif>
                <h2 class="text-xl font-bold text-slate-800 mb-4 pb-2 border-b">Payment Methods</h2>
                
                <!-- Payment Options Grid -->
                <div class="space-y-4">
                    
                    <!-- Bank Transfer -->
                    <div class="border-2 border-slate-200 rounded-lg p-6 hover:bg-teal-50 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-slate-800 mb-2">Bank Transfer/Cheque Payment</h3>
                                <p class="text-sm text-slate-600">Transfer directly to our bank account</p>
                                <p class="text-sm text-slate-600 mb-3">Please use your registration code <strong>{{ $registrant->confirmationCode }}</strong> as payment reference</p>
                                
                                <div class="bg-blue-100/50 border border-blue-200 rounded-lg p-4 space-y-2 text-sm mb-4 relative">
                                    <!-- Loading indicator -->
                                    <div x-show="loadingBankDetails" class="absolute inset-0 bg-blue-50 bg-opacity-90 flex items-center justify-center rounded-lg">
                                        <div class="flex items-center space-x-2">
                                            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm text-blue-700">Loading bank details...</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Display bank details from API response if available, otherwise show config defaults -->
                                    <div class="flex justify-between" x-show="bankTransferInstructions?.bank_details?.bank_name || '{{ config('services.bank_transfer.bank_name') }}'">
                                        <span class="text-slate-600">Bank Name:</span>
                                        <span class="font-semibold text-slate-800" x-text="bankTransferInstructions?.bank_details?.bank_name || '{{ config('services.bank_transfer.bank_name', 'DBS Bank') }}'"></span>
                                    </div>
                                    <div class="flex justify-between" x-show="bankTransferInstructions?.bank_details?.account_number || '{{ config('services.bank_transfer.account_number') }}'">
                                        <span class="text-slate-600">Account Number:</span>
                                        <span class="font-semibold text-slate-800" x-text="bankTransferInstructions?.bank_details?.account_number || '{{ config('services.bank_transfer.account_number', '002-1234567-8') }}'"></span>
                                    </div>
                                    <div class="flex justify-between" x-show="bankTransferInstructions?.bank_details?.account_name || '{{ config('services.bank_transfer.account_name') }}'">
                                        <span class="text-slate-600">Account Name:</span>
                                        <span class="font-semibold text-slate-800" x-text="bankTransferInstructions?.bank_details?.account_name || '{{ config('services.bank_transfer.account_name', 'Streams Of Life Pte Ltd') }}'"></span>
                                    </div>
                                    <div class="flex justify-between" x-show="bankTransferInstructions?.bank_details?.swift_code || '{{ config('services.bank_transfer.swift_code') }}'">
                                        <span class="text-slate-600">Swift Code:</span>
                                        <span class="font-semibold text-slate-800" x-text="bankTransferInstructions?.bank_details?.swift_code || '{{ config('services.bank_transfer.swift_code', '21321') }}'"></span>
                                    </div>

                                    <!-- Optional bank details (only show if they exist in API response) -->
                                    <template x-if="bankTransferInstructions?.bank_details?.branch_code">
                                        <div class="flex justify-between">
                                            <span class="text-slate-600">Branch Code:</span>
                                            <span class="font-semibold text-slate-800" x-text="bankTransferInstructions.bank_details.branch_code"></span>
                                        </div>
                                    </template>
                                    <template x-if="bankTransferInstructions?.bank_details?.routing_number">
                                        <div class="flex justify-between">
                                            <span class="text-slate-600">Routing Number:</span>
                                            <span class="font-semibold text-slate-800" x-text="bankTransferInstructions.bank_details.routing_number"></span>
                                        </div>
                                    </template>
                                    <template x-if="bankTransferInstructions?.bank_details?.iban">
                                        <div class="flex justify-between">
                                            <span class="text-slate-600">IBAN:</span>
                                            <span class="font-semibold text-slate-800" x-text="bankTransferInstructions.bank_details.iban"></span>
                                        </div>
                                    </template>

                                    @if($registrant->programme->chequeCode)
                                        <div class="flex justify-between">
                                            <span class="text-slate-600">Cheque Code:</span>
                                            <span class="font-semibold text-slate-800">{{ $registrant->programme->chequeCode }}</span>
                                        </div>
                                    @endif
                                    <div class="border-t border-blue-200 pt-2 mt-2">
                                        <p class="text-md text-slate-600 flex items-center justify-between">
                                            <strong>Confirmation Code:</strong> 
                                            <span class="text-slate-800 font-semibold">{{ $registrant->confirmationCode }}</span>
                                        </p>
                                    </div>
                                </div>
                                <button type="button" 
                                        @click="processBankTransfer"
                                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors disabled:hover:bg-blue-600">
                                    View Detailed Instructions
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Credit/Debit Card / PayNow via HitPay -->
                    <div class="border-2 border-slate-200 hover:bg-teal-50 hover:shadow-lg transition-all duration-300 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#7C2278] rounded-lg flex items-center justify-center">
                                <img src="{{ asset('images/PayNow.png') }}" alt="PayNow" class="w-8">
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-slate-800 mb-2">Credit/Debit via PayNow</h3>
                                <p class="text-sm text-slate-600 mb-3">Pay securely with your card, PayNow, or e-wallets via HitPay</p>
                                
                                <!-- Error Message -->
                                <div x-show="errorMessage" 
                                     x-transition
                                     class="mb-3 bg-red-50 border border-red-200 rounded-lg p-3">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-sm text-red-800" x-text="errorMessage"></p>
                                    </div>
                                </div>
                                
                                <button type="button" 
                                        @click="processHitPayPayment"
                                        :disabled="processing"
                                        :class="{'opacity-50 cursor-not-allowed': processing}"
                                        class="hover:-translate-y-0.5 hover:shadow-lg duration-300 transition-all w-full mt-4 bg-[#7C2278]/90 uppercase tracking-wider text-white py-3 px-6 rounded-lg font-semibold hover:bg-[#7C2278] disabled:hover:translate-y-0">
                                    <span x-show="!processing">Pay ${{ number_format($registrant->netAmount, 2) }} with PayNow</span>
                                    <span x-show="processing" class="flex items-center justify-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                                
                                <p class="text-[11px] text-slate-500 mt-2 text-center">Secured by HitPay with SSL encryption</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h2 class="text-lg font-bold text-blue-900 mb-3">Need Help?</h2>
                <p class="text-sm text-blue-800 mb-3">
                    If you have any questions about payment or encounter any issues, please contact us:
                </p>
                <div class="space-y-2 text-sm text-blue-900">
                    <p class="flex items-center text-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <strong>Email:</strong> <span class="ml-1">{{ $registrant->programme->contactEmail }}</span>
                    </p>
                    <p class="flex items-center text-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <strong>Phone:</strong> <span class="ml-1">{{ $registrant->programme->contactNumber }}</span>
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center py-8">
                @if($isPaid)
                    <!-- Show confirmation page button if paid -->
                    <a href="{{ route('registration.confirmation', ['confirmationCode' => $registrant->confirmationCode]) }}" 
                       class="inline-flex border border-green-600 duration-300 transition-all items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        View Confirmation
                    </a>
                @endif
                
                <a href="{{ route('frontpage') }}" 
                   class="inline-flex border border-slate-300 duration-300 transition-all items-center justify-center px-6 py-3 bg-slate-200 text-slate-700 rounded-lg font-semibold hover:bg-slate-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Back to Home
                </a>
            </div>

        </div>
        <!-- End max-w-4xl container -->

        <!-- Bank Transfer Modal Component -->
        <x-bank-transfer-modal />
    </div>
    <!-- End Alpine.js scope -->
    
    
    <x-footer-public />
</x-guest-layout>

@push('styles')
<style>
    /* Hide elements with x-cloak until Alpine loads */
    [x-cloak] {
        display: none !important;
    }
    
    /* Print styles for bank transfer modal */
    @media print {
        body * {
            visibility: hidden;
        }
        .bank-transfer-modal,
        .bank-transfer-modal * {
            visibility: visible;
        }
        .bank-transfer-modal {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
@endpush

