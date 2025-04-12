@section('title', 'View Ministry')
<x-app-layout>
    <div class="flex justify-between items-center gap-3 mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.ministry') }}" 
               class="text-slate-600 hover:text-slate-700 dark:text-slate-300 dark:hover:text-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h4 class="text-xl font-bold text-black dark:text-slate-600 capitalize">View Ministry Profile</h4>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 flex flex-col gap-6">
            <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md">
                <div class="p-6 flex lg:flex-row flex-col gap-6 lg:items-start items-center justify-center">
                    <div class="flex flex-col gap-2 items-center justify-center">
                        <p class="lg:h-35 lg:w-35 h-50 w-50 border border-zinc-800/40 dark:border-zinc-100/40 text-6xl font-bold rounded-full text-slate-500 dark:text-slate-100 text-center flex items-center justify-center bg-slate-100 dark:bg-slate-400">
                            {{ Helper::getInitials($ministry->name) }}
                        </p>
                        <button class="text-slate-100 text-xs bg-slate-400 hover:bg-slate-700 dark:bg-slate-400 dark:hover:bg-slate-500 rounded-full hover:-translate-y-0.5 duration-300 border border-slate-400 shadow hover:border-slate-700 font-bold py-1 px-4">
                            <a href="{{ route('admin.ministry.edit', $ministry->id) }}" class="flex gap-1 items-center">
                                Edit
                            </a>
                        </button>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">
                                {{ $ministry->name }}
                            </h1>
                        </div>
                        <p class="flex gap-1 items-center text-lg text-slate-600 dark:text-slate-300 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            {{ $ministry->contactPerson ? $ministry->contactPerson : 'N/A' }}
                        </p>
                        <p class="flex gap-1 items-center text-lg text-slate-600 dark:text-slate-300 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                            {{ $ministry->contactNumber ? $ministry->contactNumber : 'N/A' }}
                        </p>
                        <p class="flex gap-1 items-center text-lg text-slate-600 dark:text-slate-300 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            {{ $ministry->contactEmail ? $ministry->contactEmail : 'N/A' }}
                        </p>
                        <p class="flex gap-1 items-center text-lg text-slate-600 dark:text-slate-300 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                            @if ($ministry->websiteUrl)
                                <a href="{{ $ministry->websiteUrl }}" target="_blank" class="text-blue-500 hover:underline hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-500">
                                    {{ $ministry->websiteUrl }}
                                </a>
                            @else
                                N/A
                            @endif
                        </p>
                        <hr class="border-slate-400/70 my-2" />
                        <br />
                        <p class="text-lg text-slate-600 dark:text-slate-300 mt-2">About</p>
                        <p class="text-slate-500 dark:text-slate-400">{{ $ministry->bio }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-200 mt-6 mb-2">Ministry Programmes</h2>
                <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
                    @if($ministry->programmes && $ministry->programmes->count() > 0)
                        @foreach($ministry->programmes as $programme)
                            <a href="#">
                                <div class="border border-slate-300 {{ $loop->last ? '' : 'border-b-0' }} dark:border-slate-600 hover:-translate-y-0.5 rounded-none p-4 hover:bg-slate-100 dark:hover:bg-slate-600 duration-300">
                                    <div class="flex justify-between items-start">
                                        <div class="flex gap-1">
                                            <img src="{{ $programme->thumbnail ? Storage::url($programme->thumbnail) : 'https://placehold.co/400x400/lightgray/white' }}" alt="{{ $programme->title }}" class="w-18 h-18 object-cover border border-slate-200 dark:border-slate-600">
                                            <div>
                                                <h3 class="font-bold text-slate-800 dark:text-slate-200 text-lg">{{ $programme->title }}</h3>
                                                <p class="text-xs text-slate-600 dark:text-slate-400">{{ 'Date: ' . Carbon\Carbon::parse($programme->startDate)->format('F j, Y') }}</p>
                                                <p class="text-xs text-slate-600 dark:text-slate-400">
                                                    @php
                                                        $random_string = ['zoom', 'Bible House, Singapore City', 'Marina Bay Sands'];
                                                    @endphp
                                                    {{ 'Venue: ' . $random_string[array_rand($random_string)] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <p class="text-slate-500 dark:text-slate-400">No programmes associated with this ministry.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Details</h2>
                <div class="space-y-5">
                    <div class="flex items-center gap-2">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Created</p>
                        <p class="text-slate-800 dark:text-slate-200">{{ $ministry->created_at->format('F j, Y') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Last Updated</p>
                        <p class="text-slate-800 dark:text-slate-200">{{ $ministry->updated_at->format('F j, Y') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Status</p>
                        <span class="px-3 py-1 text-xs rounded-full {{ $ministry->status ? 'bg-green-100 text-green-800 border border-green-600/60' : 'bg-red-100 text-red-800 border border-red-600/60' }}">
                            {{ $ministry->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Publishabled</p>
                        <span class="px-3 py-1 text-xs rounded-full {{ $ministry->publishabled ? 'bg-green-100 text-green-800 border border-green-600/60' : 'bg-red-100 text-red-800 border border-red-600/60' }}">
                            {{ $ministry->publishabled ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Searchable</p>
                        <span class="px-3 py-1 text-xs rounded-full {{ $ministry->searcheable ? 'bg-green-100 text-green-800 border border-green-600/60' : 'bg-red-100 text-red-800 border border-red-600/60' }}">
                            {{ $ministry->searcheable ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="flex gap-1">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Requested By:</p>
                            <span class="py1 text-sm text-slate-500 dark:text-slate-400">
                                {{ $ministry->requestedBy ? $ministry->requestedBy : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex gap-1">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Approved By:</p>
                            <span class="py1 text-sm text-slate-500 dark:text-slate-400">
                                {{ $ministry->approvedBy ? $ministry->approvedBy : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
                <br />
                <hr class="border-slate-400/70" />
                <br />

                @if($ministry->links)
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">External Links</h2>
                    <div class="space-y-1 flex gap-2">
                        @foreach($ministry->links as $link)
                            <button class="flex items-center gap-2 hover:-translate-y-0.5 duration-300 border border-slate-400/70 bg-slate-100 dark:bg-slate-600 hover:bg-slate-200 dark:hover:bg-slate-500 rounded-full py-1 px-3">
                                <a href="{{ $link['url'] }}" target="_blank">
                                    {{ $link['name'] }}
                                </a>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
