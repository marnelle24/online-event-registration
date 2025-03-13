@section('title', 'Update Ministry')
<x-app-layout>
    <h4 class="text-2xl font-bold text-black dark:text-slate-600 mb-8 capitalize">Update Ministry</h4>
    @if (session('error'))
        <div class="bg-red-100 border flex justify-between items-center border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button type="button" class="close" onclick="this.parentElement.remove()" aria-label="Close">
                <span aria-hidden="true" class="text-red-700 text-2xl">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border flex justify-between items-center border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <div>
                <span class="block sm:inline text-sm font-bold">Please fix the following errors:</span>
                <ul class="list-none list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 text-xs">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="close" onclick="this.parentElement.remove()" aria-label="Close">
                <span aria-hidden="true" class="text-red-700 text-2xl">&times;</span>
            </button>
        </div>
    @endif

    <div class="flex gap-4">
        <form action="{{ route('admin.ministry.update', $ministry->id) }}" method="POST" class="w-2/3">
            <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
                @csrf
                @method('PUT')
                <div class="flex gap-4">
                    <div class="w-2/3">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                placeholder="Name"
                                value="{{ old('name', $ministry->name) }}" 
                                class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                        </div>
                        <div class="mb-4">
                            <label for="contactPerson" class="block text-gray-700 text-sm font-bold mb-2">Contact Person</label>
                            <input 
                                type="text" 
                                name="contactPerson" 
                                id="contactPerson" 
                                placeholder="Contact Person"
                                value="{{ old('contactPerson', $ministry->contactPerson) }}" 
                                class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                        </div>
                        <div class="mb-4">
                            <label for="contactNumber" class="block text-gray-700 text-sm font-bold mb-2">Contact Number</label>
                            <input 
                                type="text" 
                                name="contactNumber" 
                                id="contactNumber" 
                                placeholder="Contact Number"
                                value="{{ old('contactNumber', $ministry->contactNumber) }}" 
                                class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                        </div>
                        <div class="mb-4">
                            <label for="contactEmail" class="block text-gray-700 text-sm font-bold mb-2">Contact Email</label>
                            <input 
                                type="text" 
                                name="contactEmail" 
                                id="contactEmail" 
                                placeholder="Email Address"
                                value="{{ old('contactEmail', $ministry->contactEmail) }}" 
                                class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                        </div>
                        <div class="mb-4">
                            <label for="websiteUrl" class="block text-gray-700 text-sm font-bold mb-2">Website</label>
                            <input 
                                type="text" 
                                name="websiteUrl" 
                                id="websiteUrl" 
                                placeholder="https://mywebsite.com"
                                value="{{ old('websiteUrl', $ministry->website) }}" 
                                class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                        </div>
                        <div>
                            {{-- <h4 class="text-lg font-bold text-black dark:text-slate-600 capitalize border-b-4 border-slate-500 mb-3 py-1">Settings</h4> --}}
                            <div class="flex gap-4">
                                <div class="mb-4 w-1/3">
                                    <label for="publishabled" class="block text-gray-700 text-sm font-bold mb-2">Make it Publishable</label>
                                    <select name="publishabled" id="publishabled" 
                                        class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                        <option value="1" {{ old('publishabled', $ministry->publishabled) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('publishabled', $ministry->publishabled) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="mb-4 w-1/3">
                                    <label for="searcheable" class="block text-gray-700 text-sm font-bold mb-2">Make it Searchable</label>
                                    <select name="searcheable" id="searcheable" 
                                        class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                        <option value="1" {{ old('searcheable', $ministry->searcheable) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('searcheable', $ministry->searcheable) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="mb-4 w-1/3">
                                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                                    <select name="status" id="status" 
                                        class="w-full rounded-none bg-zinc-50 py-3 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">
                                        <option value="1" {{ old('status', $ministry->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $ministry->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/3">
                        <div class="mb-4">
                            <label for="bio" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea 
                                name="bio" 
                                id="bio" 
                                rows="6" 
                                placeholder="Description"
                                class="w-full rounded-none bg-zinc-50 py-3 h-100 px-5 font-medium outline-none ring-0 border border-neutral-300 dark:border-neutral-600 focus:outline-none dark:focus:outline-none focus:ring-1 focus:ring-slate-50/50 dark:focus:ring-slate-50/50 transition disabled:cursor-default disabled:bg-whiter dark:bg-form-input">{{ old('bio', $ministry->bio) }}</textarea>
                        </div>
                    </div>
                </div>
    
    
    
                {{-- </form> --}}
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('admin.ministries') }}" class="text-slate-600 bg-slate-100 hover:bg-slate-200 dark:bg-slate-300 dark:hover:bg-slate-400 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold py-3 px-5 mr-2">
                    Cancel
                </a>
                <div>
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                        class="flex items-center hover:-translate-y-1 duration-300 justify-center rounded-full bg-slate-600 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-slate-700 py-3 px-6 font-medium text-white">
                        Update Ministry
                    </button>
                    <span wire:loading.delay.longest class="ml-2">
                        saving...
                    </span>
                </div>

            </div>
        </form>
        <div class="w-1/3">
            <livewire:ministry.add-user-to-ministry :ministry="$ministry" />
        </div>
    </div>
</x-app-layout> 