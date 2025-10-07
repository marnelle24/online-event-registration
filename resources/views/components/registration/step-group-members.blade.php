@props(['programme'])

<!-- Step 3: Group Members (Only if group registration is enabled and selected) -->
<div x-show="currentStep === 3 && allowGroupRegistration" x-transition:enter="transition ease-out duration-300" 
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
        <x-registration.group-members-list />

        <!-- Add Member Button -->
        <x-registration.add-member-button />

        <!-- Group Summary -->
        <x-registration.group-summary />

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
