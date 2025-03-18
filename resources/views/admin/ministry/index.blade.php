@section('title', 'Ministry Management')
<x-app-layout>
    <div class="flex justify-between gap-3 mb-8">
        <h4 class="text-2xl font-bold text-black dark:text-slate-600 capitalize">Ministry Management</h4>
        <a wire:navigate href="{{ route('admin.ministries.create') }}" 
            class="text-slate-100 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-800 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold py-3 px-5 mr-2">
            Create Ministry
        </a>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        @foreach ($ministries as $ministry)
            <div class="flex flex-col border border-slate-400/70 rounded-lg bg-zinc-100 dark:bg-slate-700 hover:bg-neutral-200/70 hover:-translate-y-0.5 dark:hover:bg-slate-800/90 duration-300 shadow-md">
                <div class="flex gap-3 p-4 bg-zinc-200 border-b border-slate-400/70 dark:bg-slate-800 rounded-t-lg items-center">
                    <p class="w-14 h-14 border border-zinc-800/40 dark:border-zinc-100/40 text-xl font-bold rounded-full text-slate-700 dark:text-slate-100 text-center flex items-center justify-center bg-slate-100 dark:bg-slate-400">
                        {{ Helper::getInitials($ministry->name) }}
                    </p>
                    {{-- <img class="w-14 h-14 border border-zinc-800/40 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ $ministry->name }}" /> --}}
                    {{-- <img src="https://placehold.co/400x400/lightgray/white" alt="{{ $ministry->name }}" class="w-14 h-14 border border-zinc-800/40 rounded-full"> --}}
                    <h4 class="text-xl font-bold text-slate-700 dark:text-slate-100 mb-3 capitalize leading-none">{{ $ministry->name }}</h4>
                </div>
                <div class="p-6">
                    <table>
                        <tr>
                            <td class="text-sm py-1.5 text-slate-600 dark:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </td>
                            <td class="text-sm py-1.5 text-slate-600 dark:text-white"> {{ $ministry->contactPerson ? $ministry->contactPerson : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm py-1.5 text-slate-600 dark:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            </td>
                            <td class="text-sm py-1.5 text-slate-600 dark:text-white"> {{ $ministry->contactNumber ? $ministry->contactNumber : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm py-1.5 text-slate-600 dark:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </td>
                            <td class="text-sm py-1.5 text-slate-600 dark:text-white"> {{ $ministry->contactEmail ? $ministry->contactEmail : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-sm py-1.5 text-slate-600 dark:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                </svg>
                            </td>
                            <td class="text-sm py-1 text-slate-600 dark:text-white"> 
                                @if ($ministry->websiteUrl)
                                    <a href="{{ $ministry->websiteUrl }}" target="_blank">
                                        {{ $ministry->websiteUrl }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="mt-4 flex gap-3">
                        <button class="bg-slate-700 dark:bg-slate-100 hover:-translate-y-0.5 hover:bg-slate-500 dark:hover:bg-slate-300 transition-all duration-300 shadow text-xs text-white dark:text-slate-600 px-4 py-2 rounded-full">
                            <a href="{{ route('admin.ministry.show', $ministry->id) }}">View</a>   
                        </button>
                        <button class="bg-slate-700 dark:bg-slate-100 hover:-translate-y-0.5 hover:bg-slate-500 dark:hover:bg-slate-300 transition-all duration-300 shadow text-xs text-white dark:text-slate-600 px-4 py-2 rounded-full">
                            <a href="{{ route('admin.ministry.edit', $ministry->id) }}">Edit</a>   
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-20">
        {{ $ministries->links() }}
    </div>
</x-app-layout>
