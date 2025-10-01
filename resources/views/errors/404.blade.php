@section('title', '404 - Page Not Found')
<x-guest-layout>
    <div class="relative min-h-screen bg-gradient-to-b from-white via-teal-100 to-teal-100/30">
        <div class="max-w-2xl mx-auto text-center">
            <!-- 404 Number -->
            <div class="mb-8">
                <h1 class="text-9xl md:text-[12rem] font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-teal-800 drop-shadow-lg">
                    404
                </h1>
            </div>

            <!-- Error Message -->
            <div class="mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Oops! Page Not Found
                </h2>
                <p class="text-lg text-gray-600 max-w-md mx-auto">
                    The page you're looking for seems to have wandered off. It might have been moved, deleted, or perhaps never existed.
                </p>
            </div>

            <!-- Decorative Icon -->
            <div class="mb-10 flex justify-center">
                <div class="relative">
                    <div class="w-48 h-48 md:w-64 md:h-64">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-48 h-48 md:w-64 md:h-64 text-teal-700/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a 
                    href="{{ route('frontpage') }}" 
                    class="inline-flex items-center px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Go to Homepage
                </a>
                
                <button 
                    onclick="window.history.back()" 
                    class="inline-flex items-center px-8 py-3 bg-white border-2 border-teal-600 text-teal-600 font-semibold rounded-full shadow-md hover:bg-teal-50 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Go Back
                </button>
            </div>

            <!-- Helpful Links -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-4">You might find what you're looking for here:</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('frontpage') }}" class="text-teal-600 hover:text-teal-700 hover:underline transition-colors">
                        Events
                    </a>
                    @auth
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('admin.programmes') }}" class="text-teal-600 hover:text-teal-700 hover:underline transition-colors">
                            Dashboard
                        </a>
                    @else
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('login') }}" class="text-teal-600 hover:text-teal-700 hover:underline transition-colors">
                            Login
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('register') }}" class="text-teal-600 hover:text-teal-700 hover:underline transition-colors">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <x-footer-public />
</x-guest-layout>

