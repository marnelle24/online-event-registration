@props(['programme'])

<!-- Group Registration Option -->
<div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
    <div class="flex items-start">
        <input type="checkbox" 
               x-model="isGroupRegistration" 
               id="groupRegistration"
               class="mt-1 h-5 w-5 text-teal-600 focus:ring-teal-500 border-slate-300 rounded">
        <label for="groupRegistration" class="ml-3 flex-1">
            <span class="block text-lg font-semibold text-slate-800">Register as a Group</span>
            <span class="block text-sm text-slate-600 mt-1">
                Group registration is allowed in this programme, you can register multiple people at once.
                <br />
                Group size: {{ $programme->groupRegistrationMin }} - {{ $programme->groupRegistrationMax }} members
            </span>
        </label>
    </div>
</div>
