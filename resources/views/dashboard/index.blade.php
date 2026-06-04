@extends('dashboard.layouts.app')

@section('content')

<style>
    body {
        background: #f5f6f8;
        font-family: sans-serif;
    }

    .dashboard-container {
        max-width: 480px;
        margin: auto;
        min-height: 100vh;
        background: #fff;
        padding-bottom: 30px;
    }

    .topbar {
        padding: 20px 15px;
        border-bottom: 1px solid #eee;
    }

    .topbar h5 {
        margin: 0;
        font-weight: 700;
    }

    .section {
        padding: 15px;
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        height: 100%;
    }

    .stat-icon {
        font-size: 22px;
        margin-bottom: 10px;
        color: #2c7be5;
    }

    .stat-number {
        font-size: 22px;
        font-weight: bold;
    }

    .stat-label {
        font-size: 12px;
        color: #777;
    }

    .menu-card {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 14px;
        border-radius: 12px;
        background: #fff;
        margin-bottom: 10px;

        text-decoration: none;
        color: #222;

        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .menu-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .menu-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #eef4ff;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #2c7be5;
        font-size: 18px;
    }

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
</style>
</head>

<body>

    <div class="dashboard-container">

        {{-- TOPBAR --}}
        <div class="topbar">
            <h5>Dashboard</h5>
            <small class="text-muted">
                Selamat datang 👋
            </small>
        </div>

        {{-- STATS --}}
        <div class="section">

            <div class="row g-3">

                <div class="col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-house-door"></i>
                        </div>

                        <div class="stat-number">
                            {{ $totalProperties }}
                        </div>

                        <div class="stat-label">
                            Total Properti
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-star"></i>
                        </div>

                        <div class="stat-number">
                            {{ $featuredProperties }}
                        </div>

                        <div class="stat-label">
                            Properti Unggulan
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-newspaper"></i>
                        </div>

                        <div class="stat-number">
                            {{ $totalArticles }}
                        </div>

                        <div class="stat-label">
                            Artikel
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="section">
            <div class="fw-bold mb-3">
                Statistik Properti
            </div>

            <div class="row">

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h6>Total Properti</h6>
                            <h2>{{ number_format($totalProperties) }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h6>View Hari Ini</h6>
                            <h2>{{ number_format($todayViews) }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h6>View Bulan Ini</h6>
                            <h2>{{ number_format($monthViews) }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h6>WA Bulan Ini</h6>
                            <h2>{{ number_format($monthWhatsapp) }}</h2>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card mt-4">

                <div class="card-header">
                    View 30 Hari Terakhir
                </div>

                <div class="card-body">

                    <canvas id="viewChart"></canvas>

                </div>

            </div>

            <div class="card mt-4">

                <div class="card-header">
                    Top Properti Terpopuler
                </div>

                <div class="card-body">

                    <table class="table">

                        <thead>
                            <tr>
                                <th>Properti</th>
                                <th>Views</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($topProperties as $property)

                            <tr>

                                <td>{{ $property->title }}</td>

                                <td>
                                    {{ number_format($property->views_count) }}
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        {{-- MENU --}}
        <!-- <div class="section">

            <div class="fw-bold mb-3">
                Menu Dashboard
            </div>

            <a href="#" class="menu-card">

                <div class="menu-left">
                    <div class="menu-icon">
                        <i class="bi bi-building-add"></i>
                    </div>

                    <div>
                        <div style="font-size:14px; font-weight:600;">
                            Tambah Properti
                        </div>

                        <div style="font-size:12px; color:#777;">
                            Input listing baru
                        </div>
                    </div>
                </div>

                <i class="bi bi-chevron-right"></i>

            </a>

            <a href="#" class="menu-card">

                <div class="menu-left">
                    <div class="menu-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <div>
                        <div style="font-size:14px; font-weight:600;">
                            Kelola Artikel
                        </div>

                        <div style="font-size:12px; color:#777;">
                            Edit & publish artikel
                        </div>
                    </div>
                </div>

                <i class="bi bi-chevron-right"></i>

            </a>

        </div> -->

        {{-- PROPERTI TERBARU --}}
        <!-- <div class="section">

            <div class="fw-bold mb-2">
                Properti Terbaru
            </div>

            @foreach($latestProperties as $property)

            <div class="property-item">

                <div class="property-title">
                    {{ $property->title }}
                </div>

                <div class="property-location">
                    {{ $property->location }}
                </div>

            </div>

            @endforeach

        </div> -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const dailyViews = @json($dailyViews);
        const labels = dailyViews.map(item => item.date);
        const values = dailyViews.map(item => item.total);
        new Chart(
            document.getElementById('viewChart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Views',
                        data: values,
                        tension: 0.4
                    }]
                }
            }
        );
    </script>

    @endsection