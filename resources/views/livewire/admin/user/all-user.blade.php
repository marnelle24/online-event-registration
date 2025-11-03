<div>
    <!-- Header Section -->
    <div class="flex justify-between gap-3 mb-8 lg:flex-row flex-col lg:items-center items-start">
        <div>
            <h4 class="text-3xl font-bold text-black capitalize">User Management</h4>
            <p class="text-sm text-slate-500">Manage users and their access to ministries</p>
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
            @livewire('admin.user.add-user', key('add-new-user'))
        </div>
    </div>

    <!-- Search and Filters Section -->
    <div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 mb-6">
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
                        placeholder="Search by name, email..."
                        class="w-full pl-10 py-2 border border-slate-300 rounded-md focus:ring-0 focus:ring-slate-500 focus:border-slate-500 bg-white text-slate-900 placeholder-slate-400"
                        wire:loading.attr="disabled"
                    />
                </div>
            </div>

            <!-- Role Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                <select wire:model.live="roleFilter" class="w-full py-2 px-3 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500">
                    @foreach($roles as $role => $label)
                        <option value="{{ $role }}">{{ $label }}</option>
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

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select wire:model.live="statusFilter" class="w-full py-2 px-3 border border-slate-300 rounded-md bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500">
                    @foreach($statuses as $status => $label)
                        <option value="{{ $status }}">{{ $label }}</option>
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
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300" wire:click="sortByRole">
                            Role
                            @if($sortBy === 'role')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold">Ministries</th>
                        <th class="p-4 font-bold cursor-pointer hover:bg-slate-300" wire:click="sortByStatus">
                            Status
                            @if($sortBy === 'is_active')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @else
                                <span class="ml-1">↓</span>
                            @endif
                        </th>
                        <th class="p-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody wire:loading.class="opacity-50" wire:target="search,roleFilter,ministryFilter,statusFilter,perPage,sortBy,clearSearch">
                    @if($users->count())
                        @foreach ($users as $user)
                            <tr class="hover:bg-slate-400/10 duration-300 border border-slate-300 dark:border-strokedark bg-white">
                                <td class="p-4 pl-6">
                                    <div class="flex items-center gap-3">
                                        @if($user->profile_photo_url)
                                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-300">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-slate-600">
                                                    {{ \App\Helpers\Helper::getInitials($user->name) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <h1 class="text-lg font-bold text-slate-800 leading-tight">
                                                {{ $user->name }}
                                            </h1>
                                            @if($user->firstname || $user->lastname)
                                                <span class="text-xs text-slate-500">
                                                    {{ trim(($user->firstname ?? '') . ' ' . ($user->lastname ?? '')) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="text-sm text-slate-700">{{ $user->email }}</span>
                                </td>
                                <td class="p-4 flex justify-start items-center">
                                    <div class="flex flex-col">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-800 border-purple-600',
                                                'user' => 'bg-blue-100 text-blue-800 border-blue-600',
                                            ];
                                        @endphp
                                        <p class="text-center">
                                            <span class="px-2 py-0.5 text-xs rounded-full border {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 border-gray-600' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </p>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-wrap">
                                        @if($user->ministries->count() > 0)
                                            @foreach($user->ministries->take(2) as $ministry)
                                                <span class="text-xs text-slate-700 capitalize font-medium">{{ $ministry->name }}</span>
                                                @if(!$loop->last)
                                                    <span class="text-xs text-slate-700 capitalize mr-1">,</span>
                                                @endif
                                            @endforeach
                                            @if($user->ministries->count() > 2)
                                                <span class="text-xs text-slate-500 mx-1">
                                                    +{{ $user->ministries->count() - 2 }} more
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-xs text-slate-400">No ministries</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 flex justify-start items-center">
                                    <div class="relative" 
                                        x-cloak
                                        x-data="{ 
                                            isActive: {{ $user->is_active ? 'true' : 'false' }},
                                            showToolTip: false
                                        }"
                                        @mouseover="showToolTip = true" 
                                        @mouseleave="showToolTip = false">
                                        <label for="toggleStatus{{ $user->id }}" class="flex cursor-pointer select-none items-center">
                                            <div class="relative">
                                                <input 
                                                    wire:confirm="Are you sure you want to change the status of this user?"
                                                    wire:change="toggleUserStatus({{ $user->id }})"
                                                    wire:loading.attr="disabled"
                                                    type="checkbox" 
                                                    id="toggleStatus{{ $user->id }}" 
                                                    class="sr-only" 
                                                    {{ $user->is_active ? 'checked' : '' }}
                                                    x-on:change="isActive = !isActive"
                                                />
                                                <div :class="isActive && '!bg-success'" class="block h-8 w-14 rounded-full bg-black cursor-pointer transition"></div>
                                                <div :class="isActive && '!right-1 !translate-x-full'" class="absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition cursor-pointer"></div>
                                            </div>
                                        </label>
                                        <div 
                                            x-cloak
                                            x-show="showToolTip" x-transition class="absolute left-0 top-9.5 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 w-max bg-slate-800 rounded px-2 py-1 shadow-lg z-50">
                                            <p class="text-left text-xs text-white">Click to toggle</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-end items-center gap-1.5">
                                        <button 
                                            type="button"
                                            wire:confirm="Are you sure you want to reset the password of this user?"
                                            x-cloak 
                                            wire:click="callResetPasswordModal({{ $user->id }})"
                                            class="group relative flex items-center gap-1 transform hover:scale-105 transition-all bg-yellow-500 duration-300 border border-yellow-500/30 rounded-full hover:bg-yellow-300 py-1 px-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 stroke-white group-hover:stroke-yellow-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                            </svg>
                                            <span class="text-xs font-light tracking-normal text-white group-hover:text-yellow-600">Reset Password</span>
                                        </button>
                                        <button 
                                            type="button"
                                            x-cloak 
                                            x-data="{ showToolTip: false }" 
                                            wire:click="callEditUserModal({{ $user->id }})"
                                            @mouseover="showToolTip = true" 
                                            @mouseleave="showToolTip = false"
                                            class="relative flex items-center gap-3 transform hover:scale-110 transition-all duration-300">
                                            <svg class="w-5 h-5 stroke-blue-500 hover:stroke-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            <div x-show="showToolTip" x-transition class="absolute top-5 -left-4 transition-all duration-300 ease-in-out hover:opacity-100 hover:translate-y-0 bg-slate-800 text-white text-xs rounded px-2 py-1 shadow-lg z-50">
                                                Edit
                                            </div>
                                        </button>
                                        <button 
                                            type="button"
                                            x-cloak 
                                            x-data="{ showToolTip: false }" 
                                            class="relative flex items-center gap-3">
                                            <svg 
                                                wire:click="deleteUser({{ $user->id }})"
                                                wire:confirm="Are you sure you want to delete this user?"
                                                @mouseover="showToolTip = true" 
                                                @mouseleave="showToolTip = false"
                                                class="cursor-pointer w-5 h-5 stroke-red-500 hover:-translate-y-0.5 duration-300 hover:stroke-red-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
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
                            <td colspan="6" class="text-center">
                                <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-slate-400 dark:text-slate-500 mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <p class="text-slate-500 text-lg font-medium">No users found</p>
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

        {{ $users->links() }}
    </div>
    
    @livewire('admin.user.edit-user', key('edit-user'))
    @livewire('admin.user.reset-password-modal', key('reset-password-modal'))
</div>

