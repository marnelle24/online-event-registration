<div class="relative" x-data="{ show: false }" @close-modal.window="show = false">
    <!-- Trigger button -->
    <button 
        @click="show = true" 
        type="button" 
        class="tracking-widest font-thin uppercase inline-flex items-center bg-green-600 hover:scale-105 hover:bg-green-500 duration-300 justify-center rounded-md border border-green-600 py-2 px-3 text-center text-white drop-shadow text-xs"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Promotion
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
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Add Promotion</h2>
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
                    
                    <form wire:submit.prevent="save" class="flex flex-col gap-4 h-screen">
                        <div>
                            <p class="italic text-md text-slate-500">
                                Create a new promotion for this programme.
                                Newly created promotion will immediately applicable to the programme as long as
                                it is active and within the date range validity.
                            </p>
                        </div>
                        <div class="space-y-4 flex flex-col gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Title<span class="text-red-500 px-1">*</span></label>
                                <input 
                                    wire:model="title"
                                    type="text" 
                                    placeholder="Title" 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('title')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Description</label>
                                <textarea 
                                    wire:model="description"
                                    rows="3"
                                    placeholder="Description" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"></textarea>
                                @error('description')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex md:flex-row flex-col md:justify-between justify-center items-center gap-4">
                                <div class="w-full">
                                    <label class="mb-1 block text-sm font-medium text-black">Start Date<span class="text-red-500 px-1">*</span></label>
                                    <input 
                                        type="datetime-local" 
                                        wire:model="startDate" 
                                        class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('startDate')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
    
                                <div class="w-full">
                                    <label class="mb-1 block text-sm font-medium text-black">End Date<span class="text-red-500 px-1">*</span></label>
                                    <input 
                                        type="datetime-local" 
                                        wire:model="endDate" 
                                        class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('endDate')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex justify-between items-center gap-4">
                                <div class="w-full">
                                    <label class="mb-1 block text-sm font-medium text-black">Price<span class="text-red-500 px-1">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-4.5 top-3 flex text-slate-500">$</span>
                                        <input 
                                            wire:model="price"
                                            class="w-full rounded text-lg border border-stroke bg-transparent py-2 pl-16 font-medium placeholder:text-slate-500 text-black focus:ring-0" 
                                            type="number"
                                            step="0.10" 
                                            placeholder="0.00" 
                                        />
                                    </div>
                                    @error('price')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="mb-1 block text-sm font-medium text-black">Arrangement</label>
                                    <input 
                                        step="1"
                                        type="number" 
                                        wire:model="arrangement" 
                                        class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('arrangement')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div x-data="{ isActive: @entangle('isActive') }" class="flex">
                                <label for="newPromotionStatus" class="flex cursor-pointer select-none items-center">
                                    <span class="text-sm font-medium text-black mr-1">Status</span>
                                    <div class="relative">
                                        <input 
                                            wire:model="isActive"
                                            type="checkbox" id="newPromotionStatus" class="sr-only" />
                                        <div :class="isActive && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                        <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                    </div>
                                </label>
                            </div>

                            <div 
                                x-data="{ groupOnly: @entangle('isGroup') }" 
                                class="border border-slate-200 rounded-lg p-4 bg-slate-50/40 space-y-2"
                            >
                                @if($errors->has('minGroup') || $errors->has('maxGroup'))
                                    <div class="bg-red-100 border border-red-400 text-red-700 rounded-md p-3 text-xs mb-4">{{ 'Please fill in the minimum and maximum group size' }}</div>
                                @endif
                                <label for="promotion-is-group" class="text-base font-semibold text-black mb-2">Group Promotion</label>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-slate-500 italic">Enable if this promotion applies to group registrations only.</p>
                                    <label for="promotion-is-group" class="flex cursor-pointer select-none items-center">
                                        <div class="relative">
                                            <input 
                                                wire:model="isGroup"
                                                type="checkbox" 
                                                id="promotion-is-group" 
                                                class="sr-only" 
                                            />
                                            <div :class="groupOnly && '!bg-blue-600'" class="block h-6 w-10 rounded-full bg-black/40 transition-colors duration-200"></div>
                                            <div :class="groupOnly && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-4 w-4 items-center justify-center rounded-full bg-white transition-all duration-200"></div>
                                        </div>
                                    </label>
                                </div>

                                <div 
                                    x-show="groupOnly"
                                    x-transition
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                                >
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Minimum Group Size<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            type="number"
                                            min="1"
                                            wire:model="minGroup"
                                            class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-white px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                            placeholder="e.g. 2"
                                        />
                                        @error('minGroup')
                                            <span class="text-red-500 text-xs">{{ 'Min group size is required' }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-black">Maximum Group Size<span class="text-red-500 px-1">*</span></label>
                                        <input 
                                            type="number"
                                            min="1"
                                            wire:model="maxGroup"
                                            class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-white px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                            placeholder="e.g. 5"
                                        />
                                        @error('maxGroup')
                                            <span class="text-red-500 text-xs">{{ 'Max group size is required' }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

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