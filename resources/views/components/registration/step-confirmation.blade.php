@props(['programme'])

<!-- Confirmation Step (Always the last step) -->
<div x-show="currentStep === totalSteps" 
     x-transition:enter="transition ease-out duration-300" 
     x-transition:enter-start="opacity-0 transform translate-x-8" 
     x-transition:enter-end="opacity-100 transform translate-x-0">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Confirm Your Registration</h2>
    <p class="text-slate-600 mb-6">Please review your information before submitting.</p>

    <div class="space-y-6">
        <!-- Main Registrant Information -->
        <x-registration.registrant-summary />

        <!-- Group Members Summary -->
        <x-registration.group-members-summary />

        <!-- Price Summary -->
        <x-registration.price-summary :programme="$programme" />

        <!-- Validation Message -->
        <div x-show="!isMainRegistrantValid()" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Registration Incomplete</h3>
                    <p class="text-sm text-yellow-700 mt-1">Please ensure all required fields are filled in the registration form (Title, First Name, Last Name, Email, and Contact Number).</p>
                </div>
            </div>
        </div>

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
                    :class="{ 'opacity-50 cursor-not-allowed': submitting }"
                    :disabled="{{ auth()->check() ? 'false' : '!canCompleteRegistration()' }}"
                    class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                <span x-show="!submitting">Complete Registration</span>
                <span x-show="submitting">Processing...</span>
                <svg x-show="!submitting" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </button>
        </div>
    </div>
</div>
