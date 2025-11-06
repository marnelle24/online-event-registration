<div class="bg-white shadow-md rounded-lg border border-slate-300 p-6">
    <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-semibold text-slate-800">Upcoming Programmes</h5>
        <a href="{{ route('admin.programmes') }}" class="text-sm text-blue-600 hover:underline">View All</a>
    </div>
    <div class="space-y-3 max-h-96 overflow-y-auto">
        @forelse($upcomingProgrammes as $programme)
            <div class="flex items-center justify-between p-3 border border-slate-200 rounded-md hover:bg-slate-50">
                <div class="flex-1">
                    <p class="font-medium text-slate-800">{{ $programme->title }}</p>
                    <p class="text-sm text-slate-500">{{ $programme->ministry->name ?? 'N/A' }}</p>
                    <p class="text-xs text-slate-400 mt-1">
                        {{ \Carbon\Carbon::parse($programme->startDate)->format('M d, Y') }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                        {{ $programme->total_registrations ?? 0 }} registrations
                    </span>
                </div>
            </div>
        @empty
            <p class="text-center text-slate-400 py-4">No upcoming programmes</p>
        @endforelse
    </div>
</div>


