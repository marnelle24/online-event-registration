@section('title', 'Payment Required')

<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-100/70 to-white/30 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Payment Header -->
            <div class="bg-white rounded-lg shadow-lg border-t-4 border-orange-500 overflow-hidden mb-8 p-8">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-center text-slate-800 mb-2">Payment Required</h1>
                <p class="text-center text-slate-600 mb-6">Complete your payment to confirm your registration</p>
                
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 text-center">
                    <p class="text-sm text-slate-600 mb-2">Your Registration Code</p>
                    <p class="text-3xl font-bold text-orange-700 tracking-wider">{{ $registrant->regCode }}</p>
                </div>
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
                                        <p class="font-semibold text-slate-800">{{ $member->title }} {{ $member->firstName }} {{ $member->lastName }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-600">Email</p>
                                        <p class="font-semibold text-slate-800">{{ $member->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-600">Contact</p>
                                        <p class="font-semibold text-slate-800">{{ $member->contactNumber }}</p>
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
                        <span class="font-semibold text-slate-800">${{ number_format($registrant->price, 2) }}</span>
                    </div>
                    @if($registrant->discountAmount > 0)
                        <div class="flex justify-between items-center text-green-600">
                            <span>Discount Applied:</span>
                            <span class="font-semibold">- ${{ number_format($registrant->discountAmount, 2) }}</span>
                        </div>
                        @if($registrant->promocode)
                            <div class="text-sm text-slate-600">
                                <p>Promo Code: <span class="font-medium text-slate-800">{{ $registrant->promocode->promocode }}</span></p>
                            </div>
                        @endif
                    @endif
                    <div class="border-t pt-3 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-slate-800">Total Amount Due:</span>
                            <span class="text-3xl font-bold text-orange-600">${{ number_format($registrant->netAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 p-6">
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
                                <p class="text-sm text-slate-600 mb-3">Please use your registration code <strong>{{ $registrant->regCode }}</strong> as payment reference</p>
                                
                                <div class="bg-blue-100/50 border border-blue-200 rounded-lg p-4 space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Bank Name:</span>
                                        <span class="font-semibold text-slate-800">DBS Bank</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Account Number:</span>
                                        <span class="font-semibold text-slate-800">002-1234567-8</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Account Name:</span>
                                        <span class="font-semibold text-slate-800">Streams Of Life Pte Ltd</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-600">Swift Code:</span>
                                        <span class="font-semibold text-slate-800">DBSSSGSG</span>
                                    </div>
                                    @if($registrant->programme->chequeCode)
                                        <div class="flex justify-between">
                                            <span class="text-slate-600">Cheque Code:</span>
                                            <span class="font-semibold text-slate-800">{{ $registrant->programme->chequeCode }}</span>
                                        </div>
                                    @endif
                                    <div class="border-t border-blue-200 pt-2 mt-2">
                                        <p class="text-md text-slate-600">
                                            <strong>Reference:</strong> {{ $registrant->regCode }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Credit/Debit Card -->
                    <div class="border-2 border-slate-200 hover:bg-teal-50 hover:shadow-lg transition-all duration-300 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#7C2278] rounded-lg flex items-center justify-center">
                                <img src="{{ asset('images/PayNow.png') }}" alt="PayNow" class="w-8">
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-slate-800 mb-2">Credit/Debit via PayNow</h3>
                                <p class="text-sm text-slate-600 mb-3">Pay securely with your card or your PayNow balance</p>
                                
                                <button type="button" 
                                        class="hover:-translate-y-0.5 hover:shadow-lg duration-300 transition-all w-full mt-4 bg-[#7C2278]/90 uppercase tracking-wider text-white py-3 px-6 rounded-lg font-semibold hover:bg-[#7C2278]"
                                        onclick="alert('Payment gateway integration coming soon!')">
                                    Pay {{ '$'.number_format($registrant->netAmount, 2) }} with PayNow
                                </button>
                                
                                <p class="text-[11px] text-slate-500 mt-2 text-center">Secured by SSL encryption</p>
                            </div>
                        </div>
                    </div>

                    <!-- PayPal -->
                    {{-- <div class="border-2 border-slate-200 rounded-lg p-6 hover:border-teal-500 transition-colors">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.067 8.478c.492.88.556 2.014.3 3.327-.74 3.806-3.276 5.12-6.514 5.12h-.5a.805.805 0 00-.794.68l-.04.22-.63 3.993-.028.15a.805.805 0 01-.794.679H7.72a.483.483 0 01-.477-.558L7.418 21h1.518l.95-6.02h1.385c4.678 0 7.75-2.203 8.796-6.502z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-slate-800 mb-2">PayPal</h3>
                                <p class="text-sm text-slate-600 mb-3">Pay with your PayPal account</p>
                                
                                <button type="button" 
                                        class="w-full bg-yellow-500 text-slate-900 py-3 px-6 rounded-lg font-semibold hover:bg-yellow-600 transition-colors"
                                        onclick="alert('PayPal integration coming soon!')">
                                    Pay with PayPal
                                </button>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>

            <!-- Important Notice -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 mb-8">
                <h2 class="text-lg font-bold text-amber-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Important Information for Bank Transfer and Cheque Payment
                </h2>
                <ul class="space-y-2 text-amber-900 text-sm">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Please use your registration code <strong>{{ $registrant->regCode }}</strong> as payment reference</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>After payment, please email your proof of payment to <strong>{{ $registrant->programme->contactEmail }}</strong></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Your registration will be confirmed once payment is verified (usually within 1-2 business days)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>A confirmation email with event details will be sent once payment is verified</span>
                    </li>
                </ul>
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
                <a href="{{ route('frontpage') }}" 
                   class="inline-flex border border-slate-300 duration-300 transition-all items-center justify-center px-6 py-3 bg-slate-200 text-slate-700 rounded-lg font-semibold hover:bg-slate-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Back to Home
                </a>
                {{-- <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center justify-center px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Payment Details
                </button> --}}
            </div>

        </div>
    </div>
    <x-footer-public />
</x-guest-layout>

