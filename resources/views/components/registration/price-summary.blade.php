@props(['programme'])

<!-- Price Summary -->
@if($programme->price > 0)
<div class="bg-teal-50 border border-teal-200 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-slate-800 mb-4">Price Summary</h3>
    <div class="space-y-2">
        <div x-show="isGroupRegistration" class="flex justify-between text-slate-600 text-sm mb-2">
            <span>Total Registrants:</span>
            <span class="font-semibold" x-text="groupMembers.length + 1"></span>
        </div>
        <div class="flex justify-between text-slate-700">
            <span>Programme Fee:</span>
            <span class="font-semibold">SGD <span x-text="programmePrice.toFixed(2)"></span></span>
        </div>
        <div x-show="promocodeValid" class="flex justify-between text-green-600">
            <span>Promo Code Discount:</span>
            <span class="font-semibold">- SGD <span x-text="discountAmount.toFixed(2)"></span></span>
        </div>
        <div class="border-t border-teal-300 pt-2 mt-2">
            <div class="flex justify-between text-xl font-bold text-slate-800">
                <span>Total Amount:</span>
                <span class="text-teal-700">SGD <span x-text="calculateTotalCost().toFixed(2)"></span></span>
            </div>
        </div>
    </div>
</div>
@else
<div class="bg-green-50 border border-green-200 rounded-lg p-6">
    <div class="flex items-center">
        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <div>
            <h3 class="text-lg font-semibold text-slate-800">Free Event</h3>
            <p class="text-sm text-slate-600">This is a free event. No payment required.</p>
        </div>
    </div>
</div>
@endif
