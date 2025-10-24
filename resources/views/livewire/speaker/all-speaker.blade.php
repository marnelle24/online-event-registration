<div>
    <!-- Header Section -->
    <div class="flex justify-between gap-3 mb-8 lg:flex-row flex-col lg:items-center items-start">
        <div>
            <h4 class="text-3xl font-bold text-black capitalize">Speaker Management</h4>
            <p class="text-sm text-slate-500">Manage Speakers and Professionals for your events</p>
        </div>
        <div class="flex lg:gap-3 gap-1">
            <button wire:click="exportCsv" 
                class="flex items-center gap-2 border border-slate-500 bg-slate-100 drop-shadow text-slate-500 hover:text-slate-200 hover:bg-slate-600 rounded-full hover:-translate-y-1 duration-300 py-2 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Export CSV
            </button>
            <button wire:click="exportExcel" 
                class="flex items-center gap-2 shadow border border-blue-600/30 bg-green-700 drop-shadow text-slate-200 hover:bg-green-800 rounded-full hover:-translate-y-1 duration-300 py-2 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                </svg>
                Export Excel
            </button>
            @livewire('speaker.add-speaker', key('add-new-speaker'))
        </div>
    </div>

    <!-- Search and Filters Section -->
    <div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 mb-6">
        <p class="text-lg font-bold text-slate-700 mb-2">Filter</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <!-- Search -->
            <div class="lg:col-span-2 col-span-1">
                <label class="block text-sm font-medium text-slate-700 mb-2">Search</label>
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="search" 
                    placeholder="Search by name, email, profession..."
                    class="w-full py-2 px-3 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500"
                />
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select 
                    wire:model.live="statusFilter" 
                    class="w-full py-2 px-3 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500"
                >
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Profession Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Profession</label>
                <select 
                    wire:model.live="professionFilter" 
                    class="w-full py-2 px-3 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500"
                >
                    <option value="">All Professions</option>
                    @foreach($professions as $profession)
                        <option value="{{ $profession }}">{{ $profession }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Results Table -->
    <div class="rounded-sm border border-stroke">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-slate-200 border border-slate-300 text-slate-500 text-left">
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300" wire:click="sortByName">
                            Name
                            @if($sortBy === 'name')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300" wire:click="sortByEmail">
                            Email
                            @if($sortBy === 'email')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300" wire:click="sortByProfession">
                            Profession
                            @if($sortBy === 'profession')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300" wire:click="sortByStatus">
                            Status
                            @if($sortBy === 'is_active')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300" wire:click="sortByCreatedAt">
                            Created
                            @if($sortBy === 'created_at')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($speakers->count())
                        @foreach ($speakers as $speaker)
                            <tr class="hover:bg-slate-400/10 duration-300 border border-slate-300 dark:border-slate-700 bg-white">
                                <td class="p-4 pl-6 w-[25%]">
                                    <div class="flex items-center gap-3">
                                        <div class="rounded-full">
                                            @if($speaker->getFirstMediaUrl('speaker'))
                                                <img src="{{ $speaker->getFirstMediaUrl('speaker') }}" alt="{{ $speaker->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-300">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-slate-600">
                                                        {{ \App\Helpers\Helper::getInitials($speaker->name) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800">
                                                {{ $speaker->title }} {{ $speaker->name }}
                                            </span>
                                            <span class="text-xs text-slate-500">{{ $speaker->profession }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-sm text-slate-600">{{ $speaker->email ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col text-left">
                                        <span class="font-medium text-slate-600 dark:text-slate-200">
                                            {{ $speaker->profession ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-start">
                                        @php
                                            $statusColors = [
                                                'active' => 'bg-green-100 text-green-800 border-green-600',
                                                'inactive' => 'bg-red-100 text-red-800 border-red-600',
                                            ];
                                            $statusColor = $statusColors[$speaker->is_active ? 'active' : 'inactive'] ?? 'bg-gray-100 text-gray-800 border-gray-600';
                                        @endphp
                                        <span class="px-3 py-1 text-xs rounded-full border {{ $statusColor }}">
                                            {{ $speaker->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-slate-600 dark:text-slate-200">
                                            {{ $speaker->created_at->format('M j, Y') }}
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $speaker->created_at->format('g:i A') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-end items-center space-x-2">
                                        <button type="button" title="Edit Speaker" x-cloak x-data="{ showToolTip: false }" class="relative flex items-center gap-3">
                                            <svg 
                                                wire:click="callEditSpeakerModal('{{ $speaker->id }}')"
                                                @mouseover="showToolTip = true" 
                                                @mouseleave="showToolTip = false"
                                                class="cursor-pointer w-5 h-5 stroke-blue-500 hover:-translate-y-0.5 duration-300 hover:stroke-blue-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            {{-- add tooltip --}}
                                            <div x-show="showToolTip" x-transition class="absolute top-5 -left-4 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                                Edit
                                            </div>
                                        </button>
                                        {{-- <button type="button" title="Delete Speaker" x-cloak x-data="{ showToolTip: false }" class="relative flex items-center gap-3"
                                            wire:click="toggleStatus({{ $speaker->id }})"
                                            wire:confirm="Are you sure you want to delete this speaker?"
                                            type="button" 
                                            title="Delete Promotion" 
                                            class="transform hover:scale-110 transition-all duration-300"
                                            x-data="{ showToolTip: false }"
                                            @mouseover="showToolTip = true" 
                                            @mouseleave="showToolTip = false"
                                        >
                                            @php
                                                $statusColor = $speaker->is_active ? 'stroke-green-500 hover:stroke-green-600' : 'stroke-red-400 hover:stroke-red-600';
                                            @endphp
                                            <svg 
                                                class="w-5 h-5 {{ $statusColor }}"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                            </svg>

                                            <div x-show="showToolTip" x-transition class="absolute top-5 -right-4 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                                {{ $speaker->is_active ? 'Disable' : 'Enable' }}
                                            </div>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="group bg-white duration-300">
                            <td colspan="6" class="text-center">
                                <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-slate-400 dark:text-slate-500 mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    <p class="text-slate-500 text-lg font-medium">No speakers found</p>
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
                    class="py-1 px- w-20 border border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        {{ $speakers->links() }}
    </div>

    @livewire('speaker.edit-speaker', key('edit-speaker'))
</div>
