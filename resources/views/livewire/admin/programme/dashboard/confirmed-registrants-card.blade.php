<div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default">
    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-primary/10">
        <svg class="fill-primary" width="22" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
            <path d="M21 12C21 16.9706 16.9706 21 12 21C7.02945 21 3 16.9706 3 12C3 7.02945 7.02945 3 12 3C16.9706 3 21 7.02945 21 12Z" stroke="currentColor" stroke-width="1.5" fill="none" />
        </svg>
    </div>

    <div class="mt-4 flex items-end justify-between">
        <div>
            <h4 class="text-title-md font-bold text-black">{{ number_format($confirmedCount) }}</h4>
            <span class="text-sm font-medium">Confirmed Attendees</span>
            <p class="text-xs text-slate-500 mt-1">
                {{ $waitlistCount > 0 ? number_format($waitlistCount).' awaiting confirmation' : 'No pending confirmations' }}
            </p>
        </div>

        <span class="flex flex-col items-end text-right">
            <span class="text-sm font-semibold text-indigo-600">
                {{ $confirmationRate !== null ? number_format($confirmationRate, 1).'%' : 'N/A' }}
            </span>
            <span class="text-[11px] text-slate-400">Confirmation rate</span>
        </span>
    </div>
</div>

