<div class="bg-white shadow-md rounded-lg border border-slate-300 p-6">
    <h5 class="text-lg font-semibold text-slate-800 mb-4">Top Programmes by Registrations</h5>
    <div class="space-y-3">
        @forelse($topProgrammes as $programme)
            <div class="flex items-center justify-between p-3 border border-slate-200 rounded-md">
                <div class="flex-1">
                    <p class="font-medium text-slate-800">{{ $programme->title }}</p>
                    <p class="text-sm text-slate-500">{{ $programme->ministry->name ?? 'N/A' }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-700">
                        {{ $programme->registrations_count ?? 0 }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-center text-slate-400 py-4">No programmes available</p>
        @endforelse
    </div>
</div>


