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
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Edit User</h2>
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
                            <p class="text-slate-600 text-lg font-medium">Loading user data...</p>
                            <p class="text-slate-400 text-sm mt-2">Please wait while we fetch the user information</p>
                        </div>
                    @else
                    <x-validation-errors :class="'mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md'" />
                    
                    @if (session()->has('message'))
                        <div class="mb-4 text-green-700 bg-green-300/40 border border-green-600/20 rounded-md p-3 text-sm">
                            {{ session('message') }}
                        </div> 
                    @endif
                    
                    <form wire:submit.prevent="update" class="flex flex-col gap-4">
                        <div>
                            <p class="italic text-md text-slate-500">
                                Update user information. 
                                Changes will be reflected immediately.
                            </p>
                        </div>
                        
                        <div class="space-y-4 flex flex-col">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- First Name -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black">First Name</label>
                                    <input 
                                        wire:model="firstname"
                                        type="text" 
                                        placeholder="John" 
                                        class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('firstname')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
    
                                <!-- Last Name -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black">Last Name</label>
                                    <input 
                                        wire:model="lastname"
                                        type="text" 
                                        placeholder="Doe" 
                                        class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('lastname')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Name -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black">Nice Name<span class="text-slate-500 px-1 italic">(Optional)</span></label>
                                    <input 
                                        wire:model="name"
                                        type="text" 
                                        placeholder="e.g. Johnny Doe" 
                                        class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
    
                                <!-- Email -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black">Email<span class="text-red-500 px-1">*</span></label>
                                    <input 
                                        wire:model="email"
                                        type="email" 
                                        placeholder="user@example.com" 
                                        class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('email')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if($password)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Password (optional) -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black">Password <span class="text-slate-500 text-xs">(Leave blank to keep current password)</span></label>
                                    <input 
                                        wire:model="password"
                                        type="password" 
                                        placeholder="Enter new password (optional)" 
                                        class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('password')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
    
                                <!-- Password Confirmation -->
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black">Confirm Password<span class="text-red-500 px-1">*</span></label>
                                    <input 
                                        wire:model="password_confirmation"
                                        type="password" 
                                        placeholder="Confirm new password" 
                                        class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    @error('password_confirmation')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @else
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Password <span class="text-slate-500 text-xs">(Leave blank to keep current password)</span></label>
                                <input 
                                    wire:model="password"
                                    type="password" 
                                    placeholder="Enter new password (optional)" 
                                    class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Role -->
                                @php
                                    $isOwnAccount = $user && auth()->id() === $user->id;
                                @endphp
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-black">Role<span class="text-red-500 px-1">*</span></label>
                                    <select wire:model="role" class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary">
                                        <option value="user" @if($isOwnAccount && $user->role == 'admin') disabled @endif>User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    @error('role')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Status Toggle -->
                                {{-- <div class="flex flex-col gap-1">
                                    <p class="text-sm font-medium text-black mr-1">Status</p>
                                    <label for="editUserStatus{{ $user->id ?? '' }}" class="flex items-center" x-data="{ showToolTip: false }"
                                        @mouseover="showToolTip = true" 
                                        @mouseleave="showToolTip = false"
                                        class="relative">
                                        <div class="relative" x-data="{ is_active: @entangle('is_active') }">
                                            <input 
                                                wire:model="is_active"
                                                type="checkbox" 
                                                id="editUserStatus{{ $user->id ?? '' }}" 
                                                class="sr-only" 
                                                @if($isOwnAccount) disabled @endif
                                            />
                                            <div :class="is_active && '!bg-success'" 
                                                 class="{{ $isOwnAccount ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }} block h-8 w-14 rounded-full bg-black"></div>
                                            <div :class="is_active && '!right-1 !translate-x-full'" 
                                                 class="{{ $isOwnAccount ? 'cursor-not-allowed' : 'cursor-pointer' }} absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"></div>
                                            @if($isOwnAccount)
                                                <div x-show="showToolTip" x-transition class="absolute left-0 top-10 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 rounded px-2 py-1 shadow-lg z-50">
                                                    <p class="text-left text-xs text-white">Cannot change your own status</p>
                                                </div>
                                            @endif
                                        </div>
                                    </label>
                                </div> --}}
                            </div>

                            <!-- Ministries -->
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-medium text-black">Ministries</p>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input
                                        wire:model.live.debounce.300ms="ministrySearch"
                                        type="search"
                                        placeholder="Search ministries..."
                                        class="w-full pl-10 py-2 border border-slate-300 rounded-md focus:ring-0 focus:ring-slate-500 focus:border-slate-500 bg-white text-slate-900 placeholder-slate-400 text-sm"
                                    />
                                </div>
                                <div class="border border-slate-300 rounded-md p-2 max-h-60 overflow-y-auto">
                                    @if($allMinistries->count() > 0)
                                        @foreach($allMinistries as $ministry)
                                            <label class="flex items-center gap-2 py-1 hover:bg-slate-50 rounded px-1 cursor-pointer">
                                                <input 
                                                    type="checkbox"
                                                    wire:model="ministries"
                                                    value="{{ $ministry->id }}"
                                                    class="rounded border-slate-300"
                                                />
                                                <span class="text-sm text-slate-700">{{ $ministry->name }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-slate-400 text-center py-2">No ministries found</p>
                                    @endif
                                </div>
                                @error('ministries')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center gap-4 pt-4">
                                <button 
                                    wire:target="update"
                                    wire:loading.attr="disabled"
                                    type="submit" 
                                    class="disabled:cursor-not-allowed disabled:opacity-50 w-full flex justify-center p-4 items-center rounded-md text-md text-white drop-shadow uppercase bg-green-700 hover:bg-green-600 duration-300">
                                    <span wire:loading.remove wire:target="update">
                                        Update
                                    </span>
                                    <span wire:loading wire:target="update">
                                        Updating...
                                    </span>
                                </button>
                                <button 
                                    type="button"
                                    wire:click="closeModal" 
                                    class="bg-slate-500 hover:bg-slate-600 duration-300 text-white p-4 rounded-md">Close</button>
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

