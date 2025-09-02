<div class="relative">
    <button 
        x-data="{ showToolTip: false }"
        wire:click="openModal"
        @mouseover="showToolTip = true" 
        @mouseleave="showToolTip = false"
        class="flex items-center"
    >
        <svg 
            class="w-5 h-5 stroke-blue-500 hover:scale-110 duration-300 hover:stroke-blue-600"
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
    @if ($show)
        <div class="fixed inset-0 z-50">
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
            </div>
            <div class="p-4 h-screen">
                <x-validation-errors :class="'p-5'" />
                
                <div class="flex flex-col gap-4 p-5 h-screen overflow-auto">
                    @dump($breakout->title)
                </div>

            </div>
        </div>
    @endif
</div>