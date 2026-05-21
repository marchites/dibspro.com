@extends('layouts.app')

@section('title', 'DibsPro - Temukan Rumah Impianmu')

@push('styles')
<link rel="stylesheet" href="{{ asset('build/assets/css/home.css') }}">
@endpush

@section('content')
<div class="section">
    {{-- HEADER --}}
    <div class="header animated-gradient">

        <h6 class="mb-0">
            <img src="{{ asset('build/assets/images/logo.svg') }}" alt="DibsPro Logo" style="height:40px; margin-left:15px;">
        </h6>

        @if(auth()->check())
        <a href="#"
            class="btn btn-light btn-sm rounded-pill">
            Hallo, {{ auth()->user()->name }} !
        </a>

        @else

        <a href="/login"
            class="btn btn-light btn-sm rounded-pill">
            Masuk
        </a>
        @endif

    </div>

    {{-- SEARCH --}}
    <div class="search-box">

        <form action="/property" method="GET">

            <div class="input-group">

                <input type="text"
                    name="keyword"
                    class="form-control"
                    placeholder="Cari rumah, lokasi..."
                    value="{{ request('keyword') }}">

                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>

            </div>

        </form>

    </div>

    {{-- FEATURED --}}
    <div class="section">

        <div class="d-flex justify-content-between mb-2">

            <strong>Properti Unggulan</strong>

            <a href="/property"
                class="text-primary"
                style="font-size:12px;">
                Lihat semua
            </a>

        </div>

        <div class="swiper property-swiper">

            <div class="swiper-wrapper">

                @foreach($properties as $property)

                <div class="swiper-slide">

                    <div class="{{ $property->status == 'sold' ? 'property-sold' : '' }}">

                        @if($property->status != 'sold')
                        <a href="/property/{{ $property->slug }}"
                            style="text-decoration:none; color:inherit;">
                            @endif

                            <div class="property-card {{ $property->status == 'sold' ? 'property-disabled' : '' }}">

                                <div class="property-img"
                                    style="background-image:url('{{ asset('storage/' . $property->images->first()->image_path) ?? 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}')">

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
    <div class="section">

        <div class="d-flex justify-content-between mb-2">

            <strong>Properti Terbaru</strong>

            <a href="/property"
                class="text-primary"
                style="font-size:12px;">
                Lihat semua
            </a>

        </div>

        <div class="row g-2">

            @foreach($properties as $property)

            <div class="col-6">

                <div class="{{ $property->status == 'sold' ? 'property-sold' : '' }}">

                    @if($property->status != 'sold')
                    <a href="/property/{{ $property->slug }}"
                        style="text-decoration:none; color:inherit;">
                        @endif

                        <div class="property-card {{ $property->status == 'sold' ? 'property-disabled' : '' }}">

                            <div class="property-img"
                                style="background-image:url('{{ asset('storage/' . $property->images->first()->image_path) ?? 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}')">

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

    {{-- ARTIKEL --}}
    <div class="section">

        <div class="d-flex justify-content-between mb-2">

            <strong>Artikel Terbaru</strong>

            <a href="/article"
                class="text-primary"
                style="font-size:12px;">
                Lihat semua
            </a>

        </div>

        @foreach($articles as $article)

        <a href="/article/{{ $article->slug }}"
            style="text-decoration:none; color:inherit;">

            <div class="d-flex mb-2">

                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                    style="width:80px;
                        height:80px;
                        object-fit:cover;
                        border-radius:8px;">



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
</div>
@endsection