<!-- Promo Code Step (Always second-to-last step when active promocodes exist) -->
<div x-show="hasActivePromocodes && currentStep === (totalSteps - 1)" 
     x-transition:enter="transition ease-out duration-300" 
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
                class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center">
            Continue
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </button>
    </div>
</div>
