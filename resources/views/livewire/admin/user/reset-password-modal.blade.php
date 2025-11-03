<div class="relative">
    <!-- Backdrop and Modal -->
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
             
        <!-- Modal -->
        <div 
            x-show="show"
            x-transition:enter="transform transition ease-in-out duration-500"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute inset-0 flex items-center justify-center p-4"
        >
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-400 rounded-t-lg">
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Reset Password</h2>
                    <button 
                        wire:click="closeModal"
                        class="text-slate-600 hover:text-slate-900 text-xl p-2 rounded-full hover:bg-slate-300/50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-white hover:stroke-slate-200 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6">
                    @if($loading)
                        <!-- Loading State -->
                        <div class="flex flex-col items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                            <p class="text-slate-600 text-lg font-medium">Loading user data...</p>
                        </div>
                    @else
                    <x-validation-errors :class="'mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md'" />
                    
                    @if (session()->has('message'))
                        <div class="mb-4 text-green-700 bg-green-300/40 border border-green-600/20 rounded-md p-3 text-sm">
                            {{ session('message') }}
                        </div> 
                    @endif
                    
                    <form wire:submit.prevent="resetPassword" class="flex flex-col gap-4">
                        <div>
                            <p class="text-sm text-slate-600 mb-2">
                                Reset password for: <span class="font-semibold">{{ $user->name ?? '' }}</span> ({{ $user->email ?? '' }})
                            </p>
                        </div>
                        
                        <div class="space-y-4 flex flex-col">
                            <!-- Password -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">New Password<span class="text-red-500 px-1">*</span></label>
                                <div class="flex gap-2">
                                    <input 
                                        wire:model="password"
                                        type="text" 
                                        placeholder="Enter new password" 
                                        class="flex-1 focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                    />
                                    <button 
                                        type="button"
                                        wire:click="generatePassword"
                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm font-medium transition duration-300 whitespace-nowrap">
                                        Generate
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label class="mb-1 block text-sm font-medium text-black">Confirm Password<span class="text-red-500 px-1">*</span></label>
                                <input 
                                    wire:model="password_confirmation"
                                    type="text" 
                                    placeholder="Confirm new password" 
                                    class="focus:ring-0 placeholder:text-slate-400/60 w-full rounded p-2 border-slate-300 bg-transparent px-2 py-2 font-normal text-black outline-none transition focus:border-primary active:border-primary" 
                                />
                                @error('password_confirmation')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Send Email Checkbox -->
                            <div class="flex items-center gap-2">
                                <input 
                                    wire:model="sendEmail"
                                    type="checkbox" 
                                    id="sendEmail" 
                                    class="rounded border-slate-300"
                                />
                                <label for="sendEmail" class="text-sm text-slate-700 cursor-pointer">
                                    Send password reset email to user
                                </label>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center gap-4 pt-4">
                                <button 
                                    wire:target="resetPassword"
                                    wire:loading.attr="disabled"
                                    type="submit" 
                                    class="disabled:cursor-not-allowed disabled:opacity-50 w-full flex justify-center p-4 items-center rounded-md text-md text-white drop-shadow uppercase bg-green-700 hover:bg-green-600 duration-300">
                                    <span wire:loading.remove wire:target="resetPassword">
                                        Reset Password
                                    </span>
                                    <span wire:loading wire:target="resetPassword">
                                        Resetting...
                                    </span>
                                </button>
                                <button 
                                    type="button"
                                    wire:click="closeModal" 
                                    class="bg-slate-500 hover:bg-slate-600 duration-300 text-white p-4 rounded-md">Cancel</button>
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

