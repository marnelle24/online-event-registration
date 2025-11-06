<div class="bg-white shadow-md rounded-lg border border-slate-300 p-6">
    <h5 class="text-lg font-semibold text-slate-800 mb-4">Payment Status Distribution</h5>
    <div class="space-y-4">
        @php
            $total = array_sum($paymentStatusDistribution);
        @endphp
        @foreach($paymentStatusDistribution as $status => $count)
            @if($count > 0)
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-slate-700 capitalize">{{ $status }}</span>
                        <span class="text-sm text-slate-600">{{ number_format($count) }} ({{ $total > 0 ? number_format(($count / $total) * 100, 1) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2.5">
                        <div class="h-2.5 rounded-full 
                            {{ $status === 'verified' ? 'bg-green-600' : 
                               ($status === 'pending' ? 'bg-yellow-600' : 
                               ($status === 'failed' ? 'bg-red-600' : 'bg-gray-600')) }}"
                            style="width: {{ $total > 0 ? ($count / $total) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        @if($total === 0)
            <p class="text-center text-slate-400 py-4">No payment data available</p>
        @endif
    </div>
</div>


