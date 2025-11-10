@php
    $totalRegistrations = array_sum($series[0]['data'] ?? []);
@endphp

<div class="col-span-1 rounded-sm border border-stroke bg-white px-5 pb-5 pt-7.5 shadow-default sm:px-7.5">
    <div class="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap">
        <div>
            <p class="font-semibold text-primary">Registration Trend</p>
            <p class="text-xs text-slate-500">Weekly performance over the last 8 weeks</p>
        </div>
        <div class="text-right">
            <p class="text-sm font-semibold text-slate-700">{{ number_format($totalRegistrations) }}</p>
            <p class="text-[11px] text-slate-400">Total sign-ups in window</p>
        </div>
    </div>
    <div id="{{ $chartId }}" class="mt-6 h-72"></div>
</div>

