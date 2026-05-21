@extends('layouts.app')
@section('title', 'Cari Properti - DibsPro')
@push('styles')
<link rel="stylesheet" href="{{ asset('build/assets/css/search.css') }}">
@endpush

@section('content')
<div class="section">
    <div class="search-page">

        {{-- FILTER --}}
        <div class="section">
            <form method="GET" action="/property" class="filter-box">

                <input type="text" name="keyword" class="form-control"
                    placeholder="Cari properti..."
                    value="{{ request('keyword') }}">

                <select name="type" class="form-control">
                    <option value="">Semua Tipe</option>
                    <option value="rumah" {{ request('type') == 'rumah' ? 'selected' : '' }}>Rumah</option>
                    <option value="apartemen" {{ request('type') == 'apartemen' ? 'selected' : '' }}>Apartemen</option>
                    <option value="tanah" {{ request('type') == 'tanah' ? 'selected' : '' }}>Tanah</option>
                </select>

                <input type="number" name="min_price" class="form-control"
                    placeholder="Harga minimum"
                    value="{{ request('min_price') }}">

                <input type="number" name="max_price" class="form-control"
                    placeholder="Harga maksimum"
                    value="{{ request('max_price') }}">

                <button class="btn btn-primary w-100 mt-2">Cari</button>
            </form>
        </div>

        {{-- HASIL --}}
        <div class="section">
            @forelse ($properties as $property)

            <a href="/property/{{ $property->slug }}" style="text-decoration:none; color:inherit;">
                <div class="property-card">

                    <div class="property-img"
                        style="background-image:url('{{ asset('storage/' . $property->images->first()->image_path) ?? 'https://via.placeholder.com/400x300' }}')">
                    </div>

                    <div class="property-body">
                        <div class="price">
                            Rp {{ number_format($property->price, 0, ',', '.') }}
                        </div>

                        <div>{{ $property->title }}</div>

                        <div style="font-size:12px; color:#777;">
                            {{ $property->location }}
                        </div>
                    </div>

                </div>
            </a>

            @empty
            <p class="text-center text-muted">Properti tidak ditemukan</p>
            @endforelse

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $properties->withQueryString()->links() }}
            </div>
        </div>

    </div>
</div>
@endsection