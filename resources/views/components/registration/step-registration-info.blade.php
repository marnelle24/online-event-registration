@props(['user', 'programme'])

<!-- Step 2: Registration Information -->
<div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" 
     x-transition:enter-start="opacity-0 transform translate-x-8" 
     x-transition:enter-end="opacity-100 transform translate-x-0">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Registration Information</h2>
    <p class="text-slate-600 mb-6">Please provide your details to complete the registration.</p>
    
    @if($user)
    <!-- Pre-filled data notice -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-blue-800">Welcome back, {{ $user->firstname ?? $user->name }}!</p>
                <p class="text-sm text-blue-700 mt-1">We've pre-filled some information from your account. Please review and update as needed.</p>
            </div>
        </div>
    </div>
    @endif
    
    <div class="space-y-6">
        <!-- Personal Information -->
        <x-registration.personal-info-form />
        
        <!-- Contact Information -->
        <x-registration.contact-info-form />

        <!-- Group Registration Option -->
        @if($programme->allowGroupRegistration)
        <x-registration.group-registration-option :programme="$programme" />
        @endif

        <!-- Navigation Buttons -->
        <x-registration.navigation-buttons :user="$user" :show-back="!$user" />
    </div>
</div>
