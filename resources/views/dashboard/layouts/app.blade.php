<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f6f8;
            font-family: sans-serif;
        }

        .dashboard-app {
            width: 100%;
            max-width: 480px;
            min-height: 100vh;

            margin: auto;

            background: #fff;

            position: relative;

            padding-bottom: 90px;
        }

        /* TOPBAR */
        .topbar {
            position: sticky;
            top: 0;

            z-index: 1000;

            background: #fff;

            padding: 16px;

            border-bottom: 1px solid #eee;
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 700;
        }

        .topbar-subtitle {
            font-size: 12px;
            color: #777;
        }

        /* SECTION */
        .section {
            padding: 16px;
        }

        /* CARD */
        .card-box {
            background: #fff;

            border-radius: 14px;

            padding: 14px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* STATS */
        .stat-card {
            background: #fff;

            border-radius: 14px;

            padding: 15px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);

            height: 100%;
        }

        .stat-icon {
            width: 45px;
            height: 45px;

            border-radius: 12px;

            background: #eef4ff;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 10px;

            color: #2c7be5;

            font-size: 20px;
        }

        .stat-number {
            font-size: 22px;
            font-weight: 700;
        }

        .stat-label {
            font-size: 12px;
            color: #777;
        }

        /* MENU CARD */
        .menu-card {
            display: flex;
            align-items: center;
            justify-content: space-between;

            text-decoration: none;
            color: #222;

            background: #fff;

            border-radius: 14px;

            padding: 14px;

            margin-bottom: 10px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .menu-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-icon {
            width: 42px;
            height: 42px;

            border-radius: 12px;

            background: #eef4ff;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #2c7be5;

            font-size: 18px;
        }

        /* BOTTOM NAV */
        .bottom-nav {
            position: fixed;

            bottom: 0;
            left: 50%;

            transform: translateX(-50%);

            width: 100%;
            max-width: 480px;

            background: #fff;

            border-top: 1px solid #eee;

            display: flex;
            justify-content: space-around;
            align-items: center;

            padding: 10px 0;

            z-index: 999;
        }

        .bottom-nav::before {
            content: "";

            position: absolute;

            top: -20px;
            left: 0;

            width: 100%;
            height: 20px;

            background: linear-gradient(to top,
                    rgba(255, 255, 255, 1),
                    rgba(255, 255, 255, 0));
        }

        .nav-item {
            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            text-decoration: none;

            color: #888;

            font-size: 11px;

            gap: 3px;
        }

        .nav-item i {
            font-size: 19px;
        }

        .nav-item.active {
            color: #2c7be5;
            font-weight: 600;
        }

        /* PROPERTY ITEM */
        .property-item {
            border-bottom: 1px solid #f1f1f1;

            padding: 10px 0;
        }

        .property-item:last-child {
            border-bottom: none;
        }

        .property-title {
            font-size: 14px;
            font-weight: 600;
        }

        .property-location {
            font-size: 12px;
            color: #777;
        }

        /* BUTTON */
        .btn-primary {
            background: #2c7be5;
            border: none;
        }

        .btn-primary:hover {
            background: #1b68d1;
        }

        /* FORM */
        .form-control {
            border-radius: 10px;
            min-height: 45px;
        }

        textarea.form-control {
            min-height: 120px;
        }
    </style>
</head>

<body>

    <div class="dashboard-app">

        {{-- TOPBAR --}}
        <div class="topbar d-flex justify-content-between align-items-center">

            <div>

                <div class="topbar-title">
                    @yield('title')
                </div>

                <div class="topbar-subtitle">
                    Admin Dashboard
                </div>

            </div>

            <div>
                <i class="bi bi-bell"
                    style="font-size:20px;"></i>
            </div>

        </div>

        {{-- CONTENT --}}
        @yield('content')

    </div>

    {{-- BOTTOM NAV --}}
    <div class="bottom-nav">

        <a href="/dashboard"
            class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">

            <i class="bi bi-grid-fill"></i>

            <span>Home</span>

        </a>

        <a href="/dashboard/properties"
            class="nav-item {{ request()->is('dashboard/properties*') ? 'active' : '' }}">

            <i class="bi bi-house-door-fill"></i>

            <span>Properti</span>

        </a>

        <a href="/dashboard/articles"
            class="nav-item {{ request()->is('dashboard/articles*') ? 'active' : '' }}">

            <i class="bi bi-newspaper"></i>

            <span>Artikel</span>

        </a>

        <a href="/dashboard/settings"
            class="nav-item {{ request()->is('dashboard/settings*') ? 'active' : '' }}">

            <i class="bi bi-gear-fill"></i>

            <span>Setting</span>

        </a>

    </div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@stack('scripts')   
</body>

</html>