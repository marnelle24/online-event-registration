<div class="py-6">
    <!-- Header Section -->
    <div class="flex justify-between gap-3 mb-6 lg:flex-row flex-col lg:items-center items-start">
        <div>
            <h4 class="text-3xl font-bold text-black capitalize">System Logs Viewer</h4>
            <p class="text-sm text-slate-500">View and monitor application logs</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="refreshLogs" 
                class="flex items-center gap-2 border border-slate-500 bg-slate-100 drop-shadow text-slate-500 hover:text-slate-200 hover:bg-slate-600 rounded-full hover:-translate-y-1 duration-300 py-2 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Refresh
            </button>
            <button wire:click="clearLogs" 
                wire:confirm="Are you sure you want to clear all logs? This action cannot be undone."
                class="flex items-center gap-2 border border-red-500 bg-red-100 drop-shadow text-red-600 hover:text-white hover:bg-red-600 rounded-full hover:-translate-y-1 duration-300 py-2 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                Clear Logs
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Log Level Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Log Level</label>
                <select 
                    wire:model.live="selectedLevel" 
                    class="w-full py-2 px-3 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500"
                >
                    <option value="all">All Levels</option>
                    <option value="emergency">Emergency</option>
                    <option value="alert">Alert</option>
                    <option value="critical">Critical</option>
                    <option value="error">Error</option>
                    <option value="warning">Warning</option>
                    <option value="notice">Notice</option>
                    <option value="info">Info</option>
                    <option value="debug">Debug</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Search</label>
                <input 
                    wire:model.live.debounce.300ms="searchTerm" 
                    type="search" 
                    placeholder="Search in logs..."
                    class="w-full py-2 px-3 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500"
                />
            </div>
        </div>

        <!-- Log File Info -->
        <div class="mt-4 pt-4 border-t border-slate-200">
            <p class="text-sm text-slate-600">
                <span class="font-medium">Log File:</span> {{ $logFile }}
                <span class="ml-4 font-medium">Total Lines:</span> {{ number_format($totalLines) }}
                <span class="ml-4 font-medium">Showing:</span> {{ count($logs) }} of {{ $totalLines }} lines
            </p>
        </div>
    </div>

    <!-- Logs Display -->
    <div class="bg-white shadow-md rounded-lg border border-slate-300 p-6">
        @if(count($logs) > 0)
            <div class="bg-slate-900 text-green-400 rounded-lg p-4 font-mono text-sm overflow-x-auto max-h-[600px] overflow-y-auto">
                @foreach($logs as $index => $log)
                    <div class="mb-2 p-2 rounded {{ $this->getLogLevelClass($log) }}">
                        <pre class="whitespace-pre-wrap break-words text-xs">{{ $log }}</pre>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Showing page {{ $page }} of {{ $this->totalPages }}
                </div>
                <div class="flex gap-2">
                    <button 
                        wire:click="previousPage"
                        wire:loading.attr="disabled"
                        @if($page <= 1) disabled @endif
                        class="px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Previous
                    </button>
                    <button 
                        wire:click="nextPage"
                        wire:loading.attr="disabled"
                        @if($page >= $this->totalPages) disabled @endif
                        class="px-4 py-2 border border-slate-300 rounded-md bg-white text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next
                    </button>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-slate-400 mx-auto mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                <p class="text-slate-500 text-lg">No logs found</p>
                <p class="text-slate-400 text-sm mt-2">
                    @if($selectedLevel !== 'all' || !empty($searchTerm))
                        Try adjusting your filters
                    @else
                        No log entries available
                    @endif
                </p>
            </div>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
</div>

