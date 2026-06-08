@extends('layouts.app')
@section('title', 'Cari Properti - DibsPro')
@push('meta')
<title>{{ $property->title }}</title>

<meta property="og:type" content="website">

<meta property="og:title"
    content="{{ $property->title }}">

<meta property="og:description"
    content="{{ Str::limit($property->description, 150) }}">

<meta property="og:url"
    content="{{ url()->current() }}">

<meta property="og:image"
    content="{{ asset('storage/' . optional($property->images->first())->image_path) }}">

<meta property="og:site_name"
    content="DibsPro">

<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<meta name="twitter:card" content="summary_large_image">

<meta name="twitter:title"
    content="{{ $property->title }}">

<meta name="twitter:description"
    content="{{ Str::limit($property->description, 150) }}">

<meta name="twitter:image"
    content="{{ asset('storage/' . optional($property->images->first())->image_path) }}">
@endpush
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/search.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/property.css') }}">
@endpush

@section('content')
<div class="search-page">

    {{-- SEARCH + FILTER --}}
    <div class="section">

        <form method="GET" action="/property">

            {{-- TOP SEARCH --}}
            <div class="search-top">

                {{-- SEARCH --}}
                <div class="search-input-wrap">

                    <i class="bi bi-search search-icon"></i>

                    <input
                        type="text"
                        name="keyword"
                        class="search-input"
                        placeholder="Cari properti..."
                        value="{{ request('keyword') }}">

                </div>

                {{-- FILTER BUTTON --}}
                <button
                    type="button"
                    class="filter-btn"
                    id="toggleFilter">

                    <i class="bi bi-sliders"></i>

                </button>

            </div>

            {{-- DROPDOWN FILTER --}}
            <div class="filter-dropdown" id="filterDropdown">

                <select name="type" class="form-control custom-input">
                    <option value="">Semua Tipe</option>

                    <option value="rumah"
                        {{ request('type') == 'rumah' ? 'selected' : '' }}>
                        Rumah
                    </option>

                    <option value="apartemen"
                        {{ request('type') == 'apartemen' ? 'selected' : '' }}>
                        Apartemen
                    </option>

                    <option value="tanah"
                        {{ request('type') == 'tanah' ? 'selected' : '' }}>
                        Tanah
                    </option>

                </select>

                <input
                    type="number"
                    name="min_price"
                    class="form-control custom-input"
                    placeholder="Harga minimum"
                    value="{{ request('min_price') }}">

                <input
                    type="number"
                    name="max_price"
                    class="form-control custom-input"
                    placeholder="Harga maksimum"
                    value="{{ request('max_price') }}">

                <button class="btn btn-primary w-100 mt-2 rounded-pill">
                    Cari Properti
                </button>

            </div>

        </form>

    </div>

    {{-- HASIL --}}
    <div class="section">
        @forelse ($properties as $property)

        <a href="/property/{{ $property->slug }}" style="text-decoration:none; color:inherit;">
            <div class="property-card">

                <div class="property-img"
                    style="background-image:url('{{ $property->images->first()?->image_path
                                ? asset('storage/' . $property->images->first()->image_path)
                                : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1470&auto=format&fit=crop' }}')">
                </div>

                <div class="property-body">
                    <div class="price">
                        Rp {{ number_format($property->price, 0, ',', '.') }}
                    </div>

                    <div>{{ $property->title }}</div>

                    <div style="font-size:12px; color:#777;">
                        <i class="bi bi-geo-alt"></i>
                        {{ $property->location }}
                    </div>
                </div>

            </div>
        </a>

        @empty
        <p class="text-center text-muted">Properti tidak ditemukan</p>
        @endforelse

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $properties->withQueryString()->links() }}
        </div>
    </div>

</div>

<script>
    const toggleBtn =
        document.getElementById('toggleFilter');

    const filterDropdown =
        document.getElementById('filterDropdown');

    toggleBtn.addEventListener('click', function() {

        if (filterDropdown.style.display === 'block') {

            filterDropdown.style.display = 'none';

        } else {

            filterDropdown.style.display = 'block';

        }

    });
</script>
@endsection