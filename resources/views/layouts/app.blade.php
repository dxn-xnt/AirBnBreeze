<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'AirBnBreeze') - Find Your Perfect Stay</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/air-logo.png') }}">
    
    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-montserrat">
    <!-- Header (includes sticky search bar functionality) -->
    @if(!\Request::is('bookings*'))
        <x-layout.header />
    @endif
    
    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <x-layout.footer />
    
    <!-- Additional Scripts -->
    @stack('scripts')
    
    <!-- Lucide Icons - Only loaded once at the end of body -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
