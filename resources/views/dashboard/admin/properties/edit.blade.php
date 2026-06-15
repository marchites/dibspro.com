@extends('dashboard.layouts.app')
@section('title', 'Edit Properti')
@section('content')

<div class="section">
    <form action="/dashboard/properties/{{ $property->id }}/update" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Judul Properti</label>
            <input type="text" name="title" value="{{ $property->title }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" value="{{ $property->price }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="location" value="{{ $property->location }}" class="form-control">
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label>Kamar Tidur</label>
                <input type="number" name="bedroom" value="{{ $property->bedroom }}" class="form-control">
            </div>
            <div class="col-6 mb-3">
                <label>Kamar Mandi</label>
                <input type="number" name="bathroom" value="{{ $property->bathroom }}" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-3">
                <label>Luas Tanah</label>
                <input type="number" name="land_size" value="{{ $property->land_size }}" class="form-control">
            </div>
            <div class="col-6 mb-3">
                <label>Luas Bangunan</label>
                <input type="number" name="building_size" value="{{ $property->building_size }}" class="form-control">
            </div>
        </div>
        <div class="mb-3">
            <label>Nomor WhatsApp</label>
            <input type="text" name="phone" value="{{ $property->phone }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Cari Alamat</label>
            <input type="text" id="address-search" class="form-control" value="{{ $property->address }}" placeholder="Contoh: Asia Afrika Bandung">
        </div>

        {{-- SUGGESTION --}}
        <div id="suggestions" class="list-group mb-3"></div>
        <div class="mb-3">
            <label>Lokasi Properti</label>
            <div id="map" style=" height:300px; border-radius:16px;"></div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <label>Latitude</label>
                <input type="text" name="latitude" id="latitude" value="{{ $property->latitude }}" class="form-control" readonly>
            </div>
            <div class="col-6">
                <label>Longitude</label>
                <input type="text" name="longitude" id="longitude" value="{{ $property->longitude }}" class="form-control" readonly>
            </div>
        </div>
        <div class="mb-3">
            <label>Tambah Foto Properti</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>
        <div class="mb-3">
            <label>Video Properti (Opsional)</label>
            <input type="file" name="video" accept="video/*" class="form-control">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" rows="5" class="form-control">{{ $property->description }}</textarea>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="is_featured" value="1" {{ $property->is_featured ? 'checked' : '' }}>
            <label class="form-check-label">
                Properti Unggulan
            </label>
        </div>
        <button class="btn btn-primary w-100">
            Update Properti
        </button>
    </form>

    <div class="row mt-4">
        @foreach($property->images as $image)
        <div class="col-4 mb-3">
            <div class="card">
                <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style=" height:120px; bject-fit:cover;">
                <div class="card-body p-2">
                    <form action="/dashboard/property/image/{{ $image->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-trash"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($property->video)
    <div class="mb-3">
        <label>Video Saat Ini</label>
        <video controls style=" width:100%; max-height:300px; border-radius:12px;">
            <source src="{{ asset('storage/' . $property->video) }}" type="video/mp4">
        </video>
    </div>
    @endif

    @if($property->video)
    <form action="/dashboard/property/{{ $property->id }}/video" method="POST" class="mb-3">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">
            <i class="bi bi-trash"></i>
            Hapus Video
        </button>
    </form>
    @endif

</div>

@push('scripts')
<script src="{{ asset('assets/js/edit_properties.js') }}"></script>
@endpush

@endsection