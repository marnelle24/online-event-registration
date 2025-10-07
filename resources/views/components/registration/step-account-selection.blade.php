@props(['user'])

<!-- Step 1: Choose Registration Method -->
<div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" 
     x-transition:enter-start="opacity-0 transform translate-x-8" 
     x-transition:enter-end="opacity-100 transform translate-x-0">
    <h2 class="text-2xl font-bold text-slate-800 mb-2">Choose Registration Method</h2>
    <p class="text-slate-600 mb-6">Register as a guest or log in to your existing account.</p>
    
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Register as Guest -->
        <div @click="selectRegistrationType('guest')" 
             class="cursor-pointer border-2 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
             :class="formData.registrationType === 'guest' ? 'border-teal-600 bg-teal-50' : 'border-slate-200 hover:border-teal-500'">
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
           class="cursor-pointer border-2 rounded-xl p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border-slate-200 hover:border-teal-500 block">
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

    <div class="mt-8 flex justify-end">
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
