<div class="space-y-8">
    {{-- display the ->with() --}}
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-slate-200">
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-5">
            {{-- <h1 class="text-white text-2xl font-semibold tracking-wide">
                Payment for {{ $registrant?->programme?->title }}
            </h1> --}}
            <div class="text-teal-100 flex flex-col">
                <p class="font-normal text-sm">Confirmation Code:</p> 
                <p class="font-semibold text-2xl drop-shadow">{{ $confirmationCode }}</p>
            </div>
        </div>

        <div class="p-6 space-y-8">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                        <h3 class="text-lg tracking-wider uppercase font-bold text-slate-800 bg-slate-100 p-3">Registration Summary</h3>
                        {{-- add there the main registrant details --}}
                        <div class="bg-white">
                            <dl class="space-y-2 text-sm text-slate-600 p-4 border border-t-0 border-x-1 border-b border-slate-200 rounded-b-lg">
                                @if($groupMembers->isNotEmpty())
                                    <h3 class="text-md font-semibold text-slate-800 mb-4">Main Registrant Details</h3>
                                @endif
                                <div class="flex justify-between">
                                    <dt>Name</dt>
                                    <dd class="text-right font-medium text-slate-800">{{ $registrant?->title }} {{ $registrant?->firstName }} {{ $registrant?->lastName }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Email</dt>
                                    <dd class="text-right font-medium text-slate-800">{{ $registrant?->email }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Contact Number</dt>
                                    <dd class="text-right font-medium text-slate-800">{{ $registrant?->contactNumber }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Address</dt>
                                    <dd class="text-right font-medium text-slate-800">{{ $registrant?->address }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>City</dt>
                                    <dd class="text-right font-medium text-slate-800">{{ $registrant?->city . ', ' . $registrant?->state . ' ' . $registrant?->postalCode }}</dd>
                                </div>
                            </dl>
                            
                            {{-- add the group members details --}}
                            @if($groupMembers->isNotEmpty())
                                <h3 class="text-lg tracking-wider uppercase font-bold text-slate-800 mt-4 bg-slate-100 p-3">Group Members</h3>
                                <ul class="space-y-3 text-sm text-slate-600 p-4 border border-t-0 border-x-1 border-b border-slate-200 rounded-b-lg">
                                    @foreach($groupMembers as $index => $member)
                                        <li class="flex md:flex-row flex-col md:justify-between justify-start">
                                            <span class="md:text-right text-left">
                                                <span class="md:text-sm text-lg font-semibold text-slate-800">
                                                    {{ '#'.($index + 1) }} {{ $member?->title }} {{ $member?->firstName }} {{ $member?->lastName }} 
                                                </span>
                                                @if($index == 0)
                                                    <span class="text-slate-500 italic font-semibold">(Main Registrant)</span>
                                                @endif
                                            </span>
                                            <span class="md:block hidden text-right">{{ $member?->contactNumber }}</span>
                                            <span class="md:hidden block text-left ml-4">{{ $member?->contactNumber }}</span>
                                            
                                            <span class="md:block hidden text-right">{{ $member?->email }}</span>
                                            <span class="md:hidden block text-left ml-4 italic">({{ $member?->email }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
    
                        </div>
                </div>
                <div class="md:col-span-1 space-y-6">
                    <div class="border border-slate-200 rounded-xl p-5 shadow-sm bg-slate-100">
                        <h3 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-3">
                            Payment Summary
                        </h3>

                        <dl class="mt-4 space-y-5 text-sm text-slate-600">
                            <div class="flex flex-col">
                                <dt class="text-sm font-semibold text-slate-400">Programme</dt>
                                <dd class="text-xl leading-tight font-bold text-slate-800">{{ $registrant?->programme?->title }}</dd>
                            </div>
                            @if($registrant?->groupRegistrationID)
                                <div class="flex flex-col gap-2">
                                    <dt class="text-sm font-semibold text-slate-400">No of tickets</dt>
                                    <dd class="text-md font-bold text-slate-800">
                                        <span class="text-yellow-600 bg-yellow-100 px-2 py-1 rounded-md">
                                            @php
                                                $noOfTickets = $groupMembers->count();
                                                // Use promotion's maxGroup if promotion exists and is a group promotion, otherwise use programme default
                                                $maxTickets = ($registrant?->promotion && $registrant->promotion->isGroup && $registrant->promotion->maxGroup)
                                                    ? $registrant->promotion->maxGroup
                                                    : ($registrant?->programme?->groupRegistrationMax ?? 10);
                                            @endphp
                                            {{ $noOfTickets.'/'.$maxTickets.' ticket'.($noOfTickets > 1 ? 's' : '') }}
                                        </span>
                                    </dd>
                                </div>
                            @endif
                            <div class="flex flex-col gap-2">
                                <dt class="text-sm font-semibold text-slate-400">Promotion</dt>
                                <dd class="text-md leading-tight font-bold text-slate-800">
                                    @if($registrant?->promotion?->title)
                                        <span class="text-green-500 bg-green-100 px-2 py-1 rounded-md">
                                            {{ $registrant?->promotion?->title }}
                                        </span>
                                    @else
                                        <span class="text-red-500 bg-red-100 px-2 py-1 rounded-md">
                                            No promotion applied
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="flex flex-col gap-2">
                                <dt class="text-sm font-semibold text-slate-400">Promocode applied</dt>
                                <dd class="text-md leading-tight font-bold text-slate-800">
                                    @if($registrant?->promocode?->promocode)
                                        <span class="text-blue-500 bg-blue-100 px-2 py-1 rounded-md">
                                            {{ $registrant?->promocode?->promocode }}
                                        </span>
                                    @else
                                        <span class="text-red-500 bg-red-100 px-2 py-1 rounded-md">
                                            No promocode applied
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-5 border-t border-slate-200 pt-4 space-y-4">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Standard Fee</span>
                                    <span class="{{ ($registrant?->discountAmount > 0 || $registrant?->promocode?->discountAmount > 0) ? 'line-through' : '' }}">${{ number_format($registrant?->price ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Promotion Discount</span>
                                    <span class="{{ ($registrant?->discountAmount > 0) ? 'text-green-600' : 'text-red-600' }}">${{ number_format($registrant?->discountAmount ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Promocode Applied</span>
                                    <span>${{ number_format($registrant?->promocode?->price ?? 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between text-xl font-bold text-green-600">
                                <span>Amount Due</span>
                                <span>${{ number_format($registrant?->netAmount ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!$isPaid)
        <div class="p-6">
            <hr class="border-slate-400/60 border border-dashed" />
            @if(!$isPaymentInitiated)
                <br />
                <br />
                <h3 class="text-lg tracking-normal uppercase font-bold text-slate-800">
                    {{ 'Choose a Payment Methods' }}
                </h3>
            @endif
            <div class="space-y-4 mt-4">
                @if($isPaymentInitiated)
                    @php 
                        $paymentOption = '';
                        if($registrant->paymentOption === 'hitpay')
                            $paymentOption = 'PayNow App';
                        elseif($registrant->paymentOption === 'bank_transfer')
                            $paymentOption = 'Bank Transfer or Cheque Payment';
                    @endphp
                    <div class="bg-amber-50 border border-amber-200 text-amber-700 rounded-lg px-4 py-3 text-sm">
                        This registration has already initiated a payment via <strong>{{ $paymentOption }}</strong> and 
                        is subject for verification. Please wait for the payment to be verfified. 
                        Registration confirmation will be sent to the main registrant email address.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($paymentMethods as $method)
                            @if($method['key'] === 'hitpay')
                                <div class="border-2 border-slate-200 hover:border-slate-300 bg-slate-100 hover:bg-slate-200 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 rounded-lg p-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-12 h-12 bg-[#7C2278] rounded-lg flex items-center justify-center">
                                            <img src="{{ asset('images/PayNow.png') }}" alt="PayNow" class="w-8">
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-lg font-semibold text-slate-800 mb-2">Credit/Debit via PayNow App</h3>
                                            <p class="text-sm text-slate-600 mb-3">Pay securely with your card, PayNow, or e-wallets via HitPay</p>
                                            
                                            <!-- Error Message -->
                                            @if($hitpayError)
                                                <div class="mb-3 bg-red-50 border border-red-200 rounded-lg p-3">
                                                    <div class="flex">
                                                        <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <p class="text-sm text-red-800">{{ $hitpayError }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <button type="button" 
                                                    wire:click="processHitPayPayment"
                                                    wire:loading.attr="disabled"
                                                    wire:target="processHitPayPayment"
                                                    class="hover:-translate-y-0.5 hover:shadow-lg duration-300 transition-all flex items-center justify-center gap-2 w-full mt-4 bg-[#7C2278]/90 uppercase tracking-wider text-white py-3 px-6 rounded-lg font-semibold hover:bg-[#7C2278] disabled:hover:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed">
                                                <span wire:loading.remove wire:target="processHitPayPayment">Pay ${{ number_format($registrant->netAmount ?? 0, 2) }} with PayNow</span>
                                                <span wire:loading wire:target="processHitPayPayment" class="inline-flex items-center gap-2">
                                                    <span>Processing...</span>
                                                </span>
                                            </button>
                                            <p class="text-[11px] text-slate-500 mt-2 text-center">Secured by HitPay with SSL encryption</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="border-2 border-slate-200 hover:border-slate-300 bg-slate-100 hover:bg-slate-200 rounded-lg p-6 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-lg font-semibold text-slate-800 mb-2">Bank Transfer or Cheque Payment</h3>
                                            <p class="text-sm text-slate-600 mb-3">Transfer directly to our bank account. Please use your registration code <strong>{{ $registrant?->confirmationCode }}</strong> as payment reference</p>
                                            <button type="button" 
                                                    wire:click="showBankTransferInstructions"
                                                    wire:loading.attr="disabled"
                                                    class="w-full bg-teal-600 hover:bg-teal-700 hover:-translate-y-0.5 hover:shadow-lg text-white py-3 px-6 rounded-md font-semibold transition-all duration-300 disabled:hover:bg-teal-600 disabled:opacity-50">
                                                <span wire:loading.remove wire:target="showBankTransferInstructions">Check Bank Payment Instructions</span>
                                                <span wire:loading wire:target="showBankTransferInstructions">Loading...</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if($selectedMethod === 'bank_transfer' && !empty($bankTransferInstructions))
                        <div class="pt-4">
                            <button
                                type="button"
                                wire:click="$set('showBankTransferModal', true)"
                                class="text-sm font-semibold text-teal-600 hover:text-teal-700 transition"
                            >
                                View Bank Transfer Instructions
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @endif
    </div>

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
                <strong>Email:</strong> 
                <a href="mailto:{{ $registrant?->programme?->contactEmail }}" class="ml-1 hover:underline">
                    {{ $registrant?->programme?->contactEmail }}
                </a>
            </p>
            <p class="flex items-center text-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <strong>Phone:</strong> <span class="ml-1">{{ $registrant?->programme?->contactNumber }}</span>
            </p>
        </div>
    </div>

    @if($showBankTransferModal && !empty($bankTransferInstructions))
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6">
            <div class="absolute -top-8 inset-0 bg-slate-900/60 backdrop-blur-sm" wire:click="closeBankTransferModal"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full border border-slate-200 overflow-hidden">
                <div class="flex items-start justify-between px-6 py-4 border-b border-slate-200">
                    <div>
                        <h3 class="text-xl font-semibold text-slate-800">
                            {{ $bankTransferInstructions['title'] ?? 'Bank Transfer Instructions' }}
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Please follow the steps below to complete your bank transfer.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeBankTransferModal"
                        class="text-slate-400 hover:text-slate-600 transition"
                        aria-label="Close bank transfer instructions"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-6 space-y-5 max-h-[70vh] overflow-y-auto">
                    @if(!empty($bankTransferInstructions['reference_no']))
                        <div class="bg-slate-100 rounded-lg px-4 py-3">
                            <p class="text-xs font-semibold text-slate-600 uppercase tracking-wide">Reference Number</p>
                            <p class="text-lg font-semibold text-teal-600 tracking-wide">
                                {{ $bankTransferInstructions['reference_no'] }}
                            </p>
                        </div>
                    @endif

                    @if(!empty($bankTransferInstructions['bank_details']))
                        <div class="border border-slate-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Bank Details</h4>
                            <dl class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-slate-600">
                                @foreach($bankTransferInstructions['bank_details'] as $label => $value)
                                    @if(!empty($value))
                                        <div>
                                            <dt class="font-semibold capitalize">{{ str_replace('_', ' ', $label) }}</dt>
                                            <dd>{{ $value }}</dd>
                                        </div>
                                    @endif
                                @endforeach
                            </dl>
                        </div>
                    @endif

                    @if(!empty($bankTransferInstructions['steps']))
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Bank Transfer/Cheque Payment Instructions</h4>
                            <ol class="space-y-2 list-decimal list-inside text-sm text-slate-600">
                                @foreach($bankTransferInstructions['steps'] as $step)
                                    <li class="flex gap-2 items-start py-2">
                                        <div class="flex">
                                            <p class="text-sm font-semibold rounded-full px-2.5 py-1 bg-sky-500 text-white">{{ $step['step'] }}</p>
                                        </div>
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="font-semibold text-slate-700">{{ $step['title'] ?? 'Step '.$step['step'] }}</span>
                                            <div class="text-slate-600 text-sm">{!! $step['content'] ?? '' !!}</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if(!empty($bankTransferInstructions['important_notes']))
                        <div class="bg-amber-50 border border-amber-200 rounded-lg px-4 py-3 space-y-2">
                            <h4 class="text-sm font-semibold text-amber-700 uppercase tracking-wide">Important Notes</h4>
                            <ul class="list-disc list-inside text-sm text-amber-700 space-y-1">
                                @foreach($bankTransferInstructions['important_notes'] as $note)
                                    <li>{{ $note }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-end">
                    <button
                        type="button"
                        wire:click="closeBankTransferModal"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-teal-600 hover:text-teal-700 transition"
                    >
                        Close
                    </button>
                    {{-- add initiate payment button --}}
                    <button
                        type="button"
                        wire:click="initiateBankTransferPayment"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 rounded-md"
                    >
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        window.addEventListener('payment-redirect', event => {
            const url = event.detail?.url;
            if (url) {
                window.location.href = url;
            }
        });
    </script>
@endpush

