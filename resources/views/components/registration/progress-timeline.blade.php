@props(['currentStep', 'totalSteps', 'allowGroupRegistration', 'user'])

<!-- Progress Timeline -->
<div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 md:px-8 py-8">
    <div class="flex items-center justify-between relative">
        <!-- Progress Line -->
        <div class="absolute left-0 right-0 top-1/2 h-1 bg-teal-800/30 -translate-y-1/2 z-0"></div>
        <div class="absolute left-0 top-1/2 h-1 bg-white transition-all duration-500 -translate-y-1/2 z-0" 
             :style="`width: ${((currentStep - 1) / (totalSteps - 1)) * 100}%`"></div>

        <!-- Step 1 (Hidden for logged-in users) -->
        @if(!$user)
        <div class="flex flex-col items-center z-10 relative">
            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                 :class="currentStep >= 1 ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                <span class="font-bold text-xs md:text-sm" x-show="currentStep > 1">✓</span>
                <span class="font-bold text-xs md:text-sm" x-show="currentStep <= 1">1</span>
            </div>
            <span class="text-xs text-white mt-1 font-medium hidden md:block">Account</span>
        </div>
        @endif

        <!-- Step 2 (Step 1 for logged-in users) -->
        <div class="flex flex-col items-center z-10 relative">
            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                 :class="currentStep >= 2 ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                <span class="font-bold text-xs md:text-sm" x-show="currentStep > 2">✓</span>
                <span class="font-bold text-xs md:text-sm" x-show="currentStep <= 2">@if($user) 1 @else 2 @endif</span>
            </div>
            <span class="text-xs text-white mt-1 font-medium hidden md:block">Info</span>
        </div>

        <!-- Step 3 (Group Registration - conditionally shown) -->
        <div x-show="allowGroupRegistration" class="flex flex-col items-center z-10 relative">
            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                 :class="currentStep >= 3 ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                <span class="font-bold text-xs md:text-sm" x-show="currentStep > 3">✓</span>
                <span class="font-bold text-xs md:text-sm" x-show="currentStep <= 3">@if($user) 2 @else 3 @endif</span>
            </div>
            <span class="text-xs text-white mt-1 font-medium hidden md:block">Group</span>
        </div>

        <!-- Step 4 (Promo Code) -->
        <div class="flex flex-col items-center z-10 relative">
            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                 :class="currentStep >= (allowGroupRegistration ? 4 : 3) ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                <span class="font-bold text-xs md:text-sm" x-show="currentStep > (allowGroupRegistration ? 4 : 3)">✓</span>
                <span class="font-bold text-xs md:text-sm" x-show="currentStep <= (allowGroupRegistration ? 4 : 3)">
                    @if($user)
                        <span x-text="allowGroupRegistration ? '3' : '2'"></span>
                    @else
                        <span x-text="allowGroupRegistration ? '4' : '3'"></span>
                    @endif
                </span>
            </div>
            <span class="text-xs text-white mt-1 font-medium hidden md:block">Promo</span>
        </div>

        <!-- Step 5/4 (Confirmation) -->
        <div class="flex flex-col items-center z-10 relative">
            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all duration-300"
                 :class="currentStep >= (allowGroupRegistration ? 5 : 4) ? 'bg-white text-teal-700 shadow-lg' : 'bg-teal-800/40 text-teal-300'">
                <span class="font-bold text-xs md:text-sm">
                    @if($user)
                        <span x-text="allowGroupRegistration ? '4' : '3'"></span>
                    @else
                        <span x-text="allowGroupRegistration ? '5' : '4'"></span>
                    @endif
                </span>
            </div>
            <span class="text-xs text-white mt-1 font-medium hidden md:block">Confirm</span>
        </div>
    </div>

    <!-- Mobile Step Labels -->
    <div class="md:hidden mt-4 text-center">
        <p class="text-white text-sm font-medium">
            Step <span x-text="@if($user) currentStep - 1 @else currentStep @endif"></span> of <span x-text="@if($user) totalSteps - 1 @else totalSteps @endif"></span>: 
            @if(!$user)
            <span x-show="currentStep === 1">Account Type</span>
            @endif
            <span x-show="currentStep === 2">Registration Information</span>
            <span x-show="currentStep === 3 && allowGroupRegistration">Group Members</span>
            <span x-show="(currentStep === 4 && allowGroupRegistration) || (currentStep === 3 && !allowGroupRegistration)">Promo Code</span>
            <span x-show="(currentStep === 5 && allowGroupRegistration) || (currentStep === 4 && !allowGroupRegistration)">Confirmation</span>
        </p>
    </div>
</div>
