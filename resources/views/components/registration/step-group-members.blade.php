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
        <x-registration.navigation-buttons 
            :show-back="true" 
            :next-disabled="true"
            x-bind:next-disabled="!canProceedGroupStep()" />
    </div>
</div>
