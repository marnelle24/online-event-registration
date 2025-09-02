<div class="relative">
    <!-- Trigger button -->
    <button 
        wire:click="openModal" 
        type="button" 
        class="tracking-widest font-thin uppercase inline-flex items-center bg-green-600 hover:scale-105 hover:bg-green-500 duration-300 justify-center rounded-md border border-green-600 py-2 px-3 text-center text-white drop-shadow text-xs"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Breakout Session
    </button>

    <!-- Backdrop and Slide-over Modal -->
    @if ($show)
        <div x-data="{ modalOpen: @entangle('show') }"
             x-show="modalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-hidden"
             @keydown.escape="$wire.closeModal()">
            
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity"
                 wire:click="closeModal"></div>
                 
            <!-- Slide Panel -->
            <div x-show="modalOpen"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="absolute right-0 top-0 h-full w-full max-w-lg bg-white shadow-xl">
                
            <div class="flex h-full flex-col">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-400">
                    <h2 class="text-white text-2xl uppercase font-light">Add Breakout Session</h2>
                    <button wire:click="closeModal" 
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
                    
                    <form wire:submit.prevent="save" class="space-y-6">
                        <div class="space-y-4 flex flex-col gap-4">
                            <div>
                                <label for="session_title" class="block text-sm font-medium text-slate-700 mb-2">
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                        id="session_title"
                                        wire:model="session_title"
                                        class="w-full rounded-none focus:ring-0 focus:border-slate-500 border-slate-500 shadow-sm"
                                        placeholder="Session title">
                            </div>
                            <div>
                                <label for="session_description" class="block text-sm font-medium text-slate-700 mb-2">
                                    Description
                                </label>
                                <textarea id="session_description"
                                            wire:model="session_description"
                                            rows="4"
                                            class="w-full rounded-none focus:ring-0 focus:border-slate-500 border-slate-500 shadow-sm"
                                            placeholder="Description"></textarea>
                            </div>
                            <div>
                                <label for="date_time" class="block text-sm font-medium text-slate-700 mb-2">Date & Time</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <x-input type="datetime-local" wire:model="start_datetime" class="rounded-none focus:ring-0 focus:border-slate-500 border-slate-500 shadow-sm" />
                                    <x-input type="datetime-local" wire:model="end_datetime" class="rounded-none focus:ring-0 focus:border-slate-500 border-slate-500 shadow-sm" />
                                </div>
                            </div>
                            <div class="flex lg:flex-row flex-col gap-4">
                                <div class="lg:w-1/3 w-full">
                                    <label for="price" class="block text-sm font-medium text-slate-700 mb-2">
                                        Price (SGD)
                                    </label>
                                    <input type="number" 
                                            id="price" 
                                            step="0.10"
                                            wire:model="price"
                                            class="w-full border-slate-500 shadow-sm rounded-none focus:ring-0 focus:border-slate-500"
                                            placeholder="Price">
                                </div>
                                <div class="lg:w-2/3 w-full">
                                    <label for="location" class="block text-sm font-medium text-slate-700 mb-2">
                                        Location/Room
                                    </label>
                                    <input type="text" 
                                            id="location"
                                            wire:model="location"
                                            class="w-full border-slate-500 shadow-sm rounded-none focus:ring-0 focus:border-slate-500"
                                            placeholder="Location or room number">
                                </div>
                            </div>

                            <div class="flex lg:flex-row flex-col gap-4">
                                <div class="lg:w-3/4 w-full">
                                    <label for="speaker" class="block text-sm font-medium text-slate-700 mb-2">
                                        Speaker
                                    </label>
                                    <select wire:model="speaker" class="w-full rounded-none focus:ring-0 focus:border-slate-500 border-slate-500 shadow-sm">
                                        <option value="">Select Speaker</option>
                                        @foreach ($allSpeakers as $speaker)
                                            <option value="{{ $speaker->id }}">{{ $speaker->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="lg:w-1/4 w-full">
                                    <label for="order" class="block text-sm font-medium text-slate-700 mb-2">
                                        Order
                                    </label>
                                    <input type="number" 
                                            id="order" 
                                            step="1"
                                            wire:model="order"
                                            class="w-full border-slate-500 shadow-sm rounded-none focus:ring-0 focus:border-slate-500"
                                            placeholder="Order">
                                </div>
                            </div>
                        </div>
                        <!-- Action buttons -->
                        <div class="flex justify-between space-x-3 pt-6">
                            <button type="button" 
                                    wire:click="closeModal"
                                    class="w-full py-3 text-md font-medium text-slate-700 bg-white hover:scale-105 duration-300 border border-slate-500 rounded-none shadow-sm hover:bg-slate-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="w-full py-3 text-md font-medium text-white bg-green-600 border border-transparent hover:scale-105 rounded-none shadow-sm hover:bg-green-700 duration-300">
                                <span wire:loading.remove>Save Session</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
