<div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500 mb-1">Pending Payments</p>
            <p class="text-3xl font-bold text-yellow-600">{{ number_format($pendingPayments) }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $verifiedPayments }} verified</p>
        </div>
        <div class="bg-yellow-100 rounded-full p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-yellow-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
    </div>
</div>


