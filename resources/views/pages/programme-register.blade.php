@section('title', 'Register for '.$programme->title)

@push('styles')
    <script>
        // Registration form configuration
        window.registrationConfig = {
            user: @json($user ? true : false),
            allowGroupRegistration: @json($programme->allowGroupRegistration),
            groupRegistrationMin: {{ $programme->groupRegistrationMin ?? 2 }},
            groupRegistrationMax: {{ $programme->groupRegistrationMax ?? 10 }},
            groupRegIndividualFee: {{ $programme->groupRegIndividualFee ?? $programme->price }},
            programmePrice: {{ $programme->price }},
            hasActivePromocodes: @json($hasActivePromocodes),
            programmeCode: '{{ $programmeCode }}',
            programmeId: {{ $programme->id }},
            userTitle: @if($user && $user->firstname && $user->lastname) 
                @php
                    // Try to determine title from name patterns
                    $fullName = $user->name ?? '';
                    $firstName = $user->firstname ?? '';
                    if (str_contains(strtolower($fullName), 'dr.') || str_contains(strtolower($firstName), 'dr')) {
                        echo "'Dr'";
                    } elseif (str_contains(strtolower($fullName), 'rev.') || str_contains(strtolower($firstName), 'rev')) {
                        echo "'Rev'";
                    } else {
                        echo "''";
                    }
                @endphp
            @else null @endif,
            userFirstName: @if($user && $user->firstname) '{{ $user->firstname }}' @else null @endif,
            userLastName: @if($user && $user->lastname) '{{ $user->lastname }}' @else null @endif,
            userEmail: @if($user && $user->email) '{{ $user->email }}' @else null @endif,
        };
    </script>
    @vite(['resources/js/registration-form.js'])
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
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 stroke-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @if($programme->price > 0)
                                        {{ $programme->formattedPrice }}
                                @else
                                    <span class="capitalize font-bold text-slate-600">
                                        Free Event
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div x-data="registrationForm(window.registrationConfig)" class="bg-white rounded-lg shadow-lg overflow-hidden">
                
                <!-- Progress Timeline -->
                <x-registration.progress-timeline 
                    :current-step="'currentStep'" 
                    :total-steps="'totalSteps'" 
                    :allow-group-registration="'allowGroupRegistration'" 
                    :has-active-promocodes="'hasActivePromocodes'"
                    :user="$user" />

                <!-- Form Steps -->
                <div class="p-6 md:p-8 registration-form-container">
                    
                    <!-- Error Alert -->
                    <div x-show="showErrors" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="error-alert mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-md"
                         role="alert">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-semibold text-red-800" x-text="errorMessage"></h3>
                                <div x-show="Object.keys(validationErrors).length > 0" class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <template x-for="(errors, field) in validationErrors" :key="field">
                                            <li>
                                                <span class="font-medium capitalize" x-text="field.replace('_', ' ')"></span>: 
                                                <span x-text="Array.isArray(errors) ? errors[0] : errors"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            <div class="ml-3 flex-shrink-0">
                                <button @click="clearErrors()" 
                                        type="button"
                                        class="inline-flex text-red-500 hover:text-red-700 focus:outline-none transition-colors">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 1: Choose Registration Method (Only for guests) -->
                    @if(!$user)
                    <x-registration.step-account-selection :user="$user" />
                    @endif

                    <!-- Step 2: Registration Information -->
                    <x-registration.step-registration-info :user="$user" :programme="$programme" />

                    <!-- Step 3: Group Members -->
                    <x-registration.step-group-members :programme="$programme" />

                    <!-- Step 4: Promo Code (Only when active promocodes exist) -->
                    @if($hasActivePromocodes)
                    <x-registration.step-promo-code />
                    @endif

                    <!-- Step 5: Confirmation -->
                    <x-registration.step-confirmation :programme="$programme" />

                </div>
            </div>

        </div>
    </div>
    <x-footer-public />
</x-guest-layout>

