<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('assets/css/dashboard/app.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">

    @stack('styles')
</head>

<body>
    <div class="dashboard-app">

        {{-- TOPBAR --}}
        <div class="topbar d-flex justify-content-between align-items-center animated-gradient">
            <div>
                <div class="topbar-title">
                    @yield('title')
                </div>
                <div class="topbar-subtitle">
                    Agent Dashboard
                </div>
            </div>
            <div>
                <i class="bi bi-bell" style="font-size:20px;"></i>
            </div>
        </div>

        <div class="section pb-0">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </div>

        {{-- CONTENT --}}
        @yield('content')

    </div>

    {{-- BOTTOM NAV --}}
    <div class="bottom-nav">
        <a href="{{ route('agent.dashboard') }}" class="nav-item {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
            <i class="bi {{ request()->routeIs('agent.dashboard') ? 'bi-grid-fill' : 'bi-grid' }}"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('agent.properties.index') }}" class="nav-item {{ request()->routeIs('agent.properties.index*') ? 'active' : '' }}">
            <i class="bi {{ request()->routeIs('agent.properties.index') ? 'bi-houses-fill' : 'bi-houses' }}"></i>
            <span>Properti</span>
        </a>
        <a href="{{ route('agent.settings') }}" class="nav-item {{ request()->routeIs('agent.settings*') ? 'active' : '' }}">
            <i class="bi {{ request()->routeIs('agent.settings') ? 'bi-gear-fill' : 'bi-gear' }}"></i>
            <span>Setting</span>
        </a>
    </div>

    @stack('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</body>

</html>