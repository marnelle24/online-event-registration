<div>
    <!-- Header Section -->
    <div class="flex justify-between gap-3 mb-8 lg:flex-row flex-col lg:items-center items-start">
        <div>
            <h4 class="text-3xl font-bold text-black capitalize">Category Management</h4>
            <p class="text-sm text-slate-500">Manage Categories for your programmes and events</p>
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
            @livewire('category.add-category', key('add-new-category'))
        </div>
    </div>

    <!-- Search and Filters Section -->
    <div class="bg-white shadow-md rounded-lg border border-slate-300 p-6 mb-6">
        <p class="text-lg font-bold text-slate-700 mb-2">Filter</p>
        <div class="mb-4">
            <!-- Search -->
            <div class="lg:col-span-2 col-span-1">
                <div class="relative">
                    <input
                        wire:model.live.debounce.500ms="search"
                        type="search"
                        placeholder="Search by name, slug..."
                        class="w-full py-2 px-3 border text-lg border-slate-300 rounded-none bg-white text-slate-700 focus:outline-none focus:ring-0 focus:ring-slate-500"
                        wire:loading.attr="disabled"
                    />
                    <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="animate-spin h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
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
                        <th class="p-4 font-bold">
                            Slug
                        </th>
                        <th class="p-4 font-bold">
                            Programmes
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
                    @if($categories->count())
                        @foreach ($categories as $category)
                            <tr class="hover:bg-slate-400/10 duration-300 border border-slate-300 dark:border-slate-700 bg-white">
                                <td class="p-4 pl-6 w-[25%]">
                                    <div class="flex items-center gap-3">
                                        <div class="rounded-full">
                                            <div class="w-10 h-10 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-slate-600">
                                                    {{ \App\Helpers\Helper::getInitials($category->name) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800 capitalize">
                                                {{ $category->name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-sm text-slate-600">{{ '/'.$category->slug }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-start">
                                        <span class="px-3 py-1 rounded-lg border bg-blue-100 text-blue-800 border-blue-600">
                                            {{ $category->programmes->count() }} programme(s)
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-slate-600 dark:text-slate-200">
                                            {{ $category->created_at->format('M j, Y') }}
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $category->created_at->format('g:i A') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4 flex justify-end items-start gap-2">
                                    <button type="button" x-cloak x-data="{ showToolTip: false }" class="relative flex items-center gap-3">
                                        <svg 
                                            wire:click="callEditCategoryModal('{{ $category->id }}')"
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
                                    <button type="button" x-cloak x-data="{ showToolTip: false }" class="relative flex items-center gap-3">
                                        <svg 
                                            wire:click="deleteCategory({{ $category->id }})"
                                            wire:confirm="Are you sure you want to delete this category?"
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
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="group bg-white duration-300">
                            <td colspan="5" class="text-center">
                                <div class="flex flex-col items-center bg-white group-hover:bg-slate-50/70 duration-300 py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-slate-400 dark:text-slate-500 mb-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                    </svg>
                                    <p class="text-slate-500 text-lg font-medium">No categories found</p>
                                    <p class="text-slate-400 text-sm">Try adjusting your search criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @livewire('category.edit-category', key('edit-category'))

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

        {{ $categories->links() }}
    </div>
</div>
