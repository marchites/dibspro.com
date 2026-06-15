@extends('layouts.app')
@section('title', 'DibsPro - Temukan Rumah Impianmu')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endpush

@section('content')
<div class="section">
    {{-- HEADER --}}
    <div class="header animated-gradient">
        <h6 class="mb-0">
            <img src="{{ asset('assets/images/logo.png') }}" alt="DibsPro Logo" style="height:45px; margin-left:15px;">
        </h6>
        @if(auth()->check())
        <div>
            <a href="#" class="btn btn-light btn-sm rounded disabled">
                <i class="bi bi-megaphone"></i>
                Pasang Iklan
            </a>
            {!! auth()->user()->avatar
            ? '<img src="' . asset('storage/' . auth()->user()->avatar) . '" class="rounded-circle" style="width:30px; height:30px; object-fit:cover;">'
            : ''
            !!}
        </div>
        @else
        <a href="/login" class="btn btn-light btn-sm rounded disabled">
            <i class="bi bi-megaphone"></i>
            Pasang Iklan
        </a>
        @endif
    </div>

    {{-- SEARCH --}}
    <div class="search-box">
        <form action="/property" method="GET">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Cari rumah, lokasi..." value="{{ request('keyword') }}">
                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- FEATURED --}}
<div class="section">
    <div class="d-flex justify-content-between mb-2">
        <strong>Properti Unggulan</strong>
        <a href="/property" class="text-primary" style="font-size:12px;">
            Lihat semua
        </a>
    </div>

    <div class="swiper property-swiper">
        <div class="swiper-wrapper">
            @foreach($featuredProperties as $property)
            <div class="swiper-slide">
                <div class="{{ $property->status == 'sold' ? 'property-sold' : '' }}">
                    @if($property->status != 'sold')
                    <a href="/property/{{ $property->slug }}" style="text-decoration:none; color:inherit;">
                        @endif
                        <div class="property-card {{ $property->status == 'sold' ? 'property-disabled' : '' }}">
                            <div class="property-img" style="background-image: url('{{ $property->bg_image }}')">
                                {{-- FEATURED BADGE --}}
                                @if($property->is_featured)
                                <div class="featured-badge">
                                    ⭐ Unggulan
                                </div>
                                @endif
                                @if($property->status == 'sold')
                                <div class="sold-overlay">
                                    SOLD OUT
                                </div>
                                @endif
                            </div>
                            <div class="property-body">
                                <div class="price">
                                    Rp {{ number_format($property->price, 0, ',', '.') }}
                                </div>
                                <div class="title">
                                    {{ Str::limit($property->title, 40) }}
                                </div>
                                <div class="location">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $property->location }}
                                </div>
                            </div>
                        </div>
                        @if($property->status != 'sold')
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- PROPERTI TERBARU --}}
<div class="section-dark">
    <div class="d-flex justify-content-between mb-2">
        <strong>Properti Terbaru</strong>
    </div>

    <div class="row g-2">
        @foreach($properties as $property)
        <div class="col-6">
            <div class="{{ $property->status == 'sold' ? 'property-sold' : '' }}">
                @if($property->status != 'sold')
                <a href="/property/{{ $property->slug }}" style="text-decoration:none; color:inherit;">
                    @endif
                    <div class="property-card {{ $property->status == 'sold' ? 'property-disabled' : '' }}">
                        <div class="property-img" style="background-image: url('{{ $property->bg_image }}')">
                            {{-- FEATURED BADGE --}}
                            @if($property->is_featured)
                            <div class="featured-badge">
                                ⭐ Unggulan
                            </div>
                            @endif
                            @if($property->status == 'sold')
                            <div class="sold-overlay">
                                SOLD OUT
                            </div>
                            @endif
                        </div>
                        <div class="property-body">
                            <div class="price">
                                Rp {{ number_format($property->price, 0, ',', '.') }}
                            </div>
                            <div class="title">
                                {{ Str::limit($property->title, 40) }}
                            </div>
                            <div class="location">
                                <i class="bi bi-geo-alt"></i>
                                {{ $property->location }}
                            </div>
                        </div>
                    </div>
                    @if($property->status != 'sold')
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <a href="/property" class="text-primary" style="font-size:12px;">
        <button class="btn btn-sm btn-primary mt-3 mx-auto d-block">
            <i class="bi bi-arrow-right-short"></i>
            Lihat Semua
        </button>
    </a>
</div>

{{-- ARTIKEL TERBARU --}}
<div class="section">
    <div class="d-flex justify-content-between mb-2">
        <strong>Artikel Terbaru</strong>
        <a href="/article" class="text-primary" style="font-size:12px;">
            Lihat semua
        </a>
    </div>
    @foreach($articles as $article)
    <a href="/article/{{ $article->slug }}" style="text-decoration:none; color:inherit;">
        <div class="d-flex mb-2">
            <img src="{{ asset('storage/' . $article->thumbnail) }}" style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
            <div class="ms-2">
                <div style="font-size:13px; font-weight:600;">
                    {{ $article->title }}
                </div>
                <div class="mb-1">
                    <span class="badge bg-primary">
                        {{ $article->category->name ?? 'Artikel' }}
                    </span>
                </div>
                <div style="font-size:11px; color:#777;">
                    {{ $article->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>

{{-- FOOTER --}}
<div class="section-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 small text-center text-muted">
                <h6>Developed by</h6>
                <img src="{{ asset('assets/images/astrobyte-logo-dark.png') }}" alt="DibsPro Logo" style="width: auto; height: 28px;" class="mb-3">
                <hr class="my-1">
            </div>
            <div class="col-12 small text-center text-muted">
                <p>&copy; 2026 DibsPro. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>
@endsection