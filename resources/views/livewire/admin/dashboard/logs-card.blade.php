<div class="bg-white shadow-md rounded-lg border border-slate-300 p-6">
    <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-semibold text-slate-800">System Logs</h5>
        <a href="{{ route('admin.logs') }}" class="text-sm text-blue-600 hover:underline">View All Logs</a>
    </div>
    <div class="bg-slate-900 rounded-lg p-4 font-mono text-sm overflow-x-auto max-h-[300px] overflow-y-auto">
        @forelse($recentLogs as $log)
            <div class="mb-1 p-1 rounded text-xs text-green-400">
                <pre class="whitespace-pre-wrap break-words">{{ $log }}</pre>
            </div>
        @empty
            <p class="text-slate-400 text-center py-4">No recent logs</p>
        @endforelse
    </div>
</div>


