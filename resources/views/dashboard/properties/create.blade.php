@extends('dashboard.layouts.app')

@section('title', 'Tambah Properti')

@section('content')

<div class="section">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="/dashboard/properties/store"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Judul Properti</label>
            <input type="text"
                name="title"
                value="{{ old('title') }}"
                class="form-control @error('title') is-invalid @enderror">
            @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
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
                    class="form-control">
            </div>

            <div class="col-6 mb-3">
                <label>Kamar Mandi</label>
                <input type="number"
                    name="bathroom"
                    class="form-control">
            </div>

        </div>

        <div class="row">

            <div class="col-6 mb-3">
                <label>Luas Tanah</label>
                <input type="number"
                    name="land_size"
                    class="form-control">
            </div>

            <div class="col-6 mb-3">
                <label>Luas Bangunan</label>
                <input type="number"
                    name="building_size"
                    class="form-control">
            </div>

        </div>

        <div class="mb-3">
            <label>Nomor WhatsApp</label>
            <input type="text"
                name="phone"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi Properti</label>
            <div id="map"
                style="
                height:300px;
                border-radius:16px;">
            </div>
        </div>

        <div class="row">

            <div class="col-6">
                <div class="mb-3">
                    <label>Latitude</label>
                    <input type="text"
                        name="latitude"
                        id="latitude"
                        value="{{ old('latitude') }}"
                        class="form-control @error('latitude') is-invalid @enderror"
                        readonly>
                    @error('latitude')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-6">
                <div class="mb-3">
                    <label>Longitude</label>
                    <input type="text"
                        name="longitude"
                        id="longitude"
                        value="{{ old('longitude') }}"
                        class="form-control @error('longitude') is-invalid @enderror"
                        readonly>
                    @error('longitude')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror                
                </div>
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
            <label>Deskripsi</label>

            <textarea name="description"
                rows="5"
                class="form-control"></textarea>
        </div>

        <div class="form-check mb-3">

            <input type="checkbox"
                class="form-check-input"
                name="is_featured"
                value="1">

            <label class="form-check-label">
                Properti Unggulan
            </label>

        </div>

        <button class="btn btn-primary w-100">
            Simpan Properti
        </button>

    </form>

</div>

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function() {

        /*
        |--------------------------------------------------------------------------
        | INIT MAP
        |--------------------------------------------------------------------------
        */

        const map = L.map('map').setView(
            [-6.914744, 107.609810],
            13
        );

        /*
        |--------------------------------------------------------------------------
        | TILE
        |--------------------------------------------------------------------------
        */

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);

        /*
        |--------------------------------------------------------------------------
        | MARKER
        |--------------------------------------------------------------------------
        */

        let marker;

        /*
        |--------------------------------------------------------------------------
        | CLICK MAP
        |--------------------------------------------------------------------------
        */

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            document.getElementById('latitude').value = lat;

            document.getElementById('longitude').value = lng;

            /*
            |--------------------------------------------------------------------------
            | REMOVE OLD MARKER
            |--------------------------------------------------------------------------
            */

            if (marker) {
                map.removeLayer(marker);
            }

            /*
            |--------------------------------------------------------------------------
            | ADD NEW MARKER
            |--------------------------------------------------------------------------
            */

            marker = L.marker([lat, lng])
                .addTo(map);

        });

    });
</script>

@endpush

@endsection