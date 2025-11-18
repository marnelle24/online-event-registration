<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | Streams of Life Registration</title>
        {{-- <title>{{ config('app.name', 'Streams of Life') }}</title> --}}

        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

        <style>
            html {
                scroll-behavior: smooth;
            }
            @media print {
                .no-print {
                    display: none !important;
                }
                body {
                    background: white !important;
                }
                .print-container {
                    box-shadow: none !important;
                    border: none !important;
                }
            }
        </style>

        <!-- Styles -->
        @livewireStyles

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        @stack('styles')
    </head>
    <body class="antialiased bg-white">
        
        @if (!request()->routeIs('login') && !request()->routeIs('register'))
            @include('partials.navigation')
            <!-- Navigation Spacer - prevents content jump when nav becomes fixed -->
            <div 
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
                :class="{ 'md:h-20': isFixed && !isMobile, 'h-0': !isFixed || isMobile }"
                class="transition-all duration-500 ease-in-out no-print"
            ></div>
        @endif
        <main>
            {{ $slot }}
        </main>

        @livewireScripts
        @stack('script')
    </body>
    
</html>
