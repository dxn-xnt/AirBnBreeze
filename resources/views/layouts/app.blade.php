<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title', 'AirBnBreeze') - Find Your Perfect Stay</title>

    <!-- Favicon Configuration -->
    <link rel="shortcut icon" href="{{ asset('assets/images/air-logo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('assets/images/air-logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/air-logo.png') }}">

    <!-- Preload Favicon for better performance -->
    <link rel="preload" href="{{ asset('assets/images/air-logo.png') }}" as="image">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-montserrat">
<!-- Header (includes sticky search bar functionality) -->

@if(\Request::is('host*'))
    <x-layout.host-header />      
@elseif(!\Request::is('bookings*'))
    <x-layout.header />
@else
    <x-layout.bookings-header />
@endif
<!-- Page Content -->
<main>
    @yield('content')
</main>

<!-- Additional Scripts -->
@stack('scripts')

<!-- Alpine.js Core - Load first -->
<script src="https://unpkg.com/alpinejs@3.13.0/dist/cdn.min.js" defer></script>

<!-- Lucide Icons - Load after Alpine -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // Initialize Lucide and refresh when Alpine updates
    document.addEventListener('alpine:init', () => {
        // Initial icon creation
        lucide.createIcons();

        // Refresh icons after Alpine updates
        document.addEventListener('alpine:init', () => {
            // Your initialization code here
        });
    });
</script>
</body>
</html>
