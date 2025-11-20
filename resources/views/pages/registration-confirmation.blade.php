@section('title', 'Registration Confirmation - Official Receipt')
<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-100/70 to-white/30 py-8 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif --}}
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif
            {{-- @dump($registrant) --}}
            <!-- Official Receipt Container -->
            <div class="bg-white print-container rounded-lg shadow-xl border border-slate-500 overflow-hidden">
                <!-- Receipt Header -->
                <div class="bg-gradient-to-r from-teal-600 to-teal-700 text-white p-6 md:p-8 border-b-2 border-teal-600">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h1 class="text-xl md:text-2xl font-bold">CONFIRMATION RECEIPT</h1>
                            <p class="text-teal-100 text-xs md:text-lg font-mono">Ref #: {{ $registrant->groupRegistrationID ?? $registrant->confirmationCode }}</p>
                            {{-- <p class="text-teal-100 text-sm md:text-base">Registration Confirmation</p> --}}
                        </div>
                        <div class="text-left md:text-right">
                            <p class="text-sm text-teal-100 md:mb-1 mb-0">Receipt Date</p>
                            <p class="text-lg font-semibold">{{ now()->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Receipt Body -->
                <div class="p-6 md:p-8 space-y-6 border-b border-slate-400">
                    <div class="flex flex-col md:flex-row gap-4">
                        @if($registrant->programme->getFirstMediaUrl('thumbnail'))
                            <img 
                                src="{{ $registrant->programme->getFirstMediaUrl('thumbnail') }}" 
                                alt="{{ $registrant->programme->title }}" 
                                class="flex h-56 w-full md:w-1/2 object-cover no-print"
                            />
                        @endif
        
                        <div class="flex flex-col justify-between gap-2 md:flex-row">
                            <div class="flex-1">
                                <h1 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">{{ $registrant->programme->title }}</h1>
                                <p class="flex items-center text-base text-teal-700/80 font-thin mb-4">
                                    <img src="{{ $registrant->programme->ministry->getFirstMediaUrl('ministry') }}" alt="{{ $registrant->programme->ministry->name }}" class="w-5 h-5">
                                    &nbsp;{{ $registrant->programme->ministry->name }}
                                </p>
        
                                <div class="flex flex-col gap-1 text-sm md:text-base text-slate-600">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $registrant->programme->programmeDates }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0Z" />
                                        </svg>
                                        <span>{{ $registrant->programme->programmeTimes }}</span>
                                    </div>
                                @if($registrant->programme->location)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $registrant->programme->location }}</span>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Registration Status Badge -->
                    <div class="flex justify-center mb-4">
                        @if($registrant->paymentStatus == 'paid' || $registrant->netAmount <= 0)
                            <span class="inline-flex items-center px-4 py-2 my-4 bg-green-100 text-green-800 rounded-full font-semibold text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                You're registration is officially confirmed
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-800 rounded-full font-semibold text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Payment Pending
                            </span>
                        @endif
                    </div>

                    <!-- Registration Code -->
                    <div class="bg-slate-50 border-2 border-slate-200 rounded-lg p-6 text-center">
                        <p class="text-sm text-slate-600 mb-2 font-medium">
                            {{ $registrant->groupRegistrationID ? 'Your Group Registration Code' : 'Your Registration No' }}
                        </p>
                        <p class="text-3xl md:text-4xl font-bold text-teal-700 tracking-none font-mono">
                            {{ $registrant->groupRegistrationID ? $registrant->confirmationCode : $registrant->regCode }}
                        </p>
                        <!-- QR Code -->
                        <div class="mt-4 flex justify-center">
                            <div class="bg-white p-3 rounded-lg inline-block">
                                <div id="qrcode"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Registrant Information -->
                    <div class="">
                        <h2 class="text-xl font-bold text-slate-800 mb-6 mt-4">Registrant Information</h2>
                        
                        <!-- Main Registrant -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-slate-700 mb-3">
                                {{-- @if($registrant->groupRegistrationID)
                                    Main Registrant
                                @else
                                    Participant Details
                                @endif --}}
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Full Name</p>
                                    <p class="font-medium text-slate-800">{{ $registrant->title }} {{ $registrant->firstName }} {{ $registrant->lastName }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Email Address</p>
                                    <p class="font-medium text-slate-800 break-all">{{ $registrant->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Contact Number</p>
                                    <p class="font-medium text-slate-800">{{ $registrant->contactNumber }}</p>
                                </div>
                                @if($registrant->nric)
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">NRIC/Passport</p>
                                    <p class="font-medium text-slate-800">{{ $registrant->nric }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Group Members -->
                        @if(count($groupMembers) > 0)
                        <div class="border-t pt-4 mt-4">
                            <h3 class="text-lg font-semibold text-slate-700 mb-3">Group Members ({{ count($groupMembers) }})</h3>
                            <div class="space-y-3">
                                @foreach($groupMembers as $index => $member)
                                <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                    <p class="font-semibold text-slate-800 mb-2">Member {{ $index + 2 }}</p>
                                    <div class="grid md:grid-cols-3 gap-3 text-sm">
                                        <div>
                                            <p class="text-slate-600 mb-1">Name</p>
                                            <p class="font-medium text-slate-800">{{ $member->title }} {{ $member->firstName }} {{ $member->lastName }}</p>
                                            @if($member->groupRegistrationID && $member->paymentStatus == 'group_member_paid')
                                                <p class="text-xs text-slate-600 mt-1">
                                                    Code: <span class="font-bold text-green-600">{{ $member->paymentReferenceNo }}</span>
                                                </p>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-slate-600 mb-1">Email</p>
                                            <p class="font-medium text-slate-800 break-all">{{ $member->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-slate-600 mb-1">Contact</p>
                                            <p class="font-medium text-slate-800">{{ $member->contactNumber }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Payment Breakdown -->
                    @if($registrant->netAmount > 0 || $registrant->price > 0)
                    <div class="">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Payment Breakdown</h2>
                        
                        <div class="bg-slate-50 rounded-lg p-4 md:p-6 space-y-3">
                            <!-- Base Programme Price -->
                            <div class="flex justify-between items-center py-2 border-b border-slate-200">
                                <span class="text-slate-700 font-medium">Standard Fee</span>
                                <span class="text-slate-800 font-semibold text-lg">${{ number_format($registrant->price, 2) }}</span>
                            </div>

                            <!-- Admin Fee -->
                            {{-- @if($registrant->programme->adminFee > 0) --}}
                            <div class="flex justify-between items-center py-2 border-b border-slate-200">
                                <span class="text-slate-700 font-medium">Admin Fee</span>
                                <span class="text-slate-800 font-semibold">${{ number_format($registrant->programme->adminFee, 2) }}</span>
                            </div>
                            {{-- @endif --}}

                            @php
                                $basePrice = $registrant->price;
                                $adminFee = $registrant->programme->adminFee ?? 0;
                                $subtotal = $basePrice + $adminFee;
                            @endphp

                            <!-- Subtotal -->
                            <div class="flex justify-between items-center py-2 border-b-2 border-slate-300">
                                <span class="text-slate-700 font-semibold">Subtotal</span>
                                <span class="text-slate-800 font-bold text-lg {{ $registrant->promocode && $registrant->promocode->promocode ? 'line-through' : '' }}">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            <!-- Promocode Discount -->
                            @if($registrant->promocode)
                            <div class="flex justify-between items-center py-2 bg-green-50 rounded px-2">
                                <div>
                                    <span class="text-green-700 font-medium">Promocode Applied</span>
                                    <p class="text-xs text-green-600 mt-1">
                                        Code: <span class="font-semibold font-mono text-sm">{{ $registrant->promocode && $registrant->promocode->promocode ? $registrant->promocode->promocode : 'N/A' }}</span>
                                    </p>
                                </div>
                                <span class="text-green-700 font-bold text-lg">${{ number_format($registrant->promocode->price, 2) }}</span>
                            </div>
                            @endif

                            <!-- Promotion Discount -->
                            @if($registrant->promotion)
                            <div class="flex justify-between items-center py-2 bg-blue-50 rounded px-2">
                                <div>
                                    <span class="text-blue-700 font-medium">Promotion Applied</span>
                                    <p class="text-xs text-blue-600 mt-1">
                                        {{ $registrant->promotion && $registrant->promotion->title ? $registrant->promotion->title : 'N/A' }}
                                    </p>
                                </div>
                                <span class="text-blue-700 font-bold text-lg">${{ number_format($registrant->promotion->price, 2) }}</span>
                            </div>
                            @endif

                            <!-- Total Amount -->
                            <div class="flex justify-between items-center py-3 mt-4">
                                <span class="text-slate-800 font-bold text-lg md:text-xl">Total Amount</span>
                                <span class="text-teal-700 font-bold text-2xl md:text-2xl">${{ number_format($registrant->netAmount, 2) }}</span>
                            </div>

                            @if($registrant->netAmount <= 0)
                            <div class="mt-3 text-center">
                                <p class="text-green-700 font-semibold text-lg">FREE EVENT</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <!-- Free Event Notice -->
                    <div class="border-b-2 border-slate-200 pb-4">
                        <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6 text-center">
                            <h3 class="text-2xl font-bold text-green-800 mb-2">FREE EVENT</h3>
                            <p class="text-green-700">No payment required for this registration.</p>
                        </div>
                    </div>
                    @endif

                    <!-- Payment Information -->
                    @if($registrant->paymentStatus == 'paid' || $registrant->netAmount <= 0)
                        <div class="">
                            <h2 class="text-xl font-bold text-slate-800 mb-4">Payment Information</h2>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Payment Status:</span>
                                    <span class="font-semibold text-green-700">PAID</span>
                                </div>
                                @if($registrant->payment_gateway)
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Payment Method:</span>
                                    @php
                                        $paymentGateway = strtoupper(str_replace('_', ' ', $registrant->payment_gateway));
                                        if ($paymentGateway == 'HITPAY') 
                                            $paymentGateway = 'PayNow App (Credit/Debit Card)';
                                        else if ($paymentGateway == 'CARD')
                                            $paymentGateway = 'Credit/Debit Card';
                                        else if ($paymentGateway == 'BANK_TRANSFER')
                                            $paymentGateway = 'Bank Transfer';
                                        else
                                            $paymentGateway = 'Cash';
                                    @endphp
                                    <span class="font-semibold text-slate-800">{{ $paymentGateway }}</span>
                                </div>
                                @endif
                                @if($registrant->payment_transaction_id)
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Transaction ID:</span>
                                    <span class="font-semibold text-slate-800 font-mono text-sm">{{ $registrant->payment_transaction_id }}</span>
                                </div>
                                @endif
                                @if($registrant->paymentReferenceNo)
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Payment Reference:</span>
                                    <span class="font-semibold text-slate-800 font-mono text-sm">{{ $registrant->paymentReferenceNo }}</span>
                                </div>
                                @endif
                                @if($registrant->payment_completed_at)
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Payment Date:</span>
                                    <span class="font-semibold text-slate-800">{{ $registrant->payment_completed_at->format('d M Y, h:i A') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    @elseif($registrant->programme->allowPreRegistration)
                        <div class="">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-lg font-bold text-yellow-800 mb-2">Pre-Registration</p>
                                <p class="text-sm text-yellow-800">
                                    No payment required for this event yet. Please wait for payment instructions to be sent to your email address.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Footer Note -->
                    <div class="pt-4 text-center text-sm text-slate-500">
                        <p>This is an official receipt for your registration. Please keep this for your records.</p>
                        @if($registrant->paymentStatus == 'paid' || $registrant->netAmount <= 0)
                            <p class="mt-2">A confirmation email has been sent to <strong>{{ $registrant->email }}</strong></p>
                        @endif
                    </div>

                </div>

                <!-- Receipt Footer -->
                <div class="bg-slate-100 border-t-2 border-slate-300 p-4 text-center text-xs text-slate-600">
                    <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
                    <p class="mt-1">For inquiries, please contact: {{ $registrant->programme->contactEmail ?? 'N/A' }}</p>
                </div>

            </div>

            <!-- Action Buttons (Hidden on Print) -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center py-6 no-print">
                <button 
                    onclick="window.print()" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition-colors shadow-md hover:shadow-lg"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Receipt
                </button>
                <a href="{{ route('frontpage') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-slate-100 border border-slate-200 text-slate-700 rounded-lg font-semibold hover:bg-slate-200 transition-colors shadow-md hover:shadow-lg"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Back to Homepage
                </a>
            </div>

        </div>
    </div>
    <x-footer-public />

    <!-- QR Code Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @php
                $confirmationUrl = route('registration.confirmation', ['confirmationCode' => $registrant->confirmationCode]);
            @endphp
            
            const confirmationUrl = '{{ $confirmationUrl }}';
            const qrElement = document.getElementById('qrcode');
            
            if (qrElement && typeof QRCode !== 'undefined') {
                new QRCode(qrElement, {
                    text: confirmationUrl,
                    width: 200,
                    height: 200,
                    // colorDark: '#0d9488', // teal-600
                    colorDark: '#000000', // black 
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
            } else if (qrElement) {
                // Retry if QRCode is not loaded yet
                setTimeout(function() {
                    if (typeof QRCode !== 'undefined') {
                        new QRCode(qrElement, {
                            text: confirmationUrl,
                            width: 200,
                            height: 200,
                            // colorDark: '#0d9488',
                            colorDark: '#000000',
                            colorLight: '#ffffff',
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    } else {
                        console.error('QRCode library failed to load');
                    }
                }, 500);
            }
        });

        // Poll for payment status updates if payment is still pending
        @if($registrant->paymentStatus !== 'paid' && $registrant->netAmount > 0)
        (function() {
            const confirmationCode = '{{ $registrant->confirmationCode }}';
            const statusCheckUrl = '{{ route("api.registration.payment-status", ["confirmationCode" => $registrant->confirmationCode]) }}';
            let pollCount = 0;
            const maxPolls = 30; // Poll for up to 30 times (30 seconds)
            const pollInterval = 1000; // Check every 1 second
            
            const pollPaymentStatus = function() {
                if (pollCount >= maxPolls) {
                    console.log('Stopped polling: maximum attempts reached');
                    return;
                }
                
                pollCount++;
                
                fetch(statusCheckUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.isPaid) {
                            // Payment has been confirmed, reload the page to show updated status
                            console.log('Payment confirmed, reloading page...');
                            window.location.reload();
                        } else if (pollCount < maxPolls) {
                            // Continue polling
                            setTimeout(pollPaymentStatus, pollInterval);
                        }
                    })
                    .catch(error => {
                        console.error('Error checking payment status:', error);
                        // Continue polling even on error (network issues, etc.)
                        if (pollCount < maxPolls) {
                            setTimeout(pollPaymentStatus, pollInterval);
                        }
                    });
            };
            
            // Start polling after a short delay (give webhook time to process)
            setTimeout(pollPaymentStatus, 2000);
        })();
        @endif
    </script>
</x-guest-layout>
