@section('title', 'View Speaker')
<x-app-layout>
    <div class="flex justify-between items-center gap-3 mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.speakers') }}" 
               class="text-slate-600 hover:text-slate-700 dark:text-slate-300 dark:hover:text-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h4 class="text-xl font-bold text-black dark:text-slate-600 capitalize">View Speaker Profile</h4>
        </div>
        {{-- <div class="flex gap-2">
            <a href="{{ route('admin.speakers.edit', $speaker->id) }}" 
                class="text-slate-100 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-800 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold lg:py-3 py-2 px-5">
                Edit Speaker
            </a>
        </div> --}}
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 flex flex-col gap-6">
            <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md">
                <div class="p-6 flex lg:flex-row flex-col gap-6 lg:items-start items-center justify-center">
                    <div class="flex flex-col gap-2 items-center justify-center">
                        <div class="lg:h-35 lg:w-35 h-50 w-50">
                            <img src="{{ $speaker->thumbnail ? Storage::url($speaker->thumbnail) : 'https://placehold.co/400x400/lightgray/white' }}" alt="{{ $speaker->name }}" class="w-full h-full object-cover border-4 border-slate-200 dark:border-slate-600 rounded-full">
                        </div>
                        <button class="text-slate-100 text-xs bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-800 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold py-1 px-4">
                            <a href="{{ route('admin.speakers.edit', $speaker->id) }}" class="flex gap-1 items-center">
                                Edit
                            </a>
                        </button>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">
                                {{ $speaker->title }} {{ $speaker->name }}
                            </h1>

                        </div>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mt-1">{{ $speaker->profession }}</p>
                        <p class="text-slate-500 dark:text-slate-400 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            {{ $speaker->email }}
                        </p>
                        <hr class="border-slate-400/70 my-2" />
                        <br />
                        <p class="text-lg text-slate-600 dark:text-slate-300 mt-2">About</p>
                        <p class="text-slate-500 dark:text-slate-400">{{ $speaker->about }}</p>
                    </div>
                </div>
            </div>

            <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
                @if($speaker->programmes->count() > 0)
                    <h2 class="text-2xl font-semibold text-slate-800 dark:text-slate-200 mb-6">Programme Engagements</h2>
                    @foreach($speaker->programmes as $programme)
                        <a href="#">
                            <div class="border border-slate-300 {{ $loop->last ? '' : 'border-b-0' }} dark:border-slate-600 hover:-translate-y-0.5 rounded-none p-4 hover:bg-slate-100 dark:hover:bg-slate-600 duration-300">
                                <div class="flex justify-between items-start">
                                    <div class="flex gap-3">
                                        <img src="{{ $programme->thumbnail ? Storage::url($programme->thumbnail) : 'https://placehold.co/400x400/lightgray/white' }}" alt="{{ $programme->title }}" class="w-18 h-18 object-cover border border-slate-200 dark:border-slate-600">
                                        <div>
                                            <h3 class="font-bold text-slate-800 dark:text-slate-200">{{ $programme->title }}</h3>
                                            <p class="text-xs text-slate-600 dark:text-slate-400">{{ 'By: ' . $programme->ministry->name }}</p>
                                            <p class="text-xs text-slate-600 dark:text-slate-400">{{ 'Date: ' . Carbon\Carbon::parse($programme->startDate)->format('F j, Y') }}</p>
                                            <p class="text-xs text-slate-600 dark:text-slate-400">
                                                @php
                                                    $random_string = ['zoom', 'Bible House, Singapore City', 'Marina Bay Sands'];
                                                @endphp
                                                {{ 'Venue: ' . $random_string[array_rand($random_string)] }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-slate-300 dark:bg-slate-200 text-slate-700 dark:text-slate-700">
                                        {{ $programme->pivot->type }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-slate-500 dark:text-slate-400">No programmes associated with this professional.</p>
                @endif
            </div>
        </div>
        <div class="lg:col-span-1">
            <div class="lg:col-span-1">
                <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Details</h2>
                    <div class="space-y-5">
                        <div class="flex items-center gap-2">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Created</p>
                            <p class="text-slate-800 dark:text-slate-200">{{ $speaker->created_at->format('F j, Y') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Last Updated</p>
                            <p class="text-slate-800 dark:text-slate-200">{{ $speaker->updated_at->format('F j, Y') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Status</p>
                            <span class="px-3 py-1 text-xs rounded-full {{ $speaker->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $speaker->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <br />
                    <hr class="border-slate-400/70" />

                    <br />

                    @if($speaker->socials)
                        <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Social Media</h2>
                        <div class="space-y-1 flex gap-2">
                            @foreach($speaker->socials as $platform => $social)
                                <button class="flex items-center gap-2 hover:-translate-y-0.5 duration-300 border border-slate-400/70 bg-slate-100 dark:bg-slate-600 hover:bg-slate-200 dark:hover:bg-slate-500 rounded-full py-1 px-3">
                                    <a href="{{ $social['url'] }}" target="_blank">
                                        {{$social['name']}}
                                    </a>
                                </button>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout> 