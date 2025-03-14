@section('title', 'View Speaker')
<x-app-layout>
    <div class="flex justify-between items-center gap-3 mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.speakers') }}" 
               class="text-slate-600 hover:text-slate-700 dark:text-slate-300 dark:hover:text-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h4 class="lg:text-2xl text-xl font-bold text-black dark:text-slate-600 capitalize">View Speaker</h4>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.speakers.edit', $speaker->id) }}" 
                class="text-slate-100 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-800 rounded-full hover:-translate-y-1 duration-300 border border-slate-600 hover:border-slate-700 font-bold lg:py-3 py-2 px-5">
                Edit Speaker
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2">
            <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md">
                <!-- Header with Image -->
                <div class="p-6 flex gap-6 items-start border-b border-slate-400/70">
                    <img src="{{ $speaker->thumbnail ? Storage::url($speaker->thumbnail) : 'https://placehold.co/400x400/lightgray/white' }}" 
                         alt="{{ $speaker->name }}" 
                         class="w-32 h-32 object-cover border-4 border-slate-200 dark:border-slate-600 rounded-full">
                    <div class="flex-grow">
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">
                                {{ $speaker->title }} {{ $speaker->name }}
                            </h1>
                            <span class="px-3 py-1 text-xs rounded-full {{ $speaker->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $speaker->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mt-1">{{ $speaker->profession }}</p>
                        <p class="text-slate-500 dark:text-slate-400 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            {{ $speaker->email }}
                        </p>
                    </div>
                </div>

                <!-- About Section -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">About</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {{ $speaker->about ?? 'No information available.' }}
                    </div>
                </div>
            </div>

            <!-- Programmes Section -->
            @if($speaker->programmes->count() > 0)
                <div class="mt-6 border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Associated Programmes</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($speaker->programmes as $programme)
                            <div class="border border-slate-300 dark:border-slate-600 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-slate-800 dark:text-slate-200">{{ $programme->title }}</h3>
                                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $programme->startDate }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-slate-100 dark:bg-slate-600 text-slate-700 dark:text-slate-300">
                                        {{ $programme->pivot->type }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-1">
            <!-- Social Media Links -->
            @if($speaker->socials)
                <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6 mb-6">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Social Media</h2>
                    <div class="space-y-3">
                        @foreach($speaker->socials as $platform => $social)
                            @if(!empty($social['url']))
                                <a href="{{ $social['url'] }}" 
                                   target="_blank"
                                   class="flex items-center gap-3 p-3 rounded-lg border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                                    <span class="text-slate-700 dark:text-slate-200">{{ $social['name'] }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Meta Information -->
            <div class="border border-slate-400/70 rounded-lg bg-white dark:bg-slate-700 shadow-md p-6">
                <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Details</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Created</p>
                        <p class="text-slate-800 dark:text-slate-200">{{ $speaker->created_at->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Last Updated</p>
                        <p class="text-slate-800 dark:text-slate-200">{{ $speaker->updated_at->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Status</p>
                        <p class="text-slate-800 dark:text-slate-200">{{ $speaker->is_active ? 'Active' : 'Inactive' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 