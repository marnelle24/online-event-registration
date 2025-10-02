@section('title', 'Register for '.$programme->title)

@push('styles')
<script>
    // Define Alpine data before Alpine.js initializes
    document.addEventListener('alpine:init', () => {
        Alpine.data('registrationForm', () => ({
            currentStep: 1,
            totalSteps: {{ $programme->allowGroupRegistration ? 5 : 3 }},
            allowGroupRegistration: {{ $programme->allowGroupRegistration ? 'true' : 'false' }},
            groupRegistrationMin: {{ $programme->groupRegistrationMin ?? 2 }},
            groupRegistrationMax: {{ $programme->groupRegistrationMax ?? 10 }},
            groupRegIndividualFee: {{ $programme->groupRegIndividualFee ?? $programme->price }},
            programmePrice: {{ $programme->price }},
            validating: false,
            submitting: false,
            promocodeError: '',
            promocodeValid: false,
            discountAmount: 0,
            finalPrice: {{ $programme->price }},
            isGroupRegistration: false,
            groupMembers: [],
            formData: {
                programmeCode: '{{ $programmeCode }}',
                programmeId: {{ $programme->id }},
                promocode: '',
                promocodeId: null,
                registrationType: 'guest',
                title: '',
                firstName: '',
                lastName: '',
                nric: '',
                email: '',
                contactNumber: '',
                address: '',
                city: '',
                postalCode: ''
            },

            nextStep() {
                // Skip step 4 if not group registration
                if (this.currentStep === 3 && !this.isGroupRegistration && this.allowGroupRegistration) {
                    this.currentStep = 5;
                } else if (this.currentStep < this.totalSteps) {
                    this.currentStep++;
                }
            },

            previousStep() {
                // Skip step 4 if not group registration when going back
                if (this.currentStep === 5 && !this.isGroupRegistration && this.allowGroupRegistration) {
                    this.currentStep = 3;
                } else if (this.currentStep > 1) {
                    this.currentStep--;
                }
            },

            addGroupMember() {
                if (this.groupMembers.length < this.groupRegistrationMax - 1) {
                    this.groupMembers.push({
                        title: '',
                        firstName: '',
                        lastName: '',
                        nric: '',
                        email: '',
                        contactNumber: ''
                    });
                }
            },

            removeGroupMember(index) {
                this.groupMembers.splice(index, 1);
            },

            canProceedGroupStep() {
                if (!this.isGroupRegistration) return true;
                
                const totalMembers = this.groupMembers.length + 1; // +1 for main registrant
                return totalMembers >= this.groupRegistrationMin && totalMembers <= this.groupRegistrationMax;
            },

            calculateTotalCost() {
                // Simply return programme price minus promo code discount if applicable
                if (this.promocodeValid && this.finalPrice !== null && this.finalPrice !== undefined) {
                    return parseFloat(this.finalPrice);
                }
                return parseFloat(this.programmePrice);
            },

            selectRegistrationType(type) {
                this.formData.registrationType = type;
            },

            async validatePromocode() {
                if (!this.formData.promocode) return;

                this.validating = true;
                this.promocodeError = '';
                
                try {
                    const response = await fetch(`/api/validate-promocode`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            promocode: this.formData.promocode,
                            programmeCode: this.formData.programmeCode
                        })
                    });

                    const data = await response.json();

                    if (data.valid) {
                        this.promocodeValid = true;
                        this.formData.promocodeId = data.promocodeId;
                        this.finalPrice = parseFloat(data.price);
                        this.discountAmount = this.programmePrice - this.finalPrice;
                    } else {
                        this.promocodeError = data.message || 'Invalid promo code';
                        this.promocodeValid = false;
                    }
                } catch (error) {
                    this.promocodeError = 'Error validating promo code. Please try again.';
                    this.promocodeValid = false;
                } finally {
                    this.validating = false;
                }
            },

            async submitRegistration() {
                this.submitting = true;

                try {
                    const payload = {
                        ...this.formData,
                        isGroupRegistration: this.isGroupRegistration,
                        groupMembers: this.isGroupRegistration ? this.groupMembers : [],
                        totalCost: this.calculateTotalCost()
                    };

                    console.log(payload);
                    return;

                    const response = await fetch(`/api/register-programme`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = data.redirectUrl;
                    } else {
                        alert(data.message || 'Registration failed. Please try again.');
                    }
                } catch (error) {
                    alert('An error occurred. Please try again.');
                } finally {
                    this.submitting = false;
                }
            }
        }))
    });
</script>
@endpush

<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-100/70 to-white/30 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Programme Header -->
            <div class="bg-white rounded-lg shadow-lg border-t border-zinc-300/40 overflow-hidden mb-8 p-6 md:p-8">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">{{ $programme->title }}</h1>
                        <p class="text-xs text-teal-700/80 font-thin mb-4">{{ 'By '.$programme->ministry->name }}</p>
                        <div class="flex flex-col gap-2 text-sm text-slate-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $programme->programmeDates }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0Z" />
                                </svg>
                                {{ $programme->programmeTimes }}
                            </div>
                            @if($programme->price > 0)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 stroke-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $programme->formattedPrice }}
                                </div>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Free Event
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div x-data="registrationForm()" class="bg-white rounded-lg shadow-lg overflow-hidden">
                
                <!-- Progress Timeline -->
                <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 md:px-8 py-8">
                    <div class="flex items-center justify-between relative">
                        <!-- Progress Line -->
                        <div class="absolute left-0 right-0 top-1/2 h-1 bg-teal-800/30 -translate-y-1/2 z-0"></div>
                        <div class="absolute left-0 top-1/2 h-1 bg-white transition-all duration-500 -translate-y-1/2 z-0" 
                             :style="`width: ${((currentStep - 1) / (totalSteps - 1)) * 100}%`"></div>

                        <!-- Step 1 -->
                        <div class="flex flex-col items-center z-10 relative">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="currentStep >= 1 ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                                <span class="font-bold text-xs md:text-sm" x-show="currentStep > 1">✓</span>
                                <span class="font-bold text-xs md:text-sm" x-show="currentStep <= 1">1</span>
                            </div>
                            <span class="text-xs text-white mt-1 font-medium hidden md:block">Promo</span>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex flex-col items-center z-10 relative">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="currentStep >= 2 ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                                <span class="font-bold text-xs md:text-sm" x-show="currentStep > 2">✓</span>
                                <span class="font-bold text-xs md:text-sm" x-show="currentStep <= 2">2</span>
                            </div>
                            <span class="text-xs text-white mt-1 font-medium hidden md:block">Account</span>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex flex-col items-center z-10 relative">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="currentStep >= 3 ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                                <span class="font-bold text-xs md:text-sm" x-show="currentStep > 3">✓</span>
                                <span class="font-bold text-xs md:text-sm" x-show="currentStep <= 3">3</span>
                            </div>
                            <span class="text-xs text-white mt-1 font-medium hidden md:block">Info</span>
                        </div>

                        <!-- Step 4 (Group Registration - conditionally shown) -->
                        <div x-show="allowGroupRegistration" class="flex flex-col items-center z-10 relative">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="currentStep >= 4 ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                                <span class="font-bold text-xs md:text-sm" x-show="currentStep > 4">✓</span>
                                <span class="font-bold text-xs md:text-sm" x-show="currentStep <= 4">4</span>
                            </div>
                            <span class="text-xs text-white mt-1 font-medium hidden md:block">Group</span>
                        </div>

                        <!-- Step 5 (Confirmation - conditionally shown or becomes step 4) -->
                        <div class="flex flex-col items-center z-10 relative">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="currentStep >= (allowGroupRegistration ? 5 : 4) ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                                <span class="font-bold text-xs md:text-sm" x-text="allowGroupRegistration ? '5' : '4'"></span>
                            </div>
                            <span class="text-xs text-white mt-1 font-medium hidden md:block">Confirm</span>
                        </div>
                    </div>

                    <!-- Mobile Step Labels -->
                    <div class="md:hidden mt-4 text-center">
                        <p class="text-white text-sm font-medium">
                            Step <span x-text="currentStep"></span> of <span x-text="totalSteps"></span>: 
                            <span x-show="currentStep === 1">Promo Code</span>
                            <span x-show="currentStep === 2">Account</span>
                            <span x-show="currentStep === 3">Information</span>
                            <span x-show="currentStep === 4 && allowGroupRegistration">Group Members</span>
                            <span x-show="(currentStep === 5 && allowGroupRegistration) || (currentStep === 4 && !allowGroupRegistration)">Confirmation</span>
                        </p>
                    </div>
                </div>

                <!-- Form Steps -->
                <div class="p-6 md:p-8">
                    
                    <!-- Step 1: Promo Code -->
                    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-8" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">Do you have a promo code?</h2>
                        <p class="text-slate-600 mb-6">Enter your promo code to get a special discount, or skip if you don't have one.</p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Promo Code (Optional)</label>
                                <input type="text" 
                                       x-model="formData.promocode"
                                       @input="promocodeError = ''; promocodeValid = false"
                                       placeholder="Enter promo code"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 uppercase"
                                       :class="{ 'border-red-300 bg-red-50': promocodeError, 'border-green-300 bg-green-50': promocodeValid }">
                                <p x-show="promocodeError" x-text="promocodeError" class="mt-2 text-sm text-red-600"></p>
                                <p x-show="promocodeValid" class="mt-2 text-sm text-green-600">
                                    ✓ Valid promo code applied! New price: SGD <span x-text="finalPrice.toFixed(2)"></span>
                                </p>
                            </div>

                            <button @click="validatePromocode" 
                                    type="button"
                                    x-show="formData.promocode && !promocodeValid"
                                    :disabled="validating"
                                    class="w-full bg-teal-100 border border-teal-400 text-teal-700 px-6 py-3 rounded-lg font-semibold hover:bg-teal-500/30 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!validating">Validate Promo Code</span>
                                <span x-show="validating">Validating...</span>
                            </button>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button @click="nextStep" 
                                    type="button"
                                    class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center">
                                Continue
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Guest or Login -->
                    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-8" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">Choose Registration Method</h2>
                        <p class="text-slate-600 mb-6">Register as a guest or log in to your existing account.</p>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Register as Guest -->
                            <div @click="selectRegistrationType('guest')" 
                                 class="cursor-pointer border-2 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
                                 :class="formData.registrationType === 'guest' ? 'border-teal-600 bg-teal-50' : 'border-slate-200 hover:border-teal-300'">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center"
                                         :class="formData.registrationType === 'guest' ? 'border-teal-600 bg-teal-600' : 'border-slate-300'">
                                        <svg x-show="formData.registrationType === 'guest'" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Register as Guest</h3>
                                <p class="text-sm text-slate-600">Quick registration without creating an account. Perfect for one-time registrations.</p>
                            </div>

                            <!-- Login -->
                            <a href="{{ route('login', ['redirect' => url()->full()]) }}" 
                               class="cursor-pointer border-2 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border-slate-200 hover:border-teal-300 block">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-2">Login to Account</h3>
                                <p class="text-sm text-slate-600">Already have an account? Log in to access your previous registrations and faster checkout.</p>
                            </a>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button @click="previousStep" 
                                    type="button"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-8 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                </svg>
                                Back
                            </button>
                            <button @click="nextStep" 
                                    type="button"
                                    :disabled="!formData.registrationType"
                                    class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                                Continue
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Registration Information -->
                    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-8" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">Registration Information</h2>
                        <p class="text-slate-600 mb-6">Please provide your details to complete the registration.</p>
                        
                        <div class="space-y-6">
                            
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-slate-800 border-b pb-2">Personal Information</h3>
                                
                                <div class="grid md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Title <span class="text-red-500">*</span></label>
                                        <select x-model="formData.title" required
                                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                            <option value="">Select</option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Rev">Rev</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">First Name <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="formData.firstName" required
                                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                               placeholder="John">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="formData.lastName" required
                                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                               placeholder="Doe">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">NRIC/Passport</label>
                                    <input type="text" x-model="formData.nric"
                                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                           placeholder="S1234567A">
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-slate-800 border-b pb-2">Contact Information</h3>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                                        <input type="email" x-model="formData.email" required
                                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                               placeholder="john.doe@example.com">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Contact Number <span class="text-red-500">*</span></label>
                                        <input type="tel" x-model="formData.contactNumber" required
                                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                               placeholder="+65 1234 5678">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Address</label>
                                    <input type="text" x-model="formData.address"
                                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                           placeholder="123 Main Street">
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">City</label>
                                        <input type="text" x-model="formData.city"
                                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                               placeholder="Singapore">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Postal Code</label>
                                        <input type="text" x-model="formData.postalCode"
                                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                               placeholder="123456">
                                    </div>
                                </div>
                            </div>

                            <!-- Group Registration Option -->
                            @if($programme->allowGroupRegistration)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <div class="flex items-start">
                                    <input type="checkbox" 
                                           x-model="isGroupRegistration" 
                                           id="groupRegistration"
                                           class="mt-1 h-5 w-5 text-teal-600 focus:ring-teal-500 border-slate-300 rounded">
                                    <label for="groupRegistration" class="ml-3 flex-1">
                                        <span class="block text-lg font-semibold text-slate-800">Register as a Group</span>
                                        <span class="block text-sm text-slate-600 mt-1">
                                            Save by registering multiple people at once! 
                                            Group size: {{ $programme->groupRegistrationMin }} - {{ $programme->groupRegistrationMax }} members
                                            @if($programme->groupRegIndividualFee && $programme->groupRegIndividualFee < $programme->price)
                                                <span class="text-green-600 font-semibold">
                                                    (SGD {{ number_format($programme->groupRegIndividualFee, 2) }} per person)
                                                </span>
                                            @endif
                                        </span>
                                    </label>
                                </div>
                            </div>
                            @endif

                            <!-- Navigation Buttons -->
                            <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
                                <button @click="previousStep" 
                                        type="button"
                                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-8 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                    </svg>
                                    Back
                                </button>
                                <button @click="nextStep" 
                                        type="button"
                                        class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                                    Continue
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Group Members (Only if group registration is enabled and selected) -->
                    <div x-show="currentStep === 4 && allowGroupRegistration" x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-8" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">Add Group Members</h2>
                        <p class="text-slate-600 mb-6">
                            Add additional members to your group registration. 
                            Required: {{ $programme->groupRegistrationMin ?? 2 }} - {{ $programme->groupRegistrationMax ?? 10 }} total members (including you).
                        </p>

                        <div class="space-y-6">
                            <!-- Main Registrant Summary -->
                            <div class="bg-teal-50 border border-teal-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">Main Registrant (You)</p>
                                        <p class="text-sm text-slate-600" x-text="`${formData.title} ${formData.firstName} ${formData.lastName}`"></p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-600 text-white">
                                        Member 1
                                    </span>
                                </div>
                            </div>

                            <!-- Group Members List -->
                            <div class="space-y-4">
                                <template x-for="(member, index) in groupMembers" :key="index">
                                    <div class="border border-slate-300 rounded-lg p-6 relative">
                                        <button @click="removeGroupMember(index)" 
                                                type="button"
                                                class="absolute top-4 right-4 text-red-500 hover:text-red-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>

                                        <div class="mb-4">
                                            <h4 class="text-lg font-semibold text-slate-800">
                                                Member <span x-text="index + 2"></span>
                                            </h4>
                                        </div>

                                        <div class="grid md:grid-cols-3 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">Title <span class="text-red-500">*</span></label>
                                                <select x-model="member.title" required
                                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                                    <option value="">Select</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Ms">Ms</option>
                                                    <option value="Dr">Dr</option>
                                                    <option value="Rev">Rev</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">First Name <span class="text-red-500">*</span></label>
                                                <input type="text" x-model="member.firstName" required
                                                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                                                <input type="text" x-model="member.lastName" required
                                                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                                                <input type="email" x-model="member.email" required
                                                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">Contact Number <span class="text-red-500">*</span></label>
                                                <input type="tel" x-model="member.contactNumber" required
                                                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">NRIC/Passport</label>
                                            <input type="text" x-model="member.nric"
                                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Add Member Button -->
                            <button @click="addGroupMember" 
                                    type="button"
                                    x-show="groupMembers.length < groupRegistrationMax - 1"
                                    class="w-full border-2 border-dashed border-teal-300 rounded-lg p-6 text-teal-600 hover:border-teal-500 hover:bg-teal-50 transition-all duration-300 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Another Member (<span x-text="groupMembers.length + 1"></span> / <span x-text="groupRegistrationMax"></span>)
                            </button>

                            <!-- Group Summary -->
                            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-700">Total Group Members:</span>
                                    <span class="text-lg font-bold text-teal-600" x-text="groupMembers.length + 1"></span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2" x-show="!canProceedGroupStep()">
                                    <span class="text-red-600">⚠</span> Minimum <span x-text="groupRegistrationMin"></span> members required to proceed.
                                </p>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
                                <button @click="previousStep" 
                                        type="button"
                                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-8 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                    </svg>
                                    Back
                                </button>
                                <button @click="nextStep" 
                                        type="button"
                                        :disabled="!canProceedGroupStep()"
                                        class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                                    Continue
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Confirmation (or Step 4 if no group registration) -->
                    <div x-show="(currentStep === 5 && allowGroupRegistration) || (currentStep === 4 && !allowGroupRegistration)" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-8" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">Confirm Your Registration</h2>
                        <p class="text-slate-600 mb-6">Please review your information before submitting.</p>

                        <div class="space-y-6">
                            
                            <!-- Main Registrant Information -->
                            <div class="border border-slate-300 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b">Main Registrant</h3>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-slate-600">Full Name</p>
                                        <p class="font-semibold" x-text="`${formData.title} ${formData.firstName} ${formData.lastName}`"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-600">Email</p>
                                        <p class="font-semibold" x-text="formData.email"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-600">Contact Number</p>
                                        <p class="font-semibold" x-text="formData.contactNumber"></p>
                                    </div>
                                    <div x-show="formData.nric">
                                        <p class="text-sm text-slate-600">NRIC/Passport</p>
                                        <p class="font-semibold" x-text="formData.nric"></p>
                                    </div>
                                    <div x-show="formData.address" class="md:col-span-2">
                                        <p class="text-sm text-slate-600">Address</p>
                                        <p class="font-semibold" x-text="`${formData.address}${formData.city ? ', ' + formData.city : ''}${formData.postalCode ? ' ' + formData.postalCode : ''}`"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Group Members Summary -->
                            <div x-show="isGroupRegistration && groupMembers.length > 0" class="border border-slate-300 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b">Group Members</h3>
                                <div class="space-y-4">
                                    <template x-for="(member, index) in groupMembers" :key="index">
                                        <div class="bg-slate-50 rounded-lg p-4">
                                            <p class="font-semibold text-slate-800 mb-2">
                                                Member <span x-text="index + 2"></span>: 
                                                <span x-text="`${member.title} ${member.firstName} ${member.lastName}`"></span>
                                            </p>
                                            <div class="grid md:grid-cols-2 gap-2 text-sm">
                                                <p class="text-slate-600">Email: <span class="text-slate-800" x-text="member.email"></span></p>
                                                <p class="text-slate-600">Contact: <span class="text-slate-800" x-text="member.contactNumber"></span></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Price Summary -->
                            @if($programme->price > 0)
                            <div class="bg-teal-50 border border-teal-200 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-slate-800 mb-4">Price Summary</h3>
                                <div class="space-y-2">
                                    <div x-show="isGroupRegistration" class="flex justify-between text-slate-600 text-sm mb-2">
                                        <span>Total Registrants:</span>
                                        <span class="font-semibold" x-text="groupMembers.length + 1"></span>
                                    </div>
                                    <div class="flex justify-between text-slate-700">
                                        <span>Programme Fee:</span>
                                        <span class="font-semibold">SGD <span x-text="programmePrice.toFixed(2)"></span></span>
                                    </div>
                                    <div x-show="promocodeValid" class="flex justify-between text-green-600">
                                        <span>Promo Code Discount:</span>
                                        <span class="font-semibold">- SGD <span x-text="discountAmount.toFixed(2)"></span></span>
                                    </div>
                                    <div class="border-t border-teal-300 pt-2 mt-2">
                                        <div class="flex justify-between text-xl font-bold text-slate-800">
                                            <span>Total Amount:</span>
                                            <span class="text-teal-700">SGD <span x-text="calculateTotalCost().toFixed(2)"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-800">Free Event</h3>
                                        <p class="text-sm text-slate-600">This is a free event. No payment required.</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Submit Buttons -->
                            <div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
                                <button @click="previousStep" 
                                        type="button"
                                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-8 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                    </svg>
                                    Back
                                </button>
                                <button @click="submitRegistration" 
                                        type="button"
                                        :disabled="submitting"
                                        class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span x-show="!submitting">Complete Registration</span>
                                    <span x-show="submitting">Processing...</span>
                                    <svg x-show="!submitting" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <x-footer-public />
</x-guest-layout>

