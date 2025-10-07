<!-- Main Registrant Information -->
<div class="border border-slate-300 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b">Main Registrant</h3>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <p class="text-sm text-slate-600">Full Name</p>
            <p class="font-semibold" x-text="`${formData.title} ${formData.firstName} ${formData.lastName}`"></p>
        </div>
        <div>
            <p class="text-sm text-slate-600">Email</p>
            <p class="font-semibold" x-text="formData.email"></p>
        </div>
        <div>
            <p class="text-sm text-slate-600">Contact Number</p>
            <p class="font-semibold" x-text="formData.contactNumber"></p>
        </div>
        <div x-show="formData.nric">
            <p class="text-sm text-slate-600">NRIC/Passport</p>
            <p class="font-semibold" x-text="formData.nric"></p>
        </div>
        <div x-show="formData.address" class="md:col-span-2">
            <p class="text-sm text-slate-600">Address</p>
            <p class="font-semibold" x-text="`${formData.address}${formData.city ? ', ' + formData.city : ''}${formData.postalCode ? ' ' + formData.postalCode : ''}`"></p>
        </div>
    </div>
</div>
