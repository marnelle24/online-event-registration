<x-guest-layout>
    @section('title', $programme->title)
    
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Programme Header -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                @if($programme->getFirstMediaUrl('banner'))
                    <div class="h-64 md:h-80 bg-cover bg-center" style="background-image: url('{{ $programme->getFirstMediaUrl('banner') }}')"></div>
                @endif
                
                <div class="p-6 md:p-8">
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        @foreach($programme->categories as $category)
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $programme->title }}</h1>
                    
                    @if($programme->excerpt)
                        <p class="text-lg text-gray-600 mb-6">{{ $programme->excerpt }}</p>
                    @endif
                    
                    <!-- Programme Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Date & Time -->
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-orange-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a1 1 0 01-1-1H5a1 1 0 01-1-1V8a1 1 0 011-1h3zM9 5h6v2H9V5zm0 4h6v8H9V9z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Date & Time</h3>
                                <p class="text-gray-600">{{ $programme->programme_dates }}</p>
                                @if($programme->startTime)
                                    <p class="text-gray-600">{{ $programme->programme_times }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Location -->
                        @if($programme->address)
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-orange-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Location</h3>
                                    <p class="text-gray-600">{{ $programme->location }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Price -->
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-orange-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Price</h3>
                                @if($programme->active_promotion)
                                    <p class="text-green-600 font-bold">{{ $programme->discounted_price }}</p>
                                    <p class="text-gray-500 line-through text-sm">{{ $programme->formatted_price }}</p>
                                @else
                                    <p class="text-gray-600 font-bold">{{ $programme->formatted_price }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Ministry -->
                        @if($programme->ministry)
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-orange-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Ministry</h3>
                                    <p class="text-gray-600">{{ $programme->ministry->name }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Register Button -->
                    <div class="flex justify-center">
                        <button class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                            Register Now
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Programme Description -->
            @if($programme->description)
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Programme</h2>
                    <div class="prose prose-lg max-w-none text-gray-700">
                        {!! $programme->description !!}
                    </div>
                </div>
            @endif
            
            <!-- Speakers -->
            @if($programme->speakers->isNotEmpty())
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Speakers</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($programme->speakers as $speaker)
                            <div class="text-center">
                                @if($speaker->getFirstMediaUrl('speaker'))
                                    <img src="{{ $speaker->getFirstMediaUrl('speaker') }}" alt="{{ $speaker->name }}" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                                @else
                                    <div class="w-24 h-24 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500 text-lg font-bold">{{ \App\Helpers\Helper::getInitials($speaker->name) }}</span>
                                    </div>
                                @endif
                                <h3 class="font-semibold text-gray-900">{{ $speaker->title }} {{ $speaker->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $speaker->profession }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
