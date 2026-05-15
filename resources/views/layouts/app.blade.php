<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#FDFDFB]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BinaSistem') }} - @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('image/logo-BinaSistem.png') }}">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="h-full text-[#1E1E1E] antialiased font-sans flex overflow-hidden" 
    x-data="{ 
        sidebarOpen: localStorage.getItem('sidebarOpen') === null ? true : localStorage.getItem('sidebarOpen') === 'true', 
        mobileMenuOpen: false,
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebarOpen', this.sidebarOpen);
        }
    }">
    
    @include('sweetalert::alert')

    <!-- Sidebar Component -->
    @include('components.sidebar')

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FDFDFB] sidebar-transition"
        :class="sidebarOpen ? 'ml-72' : 'ml-20'">
        
        <!-- Topbar Component -->
        @include('components.topbar')

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-8 lg:p-12">
            <div class="max-w-[1400px] mx-auto">
                @yield('content')
            </div>
        </main>

        <!-- Footer Component -->
        @include('components.footer')

    </div>

    @stack('scripts')
</body>
</html>
