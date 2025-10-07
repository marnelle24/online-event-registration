@props(['user' => null, 'showBack' => true, 'showNext' => true, 'nextDisabled' => false, 'nextText' => 'Continue'])

<!-- Navigation Buttons -->
<div class="flex flex-col sm:flex-row justify-between gap-4 pt-4">
    @if($showBack)
    <button @click="previousStep" 
            type="button"
            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-8 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
        </svg>
        Back
    </button>
    @else
    <div></div> <!-- Empty div to maintain layout -->
    @endif
    
    @if($showNext)
    <button @click="nextStep" 
            type="button"
            :disabled="{{ $nextDisabled ? 'true' : 'false' }}"
            class="bg-teal-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-teal-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
        {{ $nextText }}
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
    </button>
    @endif
</div>
