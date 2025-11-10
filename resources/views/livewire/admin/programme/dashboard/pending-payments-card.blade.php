<div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default">
    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-amber-100">
        <svg class="fill-amber-500" width="20" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L1 21H23L12 2Z" />
            <path d="M12 9V13" stroke="white" stroke-width="1.5" stroke-linecap="round" />
            <circle cx="12" cy="16.5" r="1" fill="white" />
        </svg>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <div>
            <h4 class="text-title-md font-bold text-black">{{ number_format($pendingPayments) }}</h4>
            <span class="text-sm font-medium leading-none">Awaiting  For Payment</span>
            <p class="text-xs text-slate-500 mt-1">
                Outstanding value: ${{ number_format($pendingValue, 2) }}
            </p>
        </div>

        <span class="flex flex-col items-end text-right leading-none">
            <span class="text-sm font-semibold text-amber-600">
                {{ $verificationShare !== null ? number_format($verificationShare, 1).'%' : 'N/A' }}
            </span>
            <span class="text-[11px] text-slate-400">of registered payments</span>
        </span>
    </div>
</div>

