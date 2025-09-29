<nav 
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
        'md:fixed top-0 left-0 right-0 z-50 transform translate-y-0 py-3 bg-white/95 backdrop-blur-md shadow-lg': isFixed && !isMobile,
        'relative py-6 bg-zinc-50 shadow': !isFixed || isMobile
    }"
    class="w-full px-4 transition-all duration-500 ease-in-out {{ Route::is('frontpage') ? 'border-b border-slate-400/30' : '' }}"
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
        <div class="hidden md:flex items-center space-x-4">
            @auth()
                <a 
                    href="{{ route('admin.programmes') }}" 
                    :class="{ 'px-4 py-1.5 text-xs': isFixed && !isMobile, 'px-5 py-2 text-xs': !isFixed || isMobile }"
                    class="bg-orange-1/80 text-white drop-shadow-sm rounded-full shadow-md hover:text-neutral-200 hover:bg-orange-1 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                >
                    Dashboard
                </a>
            
            @endauth
            @guest()
                <a 
                    href="{{ route('login') }}" 
                    :class="{ 'px-4 py-1.5 text-xs': isFixed && !isMobile, 'px-5 py-2 text-xs': !isFixed || isMobile }"
                    class="bg-orange-2/80 text-white drop-shadow-sm rounded-full shadow-md hover:text-neutral-200 hover:bg-orange-2 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                >
                    Login
                </a>
                <a 
                    href="{{ route('register') }}" 
                    :class="{ 'px-4 py-1.5 text-xs': isFixed && !isMobile, 'px-5 py-2 text-xs': !isFixed || isMobile }"
                    class="bg-orange-1/80 text-white drop-shadow-sm rounded-full shadow-md hover:text-neutral-200 hover:bg-orange-1 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 ease-in-out"
                >
                    Sign Up
                </a>
            @endguest
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div 
        {{-- :class="{ 'bottom-0': isFixed }" --}}
        class="z-9999 fixed bottom-0 left-0 right-0 bg-slate-500 shadow-lg md:hidden lg:hidden">
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
