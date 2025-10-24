<div class="relative" x-data="{ show: false }" @close-modal.window="show = false">
    <button 
        @click="show = true" 
        class="flex items-center gap-2 shadow border border-blue-600/30 bg-slate-600 drop-shadow text-slate-200 hover:bg-slate-700 rounded-full hover:-translate-y-1 duration-300 py-2 px-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        New Ministry
    </button>

    <!-- Backdrop and Slide-over Modal -->
    <div 
        x-show="show" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-hidden"
        x-cloak
        @keydown.escape="show = false">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity"
             @click="show = false"></div>
             
        <!-- Slide Panel -->
        <div 
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 h-full w-full max-w-lg bg-white shadow-xl"
        >
                
            <div class="flex h-full flex-col">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-400">
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Add Ministry</h2>
                    <button 
                        @click="show = false" 
                        class="text-slate-600 hover:text-slate-900 text-xl p-2 rounded-full hover:bg-slate-300/50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-white hover:stroke-slate-200 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <x-validation-errors :class="'mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md'" />
                    
                    @if (session()->has('message'))
                        <div class="mb-4 text-green-700 bg-green-300/40 border border-green-600/20 rounded-md p-3 text-sm">
                            {{ session('message') }}
                        </div> 
                    @endif
                    
                    <form wire:submit.prevent="save" class="flex flex-col gap-4">
                        <div>
                            <p class="italic text-md text-slate-500">
                                Create a new ministry or organization for your events.
                                This ministry can be assigned to multiple programmes and events.
                            </p>
                        </div>
                        
                        <div class="space-y-4 flex flex-col gap-4">
                            <!-- Name -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Ministry Name<span class="text-red-500 px-1">*</span></label>
                                <input 
                                    wire:model="name"
                                    type="text" 
                                    placeholder="e.g. Youth Ministry, Women's Fellowship, etc." 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Bio/Description</label>
                                <textarea 
                                    wire:model="bio"
                                    rows="4"
                                    placeholder="Brief description about the ministry..." 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"
                                ></textarea>
                                @error('bio')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Contact Person -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Contact Person<span class="text-red-500 px-1">*</span></label>
                                <input 
                                    wire:model="contactPerson"
                                    type="text" 
                                    placeholder="Full name of contact person" 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('contactPerson')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Contact Number</label>
                                <input 
                                    wire:model="contactNumber"
                                    type="tel" 
                                    placeholder="+65 1234 5678" 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('contactNumber')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Contact Email -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Contact Email</label>
                                <input 
                                    wire:model="contactEmail"
                                    type="email" 
                                    placeholder="contact@ministry.com" 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('contactEmail')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Website URL -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Website URL</label>
                                <input 
                                    wire:model="websiteUrl"
                                    type="url" 
                                    placeholder="https://www.ministry.com" 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('websiteUrl')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-2">
                                <!-- Logo Upload -->
                                <label class="block text-sm font-medium text-black">Ministry Logo</label>
                                <div class="border border-slate-300 rounded-md p-2">
                                    <input 
                                        wire:model="logo"
                                        type="file" 
                                        accept="image/*"
                                        class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('logo')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status Toggles -->
                            <div class="grid grid-cols-1 gap-3">
                                <!-- Status Toggle -->
                                <div class="flex items-center">
                                    <span class="text-md font-medium text-black mr-1 w-22.5">Status</span>
                                    <label for="addMinistryStatus" class="flex cursor-pointer select-none items-center">
                                        <div class="relative" x-data="{ status: @entangle('status') }">
                                            <input 
                                                wire:model="status"
                                                type="checkbox" id="addMinistryStatus" class="sr-only" />
                                            <div :class="status && '!bg-success'" class="cursor-pointer block h-8 w-14 rounded-full bg-black"></div>
                                            <div :class="status && '!right-1 !translate-x-full'" class="cursor-pointer absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Publishable Toggle -->
                                <div class="flex items-center">
                                    <span class="text-md font-medium text-black mr-1 w-22.5">Publishable</span>
                                    <label for="addMinistryPublishable" class="flex select-none items-center">
                                        <div class="relative" x-data="{ publishabled: @entangle('publishabled') }">
                                            <input 
                                                wire:model="publishabled"
                                                type="checkbox" id="addMinistryPublishable" class="sr-only" />
                                            <div :class="publishabled && '!bg-success'" class="cursor-pointer block h-8 w-14 rounded-full bg-black"></div>
                                            <div :class="publishabled && '!right-1 !translate-x-full'" class="cursor-pointer absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Searchable Toggle -->
                                <div class="flex items-center">
                                    <span class="text-md font-medium text-black mr-1 w-22.5">Searchable</span>
                                    <label for="addMinistrySearchable" class="flex select-none items-center">
                                        <div class="relative" x-data="{ searcheable: @entangle('searcheable') }">
                                            <input 
                                                wire:model="searcheable"
                                                type="checkbox" id="addMinistrySearchable" class="sr-only" />
                                            <div :class="searcheable && '!bg-success'" class="cursor-pointer block h-8 w-14 rounded-full bg-black"></div>
                                            <div :class="searcheable && '!right-1 !translate-x-full'" class="cursor-pointer absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center gap-4">
                                <button 
                                    wire:target="save"
                                    wire:loading.attr="disabled"
                                    type="submit" 
                                    class="disabled:cursor-not-allowed disabled:opacity-50 w-full flex justify-center p-4 items-center rounded-md text-md text-white drop-shadow uppercase bg-green-700 hover:bg-green-600 duration-300">
                                    <span wire:loading.remove wire:target="save">
                                        Save
                                    </span>
                                    <span wire:loading wire:target="save">
                                        Saving...
                                    </span>
                                </button>
                                <button 
                                    type="button"
                                    wire:click="resetForm" 
                                    class="bg-slate-500 hover:bg-slate-600 duration-300 text-white p-4 rounded-md">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
