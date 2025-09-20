<div class="relative z-50" x-data="{ show: false }">
    <!-- Trigger button -->
    <button 
        @click="show = true" 
        type="button" 
        class="tracking-widest font-thin uppercase inline-flex items-center bg-teal-600 hover:scale-105 hover:bg-teal-700 duration-300 justify-center rounded-md border border-teal-600 py-2 px-3 text-center text-white drop-shadow text-sm"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Add
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
        class="fixed inset-0 z-40"
        x-cloak
    >
        <!-- Backdrop -->
        <div 
            class="absolute inset-0 bg-black/50"
            @click="show = false"
        ></div>

        <!-- Slide-over Modal -->
        <div 
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute inset-y-0 right-0 lg:w-1/4 w-full bg-white shadow-xl z-50 overflow-auto"
        >
            <!-- Header -->
            <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-600">
                <h2 class="text-white text-xl uppercase font-light">Assign Speaker</h2>
                <button 
                    @click="show = false" 
                    class="text-gray-600 hover:text-gray-900 text-xl"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-white hover:stroke-slate-100 hover:scale-110 duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-4">
                @livewire('speaker.speaker-drop-down-list-select', ['programmeId' => $programmeId])
            </div>
            <p class="p-4 text-center">
                If you don't find the speaker you want, you can <a wire:navigate href="#" class="text-blue-600 hover:text-blue-700 duration-300">Add New Speaker</a>
            </p>

            {{-- <div class="p-4">
                <hr class="border border-slate-300 mt-5" />
                <p class="text-xl text-slate-500 mb-1">Or, add new Speaker or Trainer</p>
            </div>

            <div class="p-4">
                @livewire('speaker.speaker-form-data')
            </div> --}}
        </div>
    </div>
</div>
