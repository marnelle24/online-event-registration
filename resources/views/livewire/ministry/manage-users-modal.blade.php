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
            <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
                <!-- Header -->
                <div class="flex justify-between items-center p-4 border-b-2 border-slate-500/60 bg-slate-400">
                    <h2 class="text-white text-xl tracking-wider uppercase font-light">Manage Ministry Users</h2>
                    <button 
                        wire:click="closeModal"
                        class="text-slate-600 hover:text-slate-900 text-xl p-2 rounded-full hover:bg-slate-300/50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-white hover:stroke-slate-200 duration-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                    @if($loading)
                        <!-- Loading State -->
                        <div class="flex flex-col items-center justify-center h-full py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                            <p class="text-slate-600 text-lg font-medium">Loading ministry data...</p>
                            <p class="text-slate-400 text-sm mt-2">Please wait while we fetch the ministry information</p>
                        </div>
                    @else
                        @if($ministry)
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-slate-800 mb-2">{{ $ministry->name }}</h3>
                                <p class="text-sm text-slate-600">Manage users assigned to this ministry</p>
                                <p class="text-sm text-slate-700">
                                    Add a user to the ministry by searching for their name and clicking the "Add" button.
                                </p>
                            </div>
                            <div class="flex flex-col relative">
                                <input 
                                    wire:model.live.debounce.500ms="search"
                                    placeholder="Search user"
                                    type="search" 
                                    class="w-full rounded-md py-3 px-2 font-medium outline-none ring-0 border border-slate-600 hover:border-slate-700 focus:outline-none focus:ring-1 transition disabled:cursor-default"
                                />
                                @if(!empty($search))
                                    <div class="border border-slate-400/20 rounded-b-lg shadow-md absolute z-20 top-12 left-0 w-full bg-white">
                                        <ul class="list-none list-inside">
                                            @if($users->isEmpty())
                                                <li class="p-4">
                                                    <div class="flex justify-between items-center gap-2">
                                                        <span class="text-slate-700">No users found</span>
                                                    </div>
                                                </li>
                                            @else
                                                @foreach ($users as $user)
                                                <li class="p-4 hover:bg-slate-100 transition-all duration-300">
                                                    <div class="flex justify-between items-center gap-2">
                                                        <span class="text-slate-700">{{ $user->name }}</span>
                                                        <svg wire:click="addUserToMinistry({{$user->id}})" wire:confirm="Are you sure to add this user?" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-green-600 font-extrabold cursor-pointer hover:-translate-y-1 transition-all duration-300">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                        </svg>
                                                    </div>
                                                </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <p class="text-md text-slate-700 mt-6 font-medium">
                                Current User(s)
                            </p>
                            @if($ministry->users->count() > 0)
                                <ul class="list-none list-inside mt-2">
                                    @foreach ($ministry->users as $user)
                                        <li class="my-2 flex justify-between items-center gap-2 bg-zinc-100 border border-slate-400/50 px-4 py-2 rounded-md hover:-translate-y-0.5 transition-all duration-300">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-green-600">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                </svg>
                                                    <span class="text-slate-700">
                                                    {{ $user->name }}
                                                </span>
                                            </div>
                                            <div class="flex items-center cursor-pointer hover:-translate-y-0.5 transition-all duration-300">
                                                <svg 
                                                    wire:click="detachUserFromMinistry({{$user->id}})" wire:confirm="Are you sure you want to remove this user?" 
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-md text-slate-400 mt-2">
                                    No users assigned to this ministry yet.
                                </p>
                            @endif
                        @else
                            <div class="flex flex-col items-center justify-center h-full py-12">
                                <p class="text-slate-600 text-lg font-medium">Ministry not found</p>
                                <p class="text-slate-400 text-sm mt-2">The ministry you're looking for doesn't exist</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
