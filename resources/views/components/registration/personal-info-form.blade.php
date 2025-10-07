<!-- Personal Information -->
<div class="space-y-4">
    <h3 class="text-lg font-semibold text-slate-800 border-b pb-2">Personal Information</h3>
    
    <div class="grid md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Title <span class="text-red-500">*</span></label>
            <select x-model="formData.title" required
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                <option value="">Select</option>
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Ms">Ms</option>
                <option value="Dr">Dr</option>
                <option value="Rev">Rev</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">First Name <span class="text-red-500">*</span></label>
            <input type="text" x-model="formData.firstName" required
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                   placeholder="John">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Last Name <span class="text-red-500">*</span></label>
            <input type="text" x-model="formData.lastName" required
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                   placeholder="Doe">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">NRIC/Passport</label>
        <input type="text" x-model="formData.nric"
               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
               placeholder="S1234567A">
    </div>
</div>
