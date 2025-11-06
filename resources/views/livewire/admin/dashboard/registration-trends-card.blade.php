 <div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 mb-8">
    <h5 class="text-lg font-semibold text-slate-800 mb-4">Registration Trends (Last {{ $selectedPeriod }} days)</h5>
    <div id="registrationTrendsChart"
         data-trends="{{ json_encode($registrationTrends->toArray()) }}"
         data-period="{{ $selectedPeriod }}"
         wire:key="chart-{{ $selectedPeriod }}"
         class="flex items-center justify-center dashboard-chart1"
         style="width: 100%; min-height: 350px; height: 100%;">
    </div>
</div>

