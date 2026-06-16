<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('meta')
    <title>Properti Bandung</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/calculator.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    
    @stack('styles')
</head>

<body>

    <div class="app-container">

        @yield('content')

    </div>

    {{-- BOTTOM NAV --}}
    <div class="bottom-nav">
        <a href="/" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi {{ request()->routeIs('home') ? 'bi-grid-fill' : 'bi-grid' }}"></i>
            <span>Home</span>
        </a>

        <a href="{{ route('property') }}" class="nav-item {{ request()->routeIs('property') ? 'active' : '' }}">
            <i class="bi {{ request()->routeIs('property') ? 'bi-houses-fill' : 'bi-houses' }}"></i>
            <span>Properti</span>
        </a>

        <a href="{{ route('kpr.index') }}r" class="nav-item nav-item-center {{ request()->routeIs('kpr.index') ? 'active' : '' }}">
            <i class="bi {{ request()->routeIs('kpr.index') ? 'bi-calculator-fill' : 'bi-calculator' }}"></i>
            <span>KPR</span>
        </a>

        <a href="{{ route('article') }}" class="nav-item {{ request()->routeIs('article') ? 'active' : '' }}">
            <i class="bi {{ request()->routeIs('article') ? 'bi-collection-fill' : 'bi-collection' }}"></i>
            <span>Artikel</span>
        </a>

        {{-- ACCOUNT --}}
        <a href="{{ auth()->check() ? '/account' : '/login' }}" class="nav-item {{ request()->is('account') || request()->is('login') ? 'active' : '' }}">
            <i class="bi {{ request()->is('account') || request()->is('login') ? 'bi-person-fill' : 'bi-person' }}"></i>
            <span>Akun</span>
        </a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    @stack('scripts')
</body>

</html>