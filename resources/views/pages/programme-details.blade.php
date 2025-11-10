<x-guest-layout>
    @section('title', $programme->title)
    
    {{-- <div class="relative min-h-screen bg-gradient-to-b bg-white"> --}}
    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-100/70 to-white/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Programme Header -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                @if($programme->getFirstMediaUrl('banner'))
                    <div class="h-96 md:h-80 bg-cover bg-center border-b border-slate-400/70 bg-teal-900/30" style="background-image: url('{{ $programme->getFirstMediaUrl('banner') }}')"></div>
                @endif
                
                <div class="p-6 md:p-8">
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        @foreach($programme->categories as $category)
                            <span class="bg-teal-100/70 capitalize text-teal-800 px-3 border border-teal-800/70 py-1 rounded-full text-sm font-medium">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">{{ $programme->title }}</h1>
                    
                    @if($programme->excerpt)
                        <p class="text-lg text-slate-600 mb-6">{{ $programme->excerpt }}</p>
                    @endif
                    
                    <!-- Programme Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Date & Time -->
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-teal-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a1 1 0 01-1-1H5a1 1 0 01-1-1V8a1 1 0 011-1h3zM9 5h6v2H9V5zm0 4h6v8H9V9z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-slate-900">Date & Time</h3>
                                <p class="text-slate-600">{{ $programme->programme_dates }}</p>
                                @if($programme->startTime)
                                    <p class="text-slate-600">{{ $programme->programme_times }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Location -->
                        @if($programme->address)
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-teal-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-slate-900">Location</h3>
                                    <p class="text-slate-600">{{ $programme->location }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Price -->
                        <div class="flex items-start space-x-3">
                            {{-- <svg class="text-teal-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg> --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-teal-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            <div>
                                <h3 class="font-semibold text-slate-900">Price</h3>
                                @if($programme->active_promotion)
                                    <div class="flex gap-1 items-center">
                                        <p class="text-green-600 font-bold text-lg">
                                            {{ $programme->discounted_price }}
                                        </p>
                                        <p class="text-green-700 text-sm font-medium capitalize italic">
                                            ({{ $programme->active_promotion->title }})
                                        </p>
                                    </div>
                                    <p class="text-slate-500 line-through text-md">
                                        {{ $programme->formatted_price }}
                                    </p>
                                @else
                                    <p class="text-slate-600 font-bold text-lg">{{ $programme->formatted_price }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Ministry -->
                        @if($programme->ministry)
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-teal-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-slate-900">Ministry</h3>
                                    <p class="text-slate-600">{{ $programme->ministry->name }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <br />
                    <br />
                    <!-- Register Button -->
                    <div class="flex justify-center">
                        <a href="{{ route('programme.register', $programme->programmeCode) }}" class="uppercase font-thin tracking-widest bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white py-4 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            Register Now
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Programme Description -->
            @if($programme->description)
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
                    <h2 class="text-md uppercase tracking-widest font-bold text-teal-500 mb-4">About This Programme</h2>
                    <div class="prose prose-lg max-w-none text-slate-700">
                        {!! $programme->description !!}
                    </div>
                </div>
            @endif
            
            <!-- Breakout Sessions Timeline -->
            @if($programme->breakouts->where('isActive', true)->isNotEmpty())
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">Breakout Sessions Timeline</h2>
                        <p class="text-slate-600">Follow the journey through our specialized workshops and discussions</p>
                    </div>
                    
                    <!-- Timeline Container -->
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute left-8 md:left-1/2 transform md:-translate-x-px top-0 bottom-0 w-0.5 bg-gradient-to-b from-teal-400 via-teal-500 to-teal-600"></div>
                        
                        <!-- Timeline Items -->
                        <div class="space-y-8">
                            @foreach($programme->breakouts->where('isActive', true)->sortBy('startDate') as $index => $breakout)
                                <div class="relative flex items-center {{ $index % 2 == 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                                    <!-- Timeline Dot -->
                                    <div class="absolute left-8 md:left-1/2 transform -translate-x-1/2 w-4 h-4 bg-teal-500 border-4 border-white rounded-full shadow-lg z-10"></div>
                                    
                                    <!-- Content Card -->
                                    <div class="ml-12 md:ml-0 {{ $index % 2 == 0 ? 'md:mr-8 md:-ml-3 md:w-1/2' : 'md:ml-8 md:-mr-3 md:w-1/2' }}">
                                        <div class="bg-gradient-to-br from-white to-slate-50 border border-slate-200 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                            <!-- Date Badge -->
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="bg-teal-100 text-teal-800 px-3 py-1 border border-teal-800/30 rounded-full text-xs font-semibold">
                                                    {{ \Carbon\Carbon::parse($breakout->startDate)->format('M j h:i A') }}
                                                    @if($breakout->startDate != $breakout->endDate && $breakout->endDate)
                                                        - {{ \Carbon\Carbon::parse($breakout->endDate)->format('M j h:i A') }}
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Session Title -->
                                            <h3 class="text-xl font-bold text-slate-900">{{ $breakout->title }}</h3>
                                            
                                            <!-- Description -->
                                            @if($breakout->description)
                                                <p class="text-slate-500 italic text-xs mb-2 leading-tight">{{ Str::words($breakout->description, 10, '...') }}</p>
                                            @endif
                                            
                                            <!-- Session Details -->
                                            <div class="space-y-3 mb-4">
                                                <!-- Location -->
                                                {{-- @if($breakout->location)
                                                    <div class="flex items-center text-sm text-slate-500">
                                                        <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-6">
                                                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="font-medium">{{ $breakout->location }}</span>
                                                    </div>
                                                @endif
                                                 --}}
                                                <!-- Speaker -->
                                                @if($breakout->speaker)
                                                    <div class="flex items-center">
                                                        <div class="flex items-center space-x-3">
                                                            @if($breakout->speaker->getFirstMediaUrl('speaker'))
                                                                <img src="{{ $breakout->speaker->getFirstMediaUrl('speaker') }}" alt="{{ $breakout->speaker->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-slate-500">
                                                            @else
                                                                <div class="w-8 h-8 rounded-full bg-teal-200 flex items-center justify-center border-2 border-teal-300">
                                                                    <span class="text-teal-700 text-sm font-bold">{{ \App\Helpers\Helper::getInitials($breakout->speaker->name) }}</span>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <p class="font-semibold text-slate-900 text-sm">{{ $breakout->speaker->title }} {{ $breakout->speaker->name }}</p>
                                                                <p class="text-xs text-slate-500 italic">{{ $breakout->speaker->profession }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Session Number -->
                                            <div class="flex lg:flex-row flex-col lg:justify-between justify-start lg:items-center items-start gap-2 pt-3 border-t border-slate-200">
                                                {{-- <span class="text-xs text-slate-400 font-medium uppercase tracking-wider">Session {{ $index + 1 }}</span> --}}
                                                <!-- Price Badge -->
                                                @if($breakout->price > 0)
                                                    <div class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                        SGD {{ number_format($breakout->price, 2) }}
                                                    </div>
                                                {{-- @else
                                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                        Free
                                                    </div> --}}
                                                @endif
                                                @if($breakout->price > 0)
                                                    <span class="text-xs text-red-600 font-medium">Registration customisable per-session</span>
                                                @else
                                                    <span class="text-xs text-green-600 font-medium">Included in main programme</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Timeline Footer -->
                    <div class="mt-12 text-center">
                        {{-- <div class="inline-flex items-center space-x-2 bg-gradient-to-r from-teal-50 to-teal-100 border border-teal-200 rounded-full px-6 py-3">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-teal-800">
                                {{ $programme->breakouts->where('isActive', true)->count() }} specialized sessions designed to enhance your experience
                            </span>
                        </div> --}}
                    </div>
                </div>
            @endif

            <!-- Speakers -->
            @if($programme->speakers->isNotEmpty())
                @php
                    // Group speakers by ID to avoid duplicates
                    $uniqueSpeakers = $programme->speakers->unique('id');
                @endphp
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Speakers</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($uniqueSpeakers as $speaker)
                            <div class="text-center">
                                @if($speaker->getFirstMediaUrl('speaker'))
                                    <img src="{{ $speaker->getFirstMediaUrl('speaker') }}" alt="{{ $speaker->name }}" class="w-24 h-24 border border-slate-300 shadow-lg rounded-full mx-auto mb-4 object-cover">
                                @else
                                    <div class="w-24 h-24 rounded-full mx-auto mb-4 bg-slate-200 flex items-center justify-center">
                                        <span class="text-slate-500 text-lg font-bold">{{ \App\Helpers\Helper::getInitials($speaker->name) }}</span>
                                    </div>
                                @endif
                                <h3 class="font-semibold text-slate-900">{{ $speaker->title }} {{ $speaker->name }}</h3>
                                <p class="text-slate-600 text-sm">{{ $speaker->profession }}</p>
                                
                                <!-- Show speaker roles/types if available -->
                                @php
                                    // Get all the roles/types this speaker has in this programme
                                    $speakerRoles = $programme->speakers->where('id', $speaker->id)->pluck('pivot.type')->filter()->unique();
                                @endphp
                                @if($speakerRoles->isNotEmpty())
                                    <div class="mt-2 flex flex-wrap justify-center gap-1">
                                        @foreach($speakerRoles as $role)
                                            <span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full text-xs font-medium border border-teal-300">
                                                {{ ucfirst($role) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    <x-footer-public />
</x-guest-layout>
