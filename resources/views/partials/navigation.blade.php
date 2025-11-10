<nav 
    x-cloak
    x-data="{ 
        isFixed: false,
        ticking: false,
        isMobile: false,
        init() {
            this.checkMobile();
            this.handleScroll();
            if (!this.isMobile) {
                window.addEventListener('scroll', () => this.requestTick());
                window.addEventListener('resize', () => this.checkMobile());
            }
        },
        checkMobile() {
            this.isMobile = window.innerWidth < 768; // md breakpoint - tablets and up get fixed header
            if (this.isMobile) {
                this.isFixed = false; // Reset to normal state on mobile
            }
        },
        requestTick() {
            if (!this.ticking && !this.isMobile) {
                requestAnimationFrame(() => this.handleScroll());
                this.ticking = true;
            }
        },
        handleScroll() {
            if (this.isMobile) {
                this.ticking = false;
                return;
            }
            
            const scrollThreshold = window.innerHeight * 0.10; // 10% of window height
            const shouldBeFixed = window.scrollY >= scrollThreshold;
            
            if (this.isFixed !== shouldBeFixed) {
                this.isFixed = shouldBeFixed;
            }
            
            this.ticking = false;
        }
    }"
    :class="{
        'md:fixed top-0 left-0 right-0 z-50 transform translate-y-0 py-3 bg-zinc-50/60 backdrop-blur-md': isFixed && !isMobile,
        'relative py-6 bg-zinc-50/60': !isFixed || isMobile
    }"
    class="shadow-lg w-full px-4 transition-all duration-500 ease-in-out border-b border-slate-400/30"
    {{-- class="shadow-lg w-full px-4 transition-all duration-500 ease-in-out {{ Route::is('frontpage') ? 'border-b border-slate-400/30' : '' }}" --}}
>
    <div 
        class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between"
        :class="{ 'py-1': isFixed && !isMobile, 'py-0': !isFixed || isMobile }"
    >
        <!-- Logo -->
        <div class="first-line:mb-4 md:mb-0">
            <a href="/" class="flex items-center">
                <img 
                    src="{{ asset('logo.png') }}" 
                    alt="Logo" 
                    :class="{ 'h-5': isFixed && !isMobile, 'h-6': !isFixed || isMobile }"
                    class="w-auto transition-all duration-300 ease-in-out"
                >
                <span 
                    :class="{ 
                        'xl:text-2xl text-2xl': isFixed && !isMobile, 
                        'xl:text-3xl text-3xl': !isFixed || isMobile 
                    }"
                    class="ml-2 font-extrabold drop-shadow text-gray-800 font-nunito transition-all duration-300 ease-in-out"
                >
                    Streams of Life
                </span>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-2">
            @auth()
                <ul class="flex items-center">
                    <li>
                        <a 
                            href="{{ route('admin.programmes') }}" 
                            :class="{ 'px-4 py-1.5': isFixed && !isMobile, 'px-5 py-2': !isFixed || isMobile }"
                            class="text-teal-600 drop-shadow-sm hover:text-teal-700 hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                        >
                            Home
                        </a>
                    </li>
                    <li>
                        <a 
                            href="{{ route('admin.dashboard') }}" 
                            :class="{ 'px-4 py-1.5': isFixed && !isMobile, 'px-5 py-2': !isFixed || isMobile }"
                            class="text-teal-600 drop-shadow-sm hover:text-teal-700 hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                        >
                            Events
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('frontpage') }}" class="text-teal-600 drop-shadow-sm hover:text-teal-700 hover:-translate-y-0.5 transition-all duration-300 ease-in-out">
                            Courses
                        </a>
                    </li>
                </ul>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button 
                        type="submit"
                        :class="{ 'px-4 py-1.5 text-xs': isFixed && !isMobile, 'px-5 py-2 text-xs': !isFixed || isMobile }"
                        class="flex items-center space-x-1 text-teal-600 drop-shadow-sm rounded-full uppercase tracking-wider font-light hover:text-teal-700 hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            @endauth
            @guest()
                <a 
                    href="{{ route('login') }}" 
                    :class="{ 'px-4 py-1.5 text-xs': isFixed && !isMobile, 'px-5 py-2 text-xs': !isFixed || isMobile }"
                    class="uppercase tracking-wider hover:bg-transparent bg-teal-600/80 border border-teal-600/80 text-white drop-shadow-sm rounded-full shadow-md hover:text-teal-600 hover:bg-teal-2 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                >
                    Login
                </a>
                <a 
                    href="{{ route('register') }}" 
                    :class="{ 'px-4 py-1.5 text-xs': isFixed && !isMobile, 'px-5 py-2 text-xs': !isFixed || isMobile }"
                    class="hover:bg-transparent uppercase tracking-wider bg-teal-700/80 border border-teal-700/80 text-white drop-shadow-sm rounded-full shadow-md hover:text-teal-600 hover:bg-teal-2 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                >
                    Sign Up
                </a>
            @endguest
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div 
        {{-- :class="{ 'bottom-0': isFixed }" --}}
        class="z-99 fixed bottom-0 left-0 right-0 bg-teal-900/90 shadow-lg md:hidden lg:hidden">
        <div class="flex justify-around py-4">
            <a href="/" class="flex flex-col items-center text-white group">
                <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-slate-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs mt-1 group-hover:text-teal-200 group-hover:-translate-y-0.5 duration-300">Home</span>
            </a>
            
            @auth
                <!-- Dashboard -->
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-teal-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-teal-200 group-hover:-translate-y-0.5 duration-300">Dashboard</span>
                </a>
                
                <!-- Events -->
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-teal-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-teal-200 group-hover:-translate-y-0.5 duration-300">Events</span>
                </a>
                
                <!-- Courses -->
                <a href="{{ route('frontpage') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-teal-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-teal-200 group-hover:-translate-y-0.5 duration-300">Courses</span>
                </a>
                
                <!-- Mobile Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center">
                    @csrf
                    <button type="submit" class="flex flex-col items-center text-white group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-red-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-xs mt-1 group-hover:text-red-200 group-hover:-translate-y-0.5 duration-300">Logout</span>
                    </button>
                </form>
            @endauth
            
            @guest
                <!-- Events for guests -->
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-teal-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-teal-200 group-hover:-translate-y-0.5 duration-300">Events</span>
                </a>
                
                <!-- Courses for guests -->
                <a href="{{ route('frontpage') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-teal-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-teal-200 group-hover:-translate-y-0.5 duration-300">Courses</span>
                </a>
                
                <a href="{{ route('login') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-teal-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-teal-200 group-hover:-translate-y-0.5 duration-300">Login</span>
                </a>
                <a href="{{ route('register') }}" class="flex flex-col items-center text-white group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:-translate-y-0.5 duration-300 group-hover:stroke-teal-300 stroke-white h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="text-xs mt-1 group-hover:text-teal-200 group-hover:-translate-y-0.5 duration-300">Sign Up</span>
                </a>
            @endguest
        </div>
    </div>
</nav>
