<!-- Group Members Summary -->
<div x-show="isGroupRegistration && groupMembers.length > 0" class="border border-slate-300 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b">Group Members</h3>
    <div class="space-y-4">
        <template x-for="(member, index) in groupMembers" :key="index">
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="font-semibold text-slate-800 mb-2">
                    Member <span x-text="index + 2"></span>: 
                    <span x-text="`${member.title} ${member.firstName} ${member.lastName}`"></span>
                </p>
                <div class="grid md:grid-cols-2 gap-2 text-sm">
                    <p class="text-slate-600">Email: <span class="text-slate-800" x-text="member.email"></span></p>
                    <p class="text-slate-600">Contact: <span class="text-slate-800" x-text="member.contactNumber"></span></p>
                </div>
            </div>
        </template>
    </div>
</div>
