<div class="bg-white shadow-md rounded-lg border border-slate-300 p-6">
    <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-semibold text-slate-800">Recent Registrations</h5>
        <a href="{{ route('admin.registrants') }}" class="text-sm text-blue-600 hover:underline">View All</a>
    </div>
    <div class="space-y-3 max-h-96 overflow-y-auto">
        @forelse($recentRegistrations as $registrant)
            <div class="flex items-center justify-between p-3 border border-slate-200 rounded-md hover:bg-slate-50">
                <div class="flex-1">
                    <p class="font-medium text-slate-800">{{ $registrant->firstName }} {{ $registrant->lastName }}</p>
                    <p class="text-sm text-slate-500">{{ $registrant->programme->title ?? 'N/A' }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $registrant->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-2 py-1 text-xs rounded-full 
                        {{ $registrant->paymentStatus === 'verified' ? 'bg-green-100 text-green-700' : 
                           ($registrant->paymentStatus === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                        {{ ucfirst($registrant->paymentStatus) }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-center text-slate-400 py-4">No recent registrations</p>
        @endforelse
    </div>
</div>


