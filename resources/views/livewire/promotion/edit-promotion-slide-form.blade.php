<div class="relative">
    <button 
        x-data="{ showToolTip: false }"
        wire:click="openModal"
        @mouseover="showToolTip = true" 
        @mouseleave="showToolTip = false"
        class="flex items-center"
    >
        <svg 
            class="w-6 h-6 stroke-blue-500 hover:scale-110 duration-300 hover:stroke-blue-600"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
        </svg>
          
        
        <div 
            x-show="showToolTip" 
            x-transition 
            class="absolute top-full -left-1 mt-1 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50"
        >
            Update
        </div>
    </button>

    <!-- Backdrop and Slide-over Modal -->
    @if ($show)
        <div class="fixed inset-0 z-40">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/50"
                 wire:click="closeModal">
            </div>

            <!-- Slide-over Modal -->
            <div class="absolute inset-y-0 right-0 lg:w-1/4 w-full bg-white shadow-lg z-50 transform transition-transform duration-300 overflow-auto" style="transform: translateX(0%)">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-400">
                    <h2 class="text-white text-2xl uppercase font-light">Update Promotion</h2>
                    <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900 text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-slate-800 hover:stroke-slate-500 hover:-translate-y-1 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 h-screen">
                    <x-validation-errors :class="'p-5'" />
                    
                    @if (session()->has('message'))
                        <div class="text-green-700 bg-green-300/40 border border-green-600/20 rounded-md p-3 text-sm">{{ session('message') }}</div> 
                    @endif
                    
                    <form wire:submit.prevent="save" class="flex flex-col gap-4 p-5 h-screen">
                        <div>
                            <p class="italic text-md text-slate-500">
                                Update the promotion for this programme.
                                Any changes made to the promotion will immediately applicable to the programme as long as
                                it is active and within the date range validity.
                            </p>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-black">Name</label>
                            <input 
                                wire:model="title"
                                type="text" placeholder="Name" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" />
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
                        <div class="flex flex-col gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">
                                    Start Date
                                </label>
                                <div class="relative">
                                    <input 
                                        wire:model="startDate"
                                        type="datetime-local"
                                        class="w-full rounded border border-stroke bg-transparent py-3 font-normal outline-none transition focus:border-slate-500 active:border-slate-500 focus:ring-0" placeholder="mm/dd/yyyy" 
                                    />
                                    <div class="pointer-events-none absolute inset-0 left-auto right-3 flex items-center">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" class="bg-white">
                                            <path d="M15.7504 2.9812H14.2879V2.36245C14.2879 2.02495 14.0066 1.71558 13.641 1.71558C13.2754 1.71558 12.9941 1.99683 12.9941 2.36245V2.9812H4.97852V2.36245C4.97852 2.02495 4.69727 1.71558 4.33164 1.71558C3.96602 1.71558 3.68477 1.99683 3.68477 2.36245V2.9812H2.25039C1.29414 2.9812 0.478516 3.7687 0.478516 4.75308V14.5406C0.478516 15.4968 1.26602 16.3125 2.25039 16.3125H15.7504C16.7066 16.3125 17.5223 15.525 17.5223 14.5406V4.72495C17.5223 3.7687 16.7066 2.9812 15.7504 2.9812ZM1.77227 8.21245H4.16289V10.9968H1.77227V8.21245ZM5.42852 8.21245H8.38164V10.9968H5.42852V8.21245ZM8.38164 12.2625V15.0187H5.42852V12.2625H8.38164V12.2625ZM9.64727 12.2625H12.6004V15.0187H9.64727V12.2625ZM9.64727 10.9968V8.21245H12.6004V10.9968H9.64727ZM13.8379 8.21245H16.2285V10.9968H13.8379V8.21245ZM2.25039 4.24683H3.71289V4.83745C3.71289 5.17495 3.99414 5.48433 4.35977 5.48433C4.72539 5.48433 5.00664 5.20308 5.00664 4.83745V4.24683H13.0504V4.83745C13.0504 5.17495 13.3316 5.48433 13.6973 5.48433C14.0629 5.48433 14.3441 5.20308 14.3441 4.83745V4.24683H15.7504C16.0316 4.24683 16.2566 4.47183 16.2566 4.75308V6.94683H1.77227V4.75308C1.77227 4.47183 1.96914 4.24683 2.25039 4.24683ZM1.77227 14.5125V12.2343H4.16289V14.9906H2.25039C1.96914 15.0187 1.77227 14.7937 1.77227 14.5125ZM15.7504 15.0187H13.8379V12.2625H16.2285V14.5406C16.2566 14.7937 16.0316 15.0187 15.7504 15.0187Z" fill="#64748B" />
                                        </svg>
                                    </div>
                                </div>
                                @error('startDate')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">
                                    End Date
                                </label>
                                <div class="relative">
                                    <input 
                                        wire:model="endDate"
                                        type="datetime-local"
                                        class="w-full rounded border border-stroke bg-transparent py-3 font-normal outline-none transition focus:border-slate-500 active:border-slate-500 focus:ring-0" placeholder="mm/dd/yyyy" 
                                    />
                                    <div class="pointer-events-none absolute inset-0 left-auto right-3 flex items-center">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" class="bg-white">
                                            <path d="M15.7504 2.9812H14.2879V2.36245C14.2879 2.02495 14.0066 1.71558 13.641 1.71558C13.2754 1.71558 12.9941 1.99683 12.9941 2.36245V2.9812H4.97852V2.36245C4.97852 2.02495 4.69727 1.71558 4.33164 1.71558C3.96602 1.71558 3.68477 1.99683 3.68477 2.36245V2.9812H2.25039C1.29414 2.9812 0.478516 3.7687 0.478516 4.75308V14.5406C0.478516 15.4968 1.26602 16.3125 2.25039 16.3125H15.7504C16.7066 16.3125 17.5223 15.525 17.5223 14.5406V4.72495C17.5223 3.7687 16.7066 2.9812 15.7504 2.9812ZM1.77227 8.21245H4.16289V10.9968H1.77227V8.21245ZM5.42852 8.21245H8.38164V10.9968H5.42852V8.21245ZM8.38164 12.2625V15.0187H5.42852V12.2625H8.38164V12.2625ZM9.64727 12.2625H12.6004V15.0187H9.64727V12.2625ZM9.64727 10.9968V8.21245H12.6004V10.9968H9.64727ZM13.8379 8.21245H16.2285V10.9968H13.8379V8.21245ZM2.25039 4.24683H3.71289V4.83745C3.71289 5.17495 3.99414 5.48433 4.35977 5.48433C4.72539 5.48433 5.00664 5.20308 5.00664 4.83745V4.24683H13.0504V4.83745C13.0504 5.17495 13.3316 5.48433 13.6973 5.48433C14.0629 5.48433 14.3441 5.20308 14.3441 4.83745V4.24683H15.7504C16.0316 4.24683 16.2566 4.47183 16.2566 4.75308V6.94683H1.77227V4.75308C1.77227 4.47183 1.96914 4.24683 2.25039 4.24683ZM1.77227 14.5125V12.2343H4.16289V14.9906H2.25039C1.96914 15.0187 1.77227 14.7937 1.77227 14.5125ZM15.7504 15.0187H13.8379V12.2625H16.2285V14.5406C16.2566 14.7937 16.0316 15.0187 15.7504 15.0187Z" fill="#64748B" />
                                        </svg>
                                    </div>
                                </div>
                                @error('endDate')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="w-full">
                            <label class="mb-3 block text-sm font-medium text-black" for="fullName">Price&nbsp;<em>(SGD$)</em></label>
                            <div class="relative">
                                <span class="absolute left-4.5 top-3.5 flex text-slate-500">SGD</span>
                                <input 
                                    wire:model="price"
                                    class="w-full rounded text-lg border border-stroke bg-gray/60 py-3 pl-16 font-medium placeholder:text-slate-500 text-black focus:ring-0" 
                                    type="number"
                                    step="0.01" 
                                    id="price" 
                                    placeholder="0.00" 
                                 />
                            </div>
                            @error('price')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <label class="mb-3 block text-sm font-medium text-black" for="fullName">Order&nbsp;<em>(Ordering in the display)</em></label>
                            <input 
                                wire:model="arrangement"
                                class="w-full rounded text-lg border border-stroke py-3 font-medium placeholder:text-slate-500 text-black focus:ring-0" 
                                type="number"
                                step="1" 
                                id="arrangement" 
                                placeholder="Ex: 4" 
                                />
                            @error('arrangement')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div x-data="{ isActive: @entangle('isActive') }" class="flex">
                            <label for="toggle4" class="flex cursor-pointer select-none items-center">
                                <div class="relative">
                                    <input 
                                        wire:model="isActive"
                                        type="checkbox" id="toggle4" class="sr-only" />
                                    <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                    <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                </div>
                            </label>
                        </div>
                        <div class="flex flex-col text-lg">
                            <p>Total Promotion Usage: {{ $promotion->counter }}</p>
                            <p>Created By <span class="italic text-slate-600">{{ $promotion->createdBy }}</span></p>
                        </div>
                        <div class="h-screen flex justify-between items-end gap-2 mb-18">
                            <button 
                                wire:target="save"
                                wire:loading.attr="disabled"
                                type="submit" 
                                class="disabled:cursor-not-allowed disabled:opacity-50 w-full flex justify-center p-4 items-center rounded-md text-md text-white drop-shadow uppercase bg-green-700 hover:bg-green-600 duration-300">
                                
                                <span wire:loading.remove wire:target="save">
                                    Update
                                </span>
                                <span wire:loading wire:target="save">
                                    Updating...
                                </span>

                            </button>
                            <button type="button" wire:click="closeModal" class="w-full flex justify-center p-4 items-center rounded-md text-md text-white drop-shadow uppercase bg-slate-600 hover:bg-slate-500 duration-300">
                                Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
