<!-- Group Summary -->
<div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
    <div class="flex items-center justify-between">
        <span class="text-sm font-medium text-slate-700">Total Group Members:</span>
        <span class="text-lg font-bold text-teal-600" x-text="groupMembers.length + 1"></span>
    </div>
    <p class="text-xs text-slate-500 mt-2" x-show="!canProceedGroupStep()">
        <span class="text-red-600">⚠</span> Minimum <span x-text="groupRegistrationMin"></span> members required to proceed.
    </p>
</div>
