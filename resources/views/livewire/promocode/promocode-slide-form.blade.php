<div class="relative">
    <!-- Trigger button -->
    <button 
        wire:click="openModal" 
        type="button" 
        class="tracking-widest font-thin uppercase inline-flex items-center bg-orange-400 hover:scale-105 hover:bg-orange-300 duration-300 justify-center rounded-md border border-orange-300 py-2 px-3 text-center text-white drop-shadow text-xs"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Promo Codes
    </button>

    @if ($show)
        <div class="fixed inset-0 z-40">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/50"
                wire:click="closeModal">
            </div>
            <div class="absolute inset-y-0 right-0 lg:w-1/4 w-full bg-white shadow-lg z-50 transform transition-transform duration-300 overflow-auto" style="transform: translateX(0%)">
               
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-400">
                    <h2 class="text-white text-2xl uppercase font-light">Add Promo Code</h2>
                    <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900 text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-slate-800 hover:stroke-slate-500 hover:-translate-y-1 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 h-screen">
                    <x-validation-errors :class="'p-5'" />
                    <form wire:submit.prevent="save" class="flex flex-col gap-4 p-5 h-screen">
                        <div>
                            <p class="italic text-md text-slate-500">
                                Create a new promo code for this programme.
                                Newly created promo code will immediately applicable to the programme as long as
                                it is active and within the date range validity.
                            </p>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-black">Promo Code</label>
                            <input 
                                wire:model="form.promocode"
                                type="text" placeholder="Name" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" />
                            @error('form.promocode')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-black">Remarks</label>
                            <textarea 
                                wire:model="form.remarks"
                                rows="3"
                                placeholder="Remarks" class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"></textarea>
                            @error('form.remarks')
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
                                        wire:model="form.startDate"
                                        type="datetime-local"
                                        class="w-full rounded border border-stroke bg-transparent py-3 font-normal outline-none transition focus:border-slate-500 active:border-slate-500 focus:ring-0" placeholder="mm/dd/yyyy" 
                                    />
                                    <div class="pointer-events-none absolute inset-0 left-auto right-3 flex items-center">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" class="bg-white">
                                            <path d="M15.7504 2.9812H14.2879V2.36245C14.2879 2.02495 14.0066 1.71558 13.641 1.71558C13.2754 1.71558 12.9941 1.99683 12.9941 2.36245V2.9812H4.97852V2.36245C4.97852 2.02495 4.69727 1.71558 4.33164 1.71558C3.96602 1.71558 3.68477 1.99683 3.68477 2.36245V2.9812H2.25039C1.29414 2.9812 0.478516 3.7687 0.478516 4.75308V14.5406C0.478516 15.4968 1.26602 16.3125 2.25039 16.3125H15.7504C16.7066 16.3125 17.5223 15.525 17.5223 14.5406V4.72495C17.5223 3.7687 16.7066 2.9812 15.7504 2.9812ZM1.77227 8.21245H4.16289V10.9968H1.77227V8.21245ZM5.42852 8.21245H8.38164V10.9968H5.42852V8.21245ZM8.38164 12.2625V15.0187H5.42852V12.2625H8.38164V12.2625ZM9.64727 12.2625H12.6004V15.0187H9.64727V12.2625ZM9.64727 10.9968V8.21245H12.6004V10.9968H9.64727ZM13.8379 8.21245H16.2285V10.9968H13.8379V8.21245ZM2.25039 4.24683H3.71289V4.83745C3.71289 5.17495 3.99414 5.48433 4.35977 5.48433C4.72539 5.48433 5.00664 5.20308 5.00664 4.83745V4.24683H13.0504V4.83745C13.0504 5.17495 13.3316 5.48433 13.6973 5.48433C14.0629 5.48433 14.3441 5.20308 14.3441 4.83745V4.24683H15.7504C16.0316 4.24683 16.2566 4.47183 16.2566 4.75308V6.94683H1.77227V4.75308C1.77227 4.47183 1.96914 4.24683 2.25039 4.24683ZM1.77227 14.5125V12.2343H4.16289V14.9906H2.25039C1.96914 15.0187 1.77227 14.7937 1.77227 14.5125ZM15.7504 15.0187H13.8379V12.2625H16.2285V14.5406C16.2566 14.7937 16.0316 15.0187 15.7504 15.0187Z" fill="#64748B" />
                                        </svg>
                                    </div>
                                </div>
                                @error('form.startDate')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">
                                    End Date
                                </label>
                                <div class="relative">
                                    <input 
                                        wire:model="form.endDate"
                                        type="datetime-local"
                                        class="w-full rounded border border-stroke bg-transparent py-3 font-normal outline-none transition focus:border-slate-500 active:border-slate-500 focus:ring-0" placeholder="mm/dd/yyyy" 
                                    />
                                    <div class="pointer-events-none absolute inset-0 left-auto right-3 flex items-center">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" class="bg-white">
                                            <path d="M15.7504 2.9812H14.2879V2.36245C14.2879 2.02495 14.0066 1.71558 13.641 1.71558C13.2754 1.71558 12.9941 1.99683 12.9941 2.36245V2.9812H4.97852V2.36245C4.97852 2.02495 4.69727 1.71558 4.33164 1.71558C3.96602 1.71558 3.68477 1.99683 3.68477 2.36245V2.9812H2.25039C1.29414 2.9812 0.478516 3.7687 0.478516 4.75308V14.5406C0.478516 15.4968 1.26602 16.3125 2.25039 16.3125H15.7504C16.7066 16.3125 17.5223 15.525 17.5223 14.5406V4.72495C17.5223 3.7687 16.7066 2.9812 15.7504 2.9812ZM1.77227 8.21245H4.16289V10.9968H1.77227V8.21245ZM5.42852 8.21245H8.38164V10.9968H5.42852V8.21245ZM8.38164 12.2625V15.0187H5.42852V12.2625H8.38164V12.2625ZM9.64727 12.2625H12.6004V15.0187H9.64727V12.2625ZM9.64727 10.9968V8.21245H12.6004V10.9968H9.64727ZM13.8379 8.21245H16.2285V10.9968H13.8379V8.21245ZM2.25039 4.24683H3.71289V4.83745C3.71289 5.17495 3.99414 5.48433 4.35977 5.48433C4.72539 5.48433 5.00664 5.20308 5.00664 4.83745V4.24683H13.0504V4.83745C13.0504 5.17495 13.3316 5.48433 13.6973 5.48433C14.0629 5.48433 14.3441 5.20308 14.3441 4.83745V4.24683H15.7504C16.0316 4.24683 16.2566 4.47183 16.2566 4.75308V6.94683H1.77227V4.75308C1.77227 4.47183 1.96914 4.24683 2.25039 4.24683ZM1.77227 14.5125V12.2343H4.16289V14.9906H2.25039C1.96914 15.0187 1.77227 14.7937 1.77227 14.5125ZM15.7504 15.0187H13.8379V12.2625H16.2285V14.5406C16.2566 14.7937 16.0316 15.0187 15.7504 15.0187Z" fill="#64748B" />
                                        </svg>
                                    </div>
                                </div>
                                @error('form.endDate')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="mb-3 block text-sm font-medium text-black" for="fullName">Price</label>
                            <div class="relative">
                                <span class="absolute left-4.5 top-3.5 flex text-slate-500">SGD</span>
                                <input 
                                    wire:model="form.price"
                                    class="w-full rounded text-lg border border-stroke bg-gray/60 py-3 pl-16 font-medium placeholder:text-slate-500 text-black focus:ring-0" 
                                    type="number"
                                    step="0.10" 
                                    id="price" 
                                    placeholder="0.00" 
                                />
                            </div>
                            @error('form.price')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div x-data="{ isActive: @entangle('form.isActive') }" class="flex">
                            <label for="toggle4" class="flex cursor-pointer select-none items-center">
                                <div class="relative">
                                    <input 
                                        wire:model="form.isActive"
                                        type="checkbox" id="toggle4" class="sr-only" />
                                    <div :class="isActive && '!bg-primary'" class="block h-8 w-14 rounded-full bg-black"></div>
                                    <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                </div>
                            </label>
                        </div>
                        <div class="h-screen flex justify-between items-end gap-2 mb-18">
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
                            <button type="reset" class="w-full flex justify-center p-4 items-center rounded-md text-md text-white drop-shadow uppercase bg-slate-600 hover:bg-slate-500 duration-300">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>