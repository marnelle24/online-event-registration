<!-- Contact Information -->
<div class="space-y-4">
    <h3 class="text-lg font-semibold text-slate-800 border-b pb-2">Contact Information</h3>
    
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" x-model="formData.email" required
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                   placeholder="john.doe@example.com">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Contact Number <span class="text-red-500">*</span></label>
            <input type="tel" x-model="formData.contactNumber" required
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                   placeholder="+65 1234 5678">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Address</label>
        <input type="text" x-model="formData.address"
               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
               placeholder="123 Main Street">
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">City</label>
            <input type="text" x-model="formData.city"
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                   placeholder="Singapore">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Postal Code</label>
            <input type="text" x-model="formData.postalCode"
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                   placeholder="123456">
        </div>
    </div>
</div>
