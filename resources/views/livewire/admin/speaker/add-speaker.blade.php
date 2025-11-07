<div class="relative" x-data="{ show: false }" @close-modal.window="show = false">
    <button 
        @click="show = true" 
        class="flex items-center gap-2 shadow border border-blue-600/30 bg-slate-600 drop-shadow text-slate-200 hover:bg-slate-700 rounded-full hover:-translate-y-0.5 duration-300 py-2 px-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        New Speaker
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
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Add Speaker</h2>
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
                                Create a new speaker profile. 
                                This speaker can be assigned to multiple programmes and events.
                            </p>
                        </div>
                        
                        <div class="space-y-4 flex flex-col gap-4">
                            <!-- Title and Name -->
                            <div class="flex justify-between items-center gap-4">
                                <div class="w-1/3">
                                    <label class="mb-1 block text-sm font-medium text-black">Title<span class="text-red-500 px-1">*</span></label>
                                    <select 
                                        wire:model="title"
                                        class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"
                                    >
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Dr">Dr</option>
                                        <option value="Prof">Prof</option>
                                        <option value="Rev">Rev</option>
                                        <option value="Pastor">Pastor</option>
                                    </select>
                                    @error('title')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-2/3">
                                    <label class="mb-1 block text-sm font-medium text-black">Name<span class="text-red-500 px-1">*</span></label>
                                    <input 
                                        wire:model="name"
                                        type="text" 
                                        placeholder="Full Name" 
                                        class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Profession -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Profession<span class="text-red-500 px-1">*</span></label>
                                <input 
                                    wire:model="profession"
                                    type="text" 
                                    placeholder="e.g. Senior Pastor, IT Professional, etc." 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('profession')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Email</label>
                                <input 
                                    wire:model="email"
                                    type="email" 
                                    placeholder="email@example.com" 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('email')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- About -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">About</label>
                                <textarea 
                                    wire:model="about"
                                    rows="4"
                                    placeholder="Brief description about the speaker..." 
                                    class="focus:ring-0 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"
                                ></textarea>
                                @error('about')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Social Media -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Social Media</label>
                                @foreach($socials as $index => $social)
                                    <div class="flex gap-2 mb-2">
                                        <select 
                                            wire:model="socials.{{ $index }}.platform"
                                            class="focus:ring-0 w-1/3 rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary"
                                        >
                                            <option value="">Platform</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Instagram">Instagram</option>
                                            <option value="Twitter">Twitter</option>
                                            <option value="LinkedIn">LinkedIn</option>
                                            <option value="YouTube">YouTube</option>
                                            <option value="Website">Website</option>
                                        </select>
                                        <input 
                                            wire:model="socials.{{ $index }}.url"
                                            type="url" 
                                            placeholder="https://..." 
                                            class="focus:ring-0 w-2/3 rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                        />
                                        @if($index > 0)
                                            <button 
                                                type="button"
                                                wire:click="removeSocMedAccount({{ $index }})"
                                                class="text-red-500 hover:text-red-700 p-2"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                                <button 
                                    type="button"
                                    wire:click="addSocMedAccount"
                                    class="text-blue-500 hover:text-blue-700 text-sm"
                                >
                                    + Add Social Media Account
                                </button>
                            </div>

                            <!-- Status Toggle -->
                            <div x-data="{ isActive: @entangle('is_active') }" class="flex">
                                <label for="newSpeakerStatus" class="flex cursor-pointer select-none items-center">
                                    <span class="text-sm font-medium text-black mr-1">Status</span>
                                    <div class="relative">
                                        <input 
                                            wire:model="is_active"
                                            type="checkbox" id="newSpeakerStatus" class="sr-only" />
                                        <div :class="isActive && '!bg-success'" class="block h-8 w-14 rounded-full bg-black"></div>
                                        <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                    </div>
                                </label>
                            </div>

                            <!-- Thumbnail Upload -->
                            <div class="flex flex-col gap-2 border border-slate-300 rounded-md p-2">
                                <label class="mb-1 block text-sm font-medium text-black">Profile Picture</label>
                                <input 
                                    wire:model="thumbnail"
                                    type="file" 
                                    accept="image/*"
                                    class="focus:ring-0 w-full rounded border-slate-300 bg-transparent font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('thumbnail')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
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