<div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500 mb-1">Total Revenue</p>
            <p class="text-3xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
            <p class="text-xs text-slate-400 mt-1">${{ number_format($recentRevenue, 2) }} in last {{ $selectedPeriod }} days</p>
        </div>
        <div class="bg-green-100 rounded-full p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 19.5h15.75a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 18.75 4.5H2.25A2.25 2.25 0 0 0 0 6.75v10.5A2.25 2.25 0 0 0 2.25 19.5Z" />
            </svg>
        </div>
    </div>
</div>


