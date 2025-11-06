<div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500 mb-1">Total Programmes</p>
            <p class="text-3xl font-bold text-slate-800">{{ number_format($totalProgrammes) }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $activeProgrammes }} active</p>
        </div>
        <div class="bg-blue-100 rounded-full p-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21 12a59.768 59.768 0 0 1-3.228-3.125M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>
    </div>
</div>


