<!-- Add Member Button -->
<button @click="addGroupMember" 
        type="button"
        x-show="groupMembers.length < groupRegistrationMax - 1"
        class="w-full border-2 border-dashed border-teal-300 rounded-lg p-6 text-teal-600 hover:border-teal-500 hover:bg-teal-50 transition-all duration-300 flex items-center justify-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
    </svg>
    Add Another Member (<span x-text="groupMembers.length + 1"></span> / <span x-text="groupRegistrationMax"></span>)
</button>
