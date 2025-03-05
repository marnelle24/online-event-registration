<nav class="z-999 px-4 w-full bg-zinc-50 transition-all duration-400 ease-in-out py-6 shadow {{ Route::is('frontpage') ? 'border-b border-slate-400/30 py-6' : '' }}">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between">
        <!-- Logo -->
        <div class="first-line:mb-4 md:mb-0">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-6 w-auto">
                <span class="ml-2 xl:text-3xl text-3xl font-extrabold drop-shadow text-gray-800 font-nunito">Streams of Life</span>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-4">
            @auth()
                <a href="{{ '#' }}" class="px-5 py-2 bg-orange-1/80 text-white text-xs drop-shadow-sm rounded-full shadow-md hover:text-neutral-200 hover:bg-orange-1 hover:shadow-lg hover:-translate-y-0.5 transition duration-300 ease-in-out">
                    Dashboard
                </a>
            
            @endauth
            @guest()
                <a href="{{ route('login') }}" class="px-5 py-2 bg-orange-2/80 text-white text-xs drop-shadow-sm rounded-full shadow-md hover:text-neutral-200 hover:bg-orange-2 hover:shadow-lg hover:-translate-y-0.5 transition duration-300 ease-in-out">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2 bg-orange-1/80 text-white text-xs drop-shadow-sm rounded-full shadow-md hover:text-neutral-200 hover:bg-orange-1 hover:shadow-lg hover:-translate-y-0.5 transition duration-300 ease-in-out">
                    Sign Up
                </a>
            @endguest
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="z-9999 fixed bottom-0 left-0 right-0 bg-slate-500 shadow-lg md:hidden">
        <div class="flex justify-around py-4">
            <a href="/" class="flex flex-col items-center text-white group">
                <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-slate-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs mt-1 group-hover:text-slate-200 group-hover:-translate-y-0.5 duration-300">Home</span>
            </a>
            @guest
                <a href="{{ route('login') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-slate-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-slate-200 group-hover:-translate-y-0.5 duration-300">Login</span>
                </a>
                <a href="{{ route('register') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-slate-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-slate-200 group-hover:-translate-y-0.5 duration-300">Sign Up</span>
                </a>
            @endguest
        </div>
    </div>
</nav>
