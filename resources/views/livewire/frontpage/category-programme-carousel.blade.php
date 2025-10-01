<div class="w-full">
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Explore Our Programmes
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Discover meaningful programmes across different categories designed to enrich your spiritual journey
        </p>
    </div>
    <!-- Categories Section -->
    <div class="mb-8">
        <div class="flex flex-wrap justify-center gap-2">
            @foreach($categories as $category)
                <button 
                    wire:click="selectCategory({{ $category->id }})"
                    class="capitalize group px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 ease-in-out transform hover:scale-105
                        {{ $selectedCategoryId == $category->id 
                            ? 'bg-teal-600 text-white shadow-lg' 
                            : 'bg-white text-slate-600 shadow border border-slate-600 hover:bg-teal-100/70 hover:border-slate-500' }}"
                >
                    {{ $category->name }}
                    @if($category->programmes->count() > 0)
                        <span class="ml-2 px-2 py-1 text-xs rounded-full 
                            {{ $selectedCategoryId == $category->id 
                                ? 'bg-white text-slate-600' 
                                : 'border border-slate-600 bg-teal-100 text-gray-600 group-hover:bg-white hover:border-slate-500' }}">
                            {{ $category->programmes->count() }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    <!-- Programmes Carousel Section -->
    <div class="relative">
        @if($programmes->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3zM9 5h6v2H9V5zm0 4h6v8H9V9z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-500 mb-2">No Programmes Available</h3>
                <p class="text-gray-400">There are no programmes in this category yet.</p>
            </div>
        @else
            <!-- Programmes Grid/Carousel -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6" wire:loading.class="opacity-50">
                @foreach($programmes as $programme)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden group">
                        <!-- Programme Image -->
                        <div class="relative h-48 bg-gradient-to-br from-teal-400 to-teal-600 overflow-hidden">
                            @if($programme->getFirstMediaUrl('thumbnail'))
                                <img 
                                    src="{{ $programme->getFirstMediaUrl('thumbnail') }}" 
                                    alt="{{ $programme->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                >
                            @else
                                <div class="flex items-center justify-center h-full text-white">
                                    {{-- <svg class="w-16 h-16 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg> --}}
                                    <p class="text-6xl font-normal rounded-full text-white/60 drop-shadow text-center tracking-widest">
                                        {{ Helper::getInitials($programme->title) }}
                                    </p>
                                </div>
                            @endif
                            
                            <!-- Price Badge -->
                            <div class="absolute top-3 right-3">
                                @if($programme->active_promotion)
                                    <div class="bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                        {{ $programme->discounted_price }}
                                        <span class="line-through text-teal-200 ml-1 text-xs">{{ $programme->formatted_price }}</span>
                                    </div>
                                @else
                                    <div class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                        {{ $programme->formatted_price }}
                                    </div>
                                @endif
                            </div>

                            <!-- Category Badge -->
                            @if($programme->categories->isNotEmpty())
                                <div class="absolute top-3 left-3">
                                    <span class="bg-black/20 backdrop-blur-sm text-white px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $programme->categories->first()->name }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Programme Content -->
                        <div class="p-6">
                            <!-- Title -->
                            <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2 group-hover:text-teal-600 transition-colors duration-300">
                                {{ $programme->title }}
                            </h3>

                            <!-- Excerpt -->
                            @if($programme->excerpt)
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ Str::words($programme->excerpt, 6, '...') }}
                                </p>
                            @endif

                            <!-- Programme Details -->
                            <div class="space-y-2 mb-4">
                                <!-- Date -->
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a1 1 0 01-1-1H5a1 1 0 01-1-1V8a1 1 0 011-1h3zM9 5h6v2H9V5zm0 4h6v8H9V9z"></path>
                                    </svg>
                                    <p class="truncate">
                                        {{ $programme->programme_dates }}
                                    </p>
                                </div>

                                <!-- Time -->
                                @if($programme->startTime)
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $programme->programme_times }}
                                    </div>
                                @endif

                                <!-- Location -->
                                @if($programme->address)
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="truncate capitalize">{{ $programme->location }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Speakers -->
                            {{-- @if($programme->speakers->isNotEmpty())
                                <div class="mb-4">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-700">Speakers</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($programme->speakers->take(2) as $speaker)
                                            <span class="border border-teal-500/60 bg-teal-50 text-teal-700 px-2 py-1 rounded-full text-xs font-medium">
                                                {{ $speaker->title }} {{ $speaker->name }}
                                            </span>
                                        @endforeach
                                        @if($programme->speakers->count() > 2)
                                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">
                                                +{{ $programme->speakers->count() - 2 }} more
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif --}}

                            <!-- Registration Status -->
                            <div class="mb-4">
                                @if($programme->limit && $programme->total_registrations >= $programme->limit)
                                    <div class="flex items-center gap-1 bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-lg text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                        </svg>
                                        <strong>Fully Booked</strong> - Registration closed
                                    </div>
                                @elseif($programme->limit)
                                    <div class="flex items-center gap-1 bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-lg text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                        </svg>
                                        <strong>{{ $programme->total_registrations . ' / ' . $programme->limit }}</strong> spots remaining
                                    </div>
                                @else
                                    <div class="flex items-center gap-1 bg-blue-50 border border-blue-200 text-blue-700 px-3 py-2 rounded-lg text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                        </svg>
                                        <strong>Open Registration</strong> - No limit
                                    </div>
                                @endif
                            </div>

                            <!-- Action Button -->
                            <div class="pt-2">
                                <a 
                                    href="{{ route('programme.show', $programme->programmeCode) }}" 
                                    class="w-full bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 inline-flex items-center justify-center group"
                                >
                                    <span>View Details</span>
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Loading Overlay -->
        <div wire:loading class="absolute inset-0 bg-white/75 flex items-center justify-center z-10">
            <div class="flex items-center space-x-3">
                <svg class="animate-spin h-8 w-8 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-600 font-medium">Loading programmes...</span>
            </div>
        </div>
    </div>
</div>
