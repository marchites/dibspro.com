@extends('dashboard.layouts.app')
@section('title', 'Dashboard Admin')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard/admin.css') }}">
@endpush

@section('content')
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
        <div class="btn-group mb-4" role="group">
            <button
                class="btn btn-primary stats-tab active"
                data-target="daily">
                Harian
            </button>
            <button
                class="btn btn-outline-primary stats-tab"
                data-target="monthly">
                Bulanan
            </button>
            <button
                class="btn btn-outline-primary stats-tab"
                data-target="yearly">
                Tahunan
            </button>
        </div>

        <div id="daily-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="card-body">
                            <h6>View Hari Ini</h6>
                            <h2>{{ number_format($todayViews) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="card-body">
                            <h6>WA Hari Ini</h6>
                            <h2>{{ number_format($todayWhatsapp) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="monthly-section" style="display:none;">
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="card-body">
                            <h6>View Bulan Ini</h6>
                            <h2>{{ number_format($monthViews) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="card-body">
                            <h6>WA Bulan Ini</h6>
                            <h2>{{ number_format($monthWhatsapp) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="yearly-section" style="display:none;">
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="card-body">
                            <h6>View Tahun Ini</h6>
                            <h2>{{ number_format($yearViews) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="card-body">
                            <h6>WA Tahun Ini</h6>
                            <h2>{{ number_format($yearWhatsapp) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-box mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span id="chart-title">
                    View 30 Hari Terakhir
                </span>
            </div>
            <div class="card-body">
                <canvas id="viewChart"></canvas>
            </div>
        </div>

        <div class="card-box mt-4">
            <div class="card-header">
                Top Properti Terpopuler
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Properti</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProperties as $property)
                        <tr>
                            <td style="width: 20%;">
                                <img src="{{ $property->images->first()?->image_path ? asset('storage/' . $property->images->first()->image_path) : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1470&auto=format&fit=crop' }}" style="width:50%; height:50%; object-fit:cover;">
                            </td>
                            <td>
                                <a href="property/{{ $property->slug }}">
                                    {{ $property->title }}
                                </a>
                            </td>
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
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.dashboardData = {
        dailyViews: @json($dailyViews),
        monthlyViews: @json($monthlyViews),
        yearlyViews: @json($yearlyViews),
    };
</script>
<script src="{{ asset('assets/js/dashboard/admin.js') }}"></script>
@endpush
@endsection