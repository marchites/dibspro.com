@extends('dashboard.layouts.app')

@section('title', 'Tambah Properti')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="alert alert-warning">
    Properti yang Anda upload akan menunggu persetujuan admin sebelum tampil di website.
</div>

<form action="{{ route('agent.properties.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Judul Properti</label>
        <input type="text"
            name="title"
            value="{{ old('title') }}"
            class="form-control @error('title') is-invalid @enderror">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Harga</label>
        <input type="number"
            name="price"
            value="{{ old('price') }}"
            class="form-control">
    </div>

    <div class="mb-3">
        <label>Lokasi</label>
        <input type="text"
            name="location"
            value="{{ old('location') }}"
            class="form-control">
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label>Kamar Tidur</label>
            <input type="number"
                name="bedroom"
                value="{{ old('bedroom') }}"
                class="form-control">
        </div>

        <div class="col-6 mb-3">
            <label>Kamar Mandi</label>
            <input type="number"
                name="bathroom"
                value="{{ old('bathroom') }}"
                class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label>Luas Tanah</label>
            <input type="number"
                name="land_size"
                value="{{ old('land_size') }}"
                class="form-control">
        </div>

        <div class="col-6 mb-3">
            <label>Luas Bangunan</label>
            <input type="number"
                name="building_size"
                value="{{ old('building_size') }}"
                class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <label>Nomor WhatsApp</label>
        <input type="text"
            name="phone"
            value="{{ old('phone') }}"
            class="form-control">
    </div>

    <div class="mb-3">
        <label>Cari Alamat</label>
        <input type="text"
            id="address-search"
            class="form-control"
            placeholder="Contoh: Asia Afrika Bandung">
    </div>

    <div id="suggestions" class="list-group mb-3"></div>

    <div class="mb-3">
        <label>Lokasi Properti</label>
        <div id="map"
            style="height:300px; border-radius:16px;"></div>
    </div>

    <div class="row mt-3">
        <div class="col-6">
            <label>Latitude</label>
            <input type="text"
                name="latitude"
                id="latitude"
                value="{{ old('latitude') }}"
                class="form-control"
                readonly>
        </div>

        <div class="col-6">
            <label>Longitude</label>
            <input type="text"
                name="longitude"
                id="longitude"
                value="{{ old('longitude') }}"
                class="form-control"
                readonly>
        </div>
    </div>

    <div class="mb-3">
        <label>Foto Properti</label>
        <input type="file"
            name="images[]"
            class="form-control"
            multiple>
    </div>

    <div class="mb-3">
        <label>Video Properti (Opsional)</label>
        <input type="file"
            name="video"
            accept="video/*"
            class="form-control">
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description"
            rows="5"
            class="form-control">{{ old('description') }}</textarea>
    </div>

    <button class="btn btn-primary w-100">
        Simpan Properti
    </button>
</form>

@endsection

@push('scripts')
// Map script taruh di sini
<script src="{{ asset('assets/js/create_properties.js') }}"></script>
@endpush