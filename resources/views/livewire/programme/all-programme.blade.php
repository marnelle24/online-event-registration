<div>
    <!-- Header Section -->
    <div class="flex justify-between gap-3 mb-8 lg:flex-row flex-col lg:items-center items-start">
        <div>
            <h4 class="text-3xl font-bold text-black capitalize">Programme Management</h4>
            <p class="text-sm text-slate-500">Manage Programmes and Events for your organization</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-2">
            <button wire:click="exportCsv"
                class="flex items-center gap-2 border border-slate-500 bg-slate-100 drop-shadow text-slate-500 hover:text-slate-200 hover:bg-slate-600 rounded-full hover:-translate-y-0.5 duration-300 py-2 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Export CSV
            </button>
            <button wire:click="exportExcel"
                class="flex items-center gap-2 shadow border border-blue-600/30 bg-green-700 drop-shadow text-slate-200 hover:bg-green-800 rounded-full hover:-translate-y-0.5 duration-300 py-2 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                </svg>
                Export Excel
            </button>
            @livewire('programme.add-programme', key('add-new-programme'))
        </div>
    </div>

    <!-- Search and Filters Section -->
    <div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 mb-6">
        {{-- <p class="text-lg font-bold text-slate-700 mb-2">Filter</p> --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
            <!-- Search -->
            <div class="lg:col-span-2 col-span-1">
                <label class="block text-sm font-medium text-slate-700 mb-2">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        wire:model.live.debounce.500ms="search"
                        type="search"
                        placeholder="Search by title, code, description..."
                        class="w-full pl-10 py-2 border border-slate-300 rounded-md focus:ring-0 focus:ring-slate-500 focus:border-slate-500 bg-white text-slate-900 placeholder-slate-400"
                        wire:loading.attr="disabled"
                    />
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select wire:model.live="statusFilter" class="w-full py-2 px-3 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500">
                    @foreach($statuses as $status => $label)
                        <option value="{{ $status }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Ministry Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Ministry</label>
                <select wire:model.live="ministryFilter" class="w-full py-2 px-3 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500">
                    <option value="">All Ministries</option>
                    @foreach($ministries as $ministry)
                        <option value="{{ $ministry->id }}">{{ $ministry->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Type</label>
                <select wire:model.live="typeFilter" class="w-full py-2 px-3 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500">
                    @foreach($types as $type => $label)
                        <option value="{{ $type ?? '' }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="rounded-sm border border-stroke">
        <div class="max-w-full md:overflow-x-visible overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-slate-200 border border-slate-300 text-slate-500 text-left">
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300 text-nowrap" wire:click="sortByTitle">
                            Programme
                            @if($sortBy === 'title')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold">&nbsp;</th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300 text-nowrap" wire:click="sortByMinistry">
                            Ministry
                            @if($sortBy === 'ministry_id')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300 text-nowrap" wire:click="sortByPrice">
                            Price
                            @if($sortBy === 'price')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold">&nbsp;</th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody wire:loading.class="opacity-50" wire:target="search,statusFilter,ministryFilter,typeFilter,perPage,sortBy,clearSearch">
                    @if($programmes->count())
                        @foreach ($programmes as $programme)
                            <tr class="hover:bg-slate-400/10 duration-300 border border-slate-300 dark:border-strokedark bg-white">
                                <td class="p-4 pl-6 md:w-[30%] w-full">
                                    <div class="relative flex items-start gap-3">
                                        @if($programme->active_promotion)
                                            <div class="absolute top-0 -left-2 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-md animate-bounce">
                                                {{ $programme->active_promotion->title }}
                                            </div>
                                        @endif
                                        <div class="rounded-lg">
                                            @if($programme->getFirstMediaUrl('thumbnail'))
                                                <img src="{{ $programme->getFirstMediaUrl('thumbnail') }}" alt="{{ $programme->title }}" class="w-16 h-16 rounded-lg object-cover border border-slate-300">
                                            @else
                                                <div class="w-16 h-16 rounded-lg bg-slate-200 border border-slate-300 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-slate-600">
                                                        {{ \App\Helpers\Helper::getInitials($programme->title) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <span class="text-xs text-slate-500 font-bold">{{ $programme->programmeCode }}</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="flex gap-1 items-start">
                                                <h1 class="text-lg font-bold text-slate-800 leading-tight">
                                                    {{ Str::words($programme->title, 8) }}
                                                </h1>
                                            </div>
                                            <div class="flex justify-start mt-2 gap-1">
                                                @php
                                                    $statusColors = [
                                                        'published' => 'bg-green-100 text-green-800 border-green-600',
                                                        'draft' => 'bg-yellow-100 text-yellow-800 border-yellow-600',
                                                        'pending' => 'bg-orange-100 text-orange-800 border-orange-600',
                                                    ];
                                                @endphp
                                                <span class="px-2 py-0.5 text-[10px] rounded-full border {{ $statusColors[$programme->status] ?? 'bg-gray-100 text-gray-800 border-gray-600' }}">
                                                    {{ ucfirst($programme->status) }}
                                                </span>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs text-slate-700/60 capitalize bg-slate-100/20 px-2 py-0.5 rounded-full border border-slate-300">{{ $programme->type ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex-grow space-y-2 justify-start truncate">
                                        <div class="flex gap-1 items-start text-slate-600 dark:text-slate-300">
                                            <p class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                </svg>
                                            </p>
                                            <p class="text-sm capitalize leading-tight">{{ $programme->getLocationAttribute() }}</p>
                                        </div>
                                        <div class="flex items-start gap-1 text-slate-600 dark:text-slate-300">
                                            <p class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                                </svg>
                                            </p>
                                            <p class="text-sm leading-tight">{{ $programme->getProgrammeDatesAttribute() }}</p>
                                        </div>
                                        <div class="flex items-start gap-1 text-slate-600 dark:text-slate-300">
                                            <p class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </p>
                                            <p class="text-sm leading-tight">{{ $programme->getProgrammeTimesAttribute() }}</p>
                                        </div>
                                    </div>    
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-sm text-slate-600 text-nowrap">{{ $programme->ministry->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        @if($programme->active_promotion)
                                            <span class="text-sm line-through text-slate-400">{{ $programme->formatted_price }}</span>
                                            <span class="text-sm font-semibold text-green-500">{{ $programme->discounted_price }}</span>
                                        @else
                                            <span class="text-sm font-semibold">{{ $programme->formatted_price }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">

                                        <span class="flex gap-1 items-center text-sm text-slate-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                            </svg>
                                            {{ $programme->getTotalRegistrationsAttribute() }}
                                            <span class="text-xs text-slate-500">/</span>
                                            @if($programme->limit > 0)
                                                {{ $programme->limit }}
                                            @else
                                                <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" class="w-6 h-6">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier"> 
                                                        <path d="M20.288 9.463a4.856 4.856 0 0 0-4.336-2.3 4.586 4.586 0 0 0-3.343 1.767c.071.116.148.226.212.347l.879 1.652.134-.254a2.71 2.71 0 0 1 2.206-1.519 2.845 2.845 0 1 1 0 5.686 2.708 2.708 0 0 1-2.205-1.518L13.131 12l-1.193-2.26a4.709 4.709 0 0 0-3.89-2.581 4.845 4.845 0 1 0 0 9.682 4.586 4.586 0 0 0 3.343-1.767c-.071-.116-.148-.226-.212-.347l-.879-1.656-.134.254a2.71 2.71 0 0 1-2.206 1.519 2.855 2.855 0 0 1-2.559-1.369 2.825 2.825 0 0 1 0-2.946 2.862 2.862 0 0 1 2.442-1.374h.121a2.708 2.708 0 0 1 2.205 1.518l.7 1.327 1.193 2.26a4.709 4.709 0 0 0 3.89 2.581h.209a4.846 4.846 0 0 0 4.127-7.378z"></path> 
                                                    </g>
                                                </svg>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-end items-start gap-1.5">
                                        <a 
                                            x-cloak 
                                            x-data="{ showToolTip: false }" 
                                            href="{{ route('admin.programmes.show', $programme->programmeCode) }}" 
                                            @mouseover="showToolTip = true" 
                                            @mouseleave="showToolTip = false"
                                            class="transform hover:scale-110 transition-all duration-300">
                                            <svg class="w-5 h-5 stroke-blue-500 hover:stroke-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            {{-- add tooltip --}}
                                            <div x-show="showToolTip" x-transition class="absolute top-5 -left-4 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                                View
                                            </div>
                                        </a>
                                        <button type="button" x-cloak x-data="{ showToolTip: false }" class="relative flex items-center gap-3">
                                            <svg 
                                                wire:click="deleteProgramme({{ $programme->id }})"
                                                wire:confirm="Are you sure you want to delete this programme?"
                                                @mouseover="showToolTip = true" 
                                                @mouseleave="showToolTip = false"
                                                class="cursor-pointer w-5 h-5 stroke-red-500 hover:-translate-y-0.5 duration-300 hover:stroke-red-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            {{-- add tooltip --}}
                                            <div x-show="showToolTip" x-transition class="absolute top-5 -left-8 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                                Delete
                                            </div>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="group bg-white duration-300">
                            <td colspan="8" class="text-center">
                                <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-slate-400 dark:text-slate-500 mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                    </svg>
                                    <p class="text-slate-500 text-lg font-medium">No programmes found</p>
                                    <p class="text-slate-400 text-sm">Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="mt-6 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <div class="flex lg:flex-row flex-col lg:items-center items-start lg:gap-2 gap-1">
                <label class="block text-sm font-medium text-slate-700 mb-1">Per Page</label>
                <select
                    wire:model.live="perPage"
                    class="py-1 px-3 w-20 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-0"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        {{ $programmes->links() }}
    </div>
    
</div>

