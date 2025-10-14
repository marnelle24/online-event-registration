@section('title', 'Registration Confirmation')

<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-100/70 to-white/30 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            <div class="bg-white rounded-lg shadow-lg border-t-4 border-teal-600 overflow-hidden mb-8 p-8">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                @if($registrant->paymentStatus == 'paid')
                    <h1 class="text-3xl font-bold text-center text-slate-800 mb-2">Registration Successful!</h1>
                    <p class="text-center text-slate-600 mb-6">Your payment has been successfully processed</p>
                    
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                        <p class="text-sm text-slate-600 mb-2">{{ $registrant->groupRegistrationID ? 'Group Registration ID' : 'Your Registration Code' }}</p>
                        <p class="text-3xl font-bold text-green-700 tracking-wider">{{ $registrant->groupRegistrationID ?? $registrant->regCode }}</p>
                        <p class="text-sm text-green-600 mt-2">✓ Payment Status: {{ ucfirst(str_replace('_', ' ', $registrant->paymentStatus)) }}</p>
                    </div>
                @else
                    <h1 class="text-3xl font-bold text-center text-slate-800 mb-2">Payment Required</h1>
                    <p class="text-center text-slate-600 mb-6">Complete your payment to confirm your registration</p>
                    
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-6 text-center">
                        <p class="text-sm text-slate-600 mb-2">{{ $registrant->groupRegistrationID ? 'Group Registration ID' : 'Your Registration Code' }}</p>
                        <p class="text-3xl font-bold text-orange-700 tracking-wider">{{ $registrant->groupRegistrationID ?? $registrant->regCode }}</p>
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
                    <div class="space-y-4">
                        @foreach($groupMembers as $index => $member)
                        <div class="bg-slate-50 rounded-lg p-4">
                            <p class="font-semibold text-slate-800 mb-2">Member {{ $index + 2 }}</p>
                            <div class="grid md:grid-cols-3 gap-3 text-sm">
                                <div>
                                    <p class="font-medium text-slate-800">{{ $member->title }} {{ $member->firstName }} {{ $member->lastName }}</p>
                                    @if($member->groupRegistrationID && $member->paymentStatus == 'group_member_paid')
                                        <span class="text-xs text-slate-600 italic font-bold">Code:</span>
                                        <span class="text-xs text-green-600 italic font-bold">{{ $member->paymentReferenceNo }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">{{ $member->email }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">{{ $member->contactNumber }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Payment Information -->
            @if($registrant->netAmount > 0)
                @if($registrant->programme->allowPreRegistration)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 p-6">
                        <h2 class="text-xl font-bold text-slate-800 mb-4 pb-2 border-b">Payment Information</h2>
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
                                    <span class="text-lg font-bold text-slate-800">Total Amount:</span>
                                    <span class="text-2xl font-bold text-teal-700">${{ number_format($registrant->netAmount, 2) }}</span>
                                </div>
                            </div>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                                <p class="text-xl font-bold text-yellow-800">Pre-Registration</p>
                                <p class="text-sm text-yellow-800 mt-2">
                                    No payment required for this event yet. <br />
                                    Kindly wait for the payment instructions to be sent to your email address.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-green-100 border border-green-500 rounded-lg p-6 mb-8">
                    <div class="flex flex-col justify-start items-start gap-4">
                        <h3 class="text-xl font-semibold text-green-800">Free Event</h3>
                        <div class="">
                            <ul class="space-y-3 text-green-800">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>No payment required for this event.</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>A confirmation email has been sent to <strong>{{ $registrant->email }}</strong></span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Please save your registration code: <strong>{{ $registrant->regCode }}</strong></span>
                                </li>
                                @if($registrant->netAmount > 0)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Complete your payment as per the instructions in the email</span>
                                </li>
                                @endif
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>You will receive further event details closer to the date</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center py-8">
                <a href="{{ route('frontpage') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-slate-100 border border-slate-200 duration-300 transition-all text-slate-700 rounded-lg font-semibold hover:bg-slate-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Back to Home
                </a>
                <a href="{{ route('programmes') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Browse More Events
                </a>
            </div>

        </div>
    </div>
    <x-footer-public />
</x-guest-layout>

