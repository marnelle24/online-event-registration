<div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default">
    <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-emerald-100">
        <svg class="fill-emerald-600" width="20" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 3C7.029 3 3 7.029 3 12C3 16.971 7.029 21 12 21C16.971 21 21 16.971 21 12C21 7.029 16.971 3 12 3ZM12 19.4C7.913 19.4 4.6 16.087 4.6 12C4.6 7.913 7.913 4.6 12 4.6C16.087 4.6 19.4 7.913 19.4 12C19.4 16.087 16.087 19.4 12 19.4Z" />
            <path d="M12.6 7H11.4V10.257C9.889 10.534 9 11.571 9 12.9C9 14.457 10.143 15.486 11.85 15.486C12.681 15.486 13.455 15.3 14.1 14.961V13.872C13.518 14.211 12.897 14.4 12.18 14.4C11.154 14.4 10.5 13.875 10.5 12.948C10.5 12.057 11.124 11.511 12.6 11.511H12.6V7Z" />
        </svg>
    </div>

    <div class="mt-4 flex items-end justify-between">
        <div>
            <h4 class="text-title-md font-bold text-black">${{ number_format($totalRevenue, 2) }}</h4>
            <span class="text-sm font-medium">Revenue Collected</span>
            <p class="text-xs text-slate-500 mt-1">
                Last 7 days: ${{ number_format($recentRevenue, 2) }}
            </p>
        </div>

        <span class="flex flex-col items-end text-right">
            <span class="text-sm font-semibold text-emerald-600">
                {{ $averageTicketValue !== null ? '$'.number_format($averageTicketValue, 2) : 'N/A' }}
            </span>
            <span class="text-[11px] text-slate-400">Average ticket value</span>
        </span>
    </div>
</div>

