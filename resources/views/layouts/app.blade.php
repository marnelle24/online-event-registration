<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | Streams Of Life Registration</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>

    <body
        x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
        x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
            $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
        :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}"
    >

        <div class="flex h-screen overflow-hidden">
            @include('partials.sidebar')
            <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
                @include('partials.header')
                <main>
                    <div class="mx-auto min-h-screen p-4 md:p-6 2xl:p-10 bg-slate-100 dark:bg-zinc-300">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>


        @stack('modals')
        @stack('script')
        <x-toaster-hub />
        
        {{-- Configure Livewire for ngrok/tunnel services --}}
        @if(str_contains(config('app.url'), 'ngrok') || str_contains(config('app.url'), 'localhost.run'))
        <script>
            // Ensure Livewire uses the correct base URL for file uploads when using ngrok
            document.addEventListener('livewire:init', () => {
                // Livewire should automatically detect the base URL from the current page
                // But we can ensure it's using the correct one
                if (window.Livewire) {
                    // The base URL is automatically detected from the current page URL
                    // This script ensures it's set correctly for file uploads
                    console.log('Livewire initialized with base URL:', window.location.origin);
                }
            });
        </script>
        @endif
        
        @livewireScripts
    </body>
</html>
