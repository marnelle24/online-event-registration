<div class="relative z-50">
    <!-- Trigger button -->
    <button 
        wire:click="openModal" 
        type="button" 
        class="tracking-widest font-thin uppercase inline-flex items-center bg-teal-600 hover:scale-105 hover:bg-teal-500 duration-300 justify-center rounded-md border border-teal-600 py-2 px-3 text-center text-white drop-shadow text-sm"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Speaker
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
                    <h2 class="text-white text-2xl uppercase font-light">Assign Speaker</h2>
                    <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900 text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 stroke-slate-800 hover:stroke-slate-500 hover:-translate-y-1 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    @livewire('speaker.speaker-drop-down-list-select', ['programmeId' => $programmeId])
                </div>

                <div class="p-4">
                    <hr class="border border-slate-300 mt-5" />
                    <p class="text-xl text-slate-500 mb-1">Or, add new Speaker or Trainer</p>
                </div>

                <div class="p-4">
                    @livewire('speaker.speaker-form-data')
                </div>
            </div>
        </div>
    @endif
</div>
