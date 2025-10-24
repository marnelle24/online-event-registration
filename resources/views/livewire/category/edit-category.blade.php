<div class="relative">
    <!-- Backdrop and Slide-over Modal -->
    @if($show)
    <div 
        x-data="{ show: @entangle('show') }"
        x-show="show" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-hidden"
        @keydown.escape="show = false">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity"
             wire:click="closeModal"></div>
             
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
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Edit Category</h2>
                    <button 
                        wire:click="closeModal"
                        class="text-slate-600 hover:text-slate-900 text-xl p-2 rounded-full hover:bg-slate-300/50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-white hover:stroke-slate-200 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    @if($loading)
                        <!-- Loading State -->
                        <div class="flex flex-col items-center justify-center h-full py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                            <p class="text-slate-600 text-lg font-medium">Loading category data...</p>
                            <p class="text-slate-400 text-sm mt-2">Please wait while we fetch the category information</p>
                        </div>
                    @else
                    <x-validation-errors :class="'mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md'" />
                    
                    @if (session()->has('message'))
                        <div class="mb-4 text-green-700 bg-green-300/40 border border-green-600/20 rounded-md p-3 text-sm">
                            {{ session('message') }}
                        </div> 
                    @endif
                    
                    <form wire:submit.prevent="save" class="flex flex-col gap-4">
                        <div>
                            <p class="italic text-md text-slate-500">
                                Update category information. 
                                Changes will be reflected across all programmes where this category is assigned.
                            </p>
                        </div>
                        
                        <div class="space-y-4 flex flex-col gap-4">
                            <!-- Name -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Category Name<span class="text-red-500 px-1">*</span></label>
                                <input 
                                    wire:model="name"
                                    type="text" 
                                    placeholder="e.g. Technology, Business, Education, etc." 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Current Slug -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Current Slug</label>
                                <input 
                                    type="text" 
                                    value="{{ $category->slug ?? '' }}"
                                    readonly
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-slate-100 px-2 py-2 font-normal text-slate-500 outline-none transition" 
                                />
                                <p class="text-xs text-slate-500 mt-1">Slug will be automatically updated when you change the name</p>
                            </div>

                            <!-- Programmes Count -->
                            @if($category && $category->programmes->count() > 0)
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Associated Programmes</label>
                                <div class="p-3 bg-blue-50 border border-blue-200 rounded-md">
                                    <p class="text-sm text-blue-800">
                                        This category is currently assigned to <strong>{{ $category->programmes->count() }}</strong> programme(s).
                                    </p>
                                </div>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center gap-4">
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
                                <button 
                                    type="button"
                                    wire:click="resetForm" 
                                    class="bg-slate-500 hover:bg-slate-600 duration-300 text-white p-4 rounded-md">Reset</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
