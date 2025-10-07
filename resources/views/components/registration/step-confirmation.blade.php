@props(['programme'])

<!-- Step 5: Confirmation (or Step 4 if no group registration) -->
<div x-show="(currentStep === 5 && allowGroupRegistration) || (currentStep === 4 && !allowGroupRegistration)" 
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
