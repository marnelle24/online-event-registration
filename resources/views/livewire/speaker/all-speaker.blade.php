<div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <!-- Header with Title and Add Button -->
        <div class="w-full flex justify-between items-center border-b border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
            <p class="text-md text-slate-500 uppercase tracking-wider font-thin">
                Manage Speakers & Professionals
            </p>
            @livewire('speaker.add-speaker', key('add-new-speaker'))
        </div>

        @if(!$speakers->isEmpty())
            <!-- Search and Filters -->
            <div class="border-b border-stroke px-4 py-4 dark:border-strokedark md:px-6 2xl:px-7.5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <!-- Search Input -->
                    <div class="relative flex-1 max-w-md">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            wire:model.live.debounce.300ms="search"
                            type="text" 
                            placeholder="Search speakers by name, profession, email..." 
                            class="w-full pl-10 pr-10 py-2 border border-slate-300 rounded-md focus:ring-0 focus:border-primary bg-transparent text-black placeholder-slate-400"
                        />
                        @if($search)
                            <button 
                                wire:click="clearSearch"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                    </div>

                    <!-- Per Page Selector -->
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-slate-600">Show:</label>
                        <select 
                            wire:model.live="perPage"
                            class="border border-slate-300 rounded px-4 w-16 py-1 text-sm focus:ring-0 focus:border-primary bg-transparent text-black"
                        >
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="text-sm text-slate-600">per page</span>
                    </div>
                </div>

                <!-- Search Results Info -->
                @if($search)
                    <div class="mt-2">
                        <p class="text-sm text-slate-600">
                            Showing results for "<span class="font-medium">{{ $search }}</span>" 
                            ({{ $speakers->total() }} {{ Str::plural('result', $speakers->total()) }})
                        </p>
                    </div>
                @endif
            </div>

            <!-- Table Header with Sorting -->
            <div class="hidden sm:grid sm:grid-cols-8 border-b border-stroke px-4 py-3 dark:border-strokedark md:px-6 2xl:px-7.5 bg-slate-50">
                <div class="col-span-3">
                    <button 
                        wire:click="sortBy('name')"
                        class="flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-800 uppercase tracking-wider"
                    >
                        Speaker
                        @if($sortField === 'name')
                            @if($sortDirection === 'asc')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </button>
                </div>
                <div class="col-span-2">
                    <button 
                        wire:click="sortBy('email')"
                        class="flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-800 uppercase tracking-wider"
                    >
                        Email
                        @if($sortField === 'email')
                            @if($sortDirection === 'asc')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </button>
                </div>
                <div class="col-span-1 text-center">
                    <button 
                        wire:click="sortBy('is_active')"
                        class="flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-800 uppercase tracking-wider"
                    >
                        Status
                        @if($sortField === 'is_active')
                            @if($sortDirection === 'asc')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </button>
                </div>
            </div>
        @endif
        <!-- Speaker List -->
        <div>
            @if($speakers->isEmpty())
                <div class="flex flex-col justify-center items-center h-full py-16">
                    @if($search)
                        <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-lg text-slate-500 font-medium mb-2">No speakers found</p>
                        <p class="text-sm text-slate-400 mb-4">Try adjusting your search terms</p>
                        <button 
                            wire:click="clearSearch"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors"
                        >
                            Clear Search
                        </button>
                    @else
                        <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="text-lg text-slate-500 font-medium mb-2">No speakers yet</p>
                        <p class="text-sm text-slate-400">Get started by adding your first speaker</p>
                    @endif
                </div>
            @else
                @foreach ($speakers as $key => $speaker)
                    <div class="hover:bg-slate-100/50 duration-300 grid grid-cols-10 border-t border-stroke px-4 py-4.5 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5">
                        <div class="col-span-3 flex items-center gap-4">
                            <div class="rounded-md">
                                @if($speaker->getFirstMediaUrl('speaker'))
                                    <img src="{{ $speaker->getFirstMediaUrl('speaker') }}" alt="{{ $speaker->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-300">
                                @else
                                    <p class="text-sm flex justify-center items-center font-normal rounded-full text-slate-400 bg-slate-200 border border-slate-400 w-10 h-10 drop-shadow tracking-widest">
                                        {{ \App\Helpers\Helper::getInitials($speaker->name) }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <p class="capitalize duration-300 text-md font-medium text-black dark:text-white">{{ $speaker->title }} {{ $speaker->name }}</p>
                                <p class="text-sm text-slate-500">
                                    {{ $speaker->profession }}
                                </p>
                            </div>
                        </div>
                        <div class="col-span-2 hidden items-center sm:flex">
                            <p class="text-sm font-medium text-black dark:text-white">
                                {{ $speaker->email ?? 'N/A' }}
                            </p>
                        </div>
                        {{-- <div class="col-span-1 hidden items-center sm:flex text-slate-600/60 justify-center italic">
                            {{ $speaker->programmes->count() . ' programme(s)' }}
                        </div> --}}
                        <div class="col-span-2 hidden items-center sm:flex">
                            @if($speaker->is_active)
                                <p class="inline-flex border border-success rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">Active</p>
                            @else
                                <p class="inline-flex border border-danger rounded-full bg-danger bg-opacity-10 px-3 py-1 text-sm font-medium text-danger">Inactive</p>
                            @endif
                        </div>
                        <div class="col-span-1 flex justify-end items-center gap-3">
                            @livewire('speaker.edit-speaker', ['speaker' => $speaker], key('edit-speaker-'.$speaker->id))
                            <button 
                                wire:click="deleteSpeaker({{ $speaker->id }})"
                                wire:confirm="Are you sure you want to delete this speaker?"
                                type="button" 
                                title="Delete Speaker" 
                                class="transform hover:scale-110 transition-all duration-300"
                                x-data="{ showToolTip: false }"
                                @mouseover="showToolTip = true" 
                                @mouseleave="showToolTip = false"
                            >
                                <svg class="w-5 h-5 stroke-red-400 hover:stroke-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                                <div x-show="showToolTip" x-transition class="absolute top-5 left-2 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-20">
                                    Delete
                                </div>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination -->
        @if($speakers->hasPages())
            <div class="border-t border-stroke px-4 py-4 dark:border-strokedark md:px-6 2xl:px-7.5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Pagination Info -->
                    <div class="text-sm text-slate-600">
                        Showing {{ $speakers->firstItem() ?? 0 }} to {{ $speakers->lastItem() ?? 0 }} of {{ $speakers->total() }} results
                    </div>
                    
                    <!-- Pagination Links -->
                    <div class="flex justify-center sm:justify-end">
                        {{ $speakers->links('vendor.livewire.custom-pagination') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-slate-700">Loading...</span>
        </div>
    </div>
</div>