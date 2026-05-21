<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->title }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        body {
            background: #f5f6f8;
        }

        .app-container {
            max-width: 480px;
            margin: auto;
            background: #fff;
            min-height: 100vh;
            padding-bottom: 90px;
        }

        .section {
            padding: 15px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #2c7be5;
        }

        .location {
            font-size: 13px;
            color: #777;
        }

        .spec-box {
            display: flex;
            justify-content: space-between;
            text-align: center;
            margin-top: 10px;
        }

        .spec-item {
            flex: 1;
        }

        .cta-bar {
            position: fixed;
            bottom: 0;
            width: 100%;
            max-width: 480px;
            background: #fff;
            border-top: 1px solid #ddd;
            padding: 10px;
            display: flex;
            gap: 10px;

            left: 50%;
            transform: translateX(-50%);
            justify-content: space-around;
            align-items: center;
            z-index: 1000;
        }

        .btn-wa {
            background: #25D366;
            color: #fff;
            flex: 1;
            border-radius: 10px;
        }

        .btn-call {
            flex: 1;
            border-radius: 10px;
        }

        .btn-fav.active {
            background: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="app-container">

    {{-- CAROUSEL --}}
    <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            @forelse ($property->images as $key => $image)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div style="
                        height:250px;
                        background-image:url('{{ asset('storage/' . $image->image_path) }}');
                        background-size:cover;
                        background-position:center;">
                    </div>
                </div>
            @empty
                <div class="carousel-item active">
                    <div style="height:250px; background:#ddd; display:flex; align-items:center; justify-content:center;">
                        No Image
                    </div>
                </div>
            @endforelse

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- INFO --}}
    <div class="section">

        <div class="price">
            Rp {{ number_format($property->price, 0, ',', '.') }}
        </div>

        <h6>{{ $property->title }}</h6>

        <div class="location">
            {{ $property->location }}
        </div>

        {{-- FAVORIT --}}
        <button id="btn-fav"
                class="btn btn-sm btn-outline-danger mt-2 btn-fav"
                data-id="{{ $property->id }}">
            ❤️ Simpan
        </button>

        {{-- SPEC --}}
        <div class="spec-box">
            <div class="spec-item">
                <strong>{{ $property->bedroom ?? '-' }}</strong>
                Kamar
            </div>
            <div class="spec-item">
                <strong>{{ $property->bathroom ?? '-' }}</strong>
                Mandi
            </div>
            <div class="spec-item">
                <strong>{{ $property->land_size ?? '-' }} m²</strong>
                LT
            </div>
            <div class="spec-item">
                <strong>{{ $property->building_size ?? '-' }} m²</strong>
                LB
            </div>
        </div>

    </div>

    {{-- DESKRIPSI --}}
    <div class="section">
        <div class="fw-bold mb-2">Deskripsi</div>
        <p style="font-size:14px; color:#555;">
            {{ $property->description }}
        </p>
    </div>

    {{-- MAP --}}
    <div class="section">
        <div class="fw-bold mb-2">Lokasi</div>
        <div id="map" style="height:200px; border-radius:10px;"></div>

        <a href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}"
           target="_blank"
           class="btn btn-sm btn-outline-primary mt-2 w-100">
            Buka di Google Maps
        </a>
    </div>

</div>

{{-- CTA --}}
@php
    $message = urlencode("Halo, saya tertarik dengan properti: " . $property->title);
@endphp

<div class="cta-bar">
    <a href="tel:{{ $property->phone }}" class="btn btn-outline-dark btn-call">
        Telepon
    </a>

    <a href="https://wa.me/{{ $property->phone }}?text={{ $message }}"
       class="btn btn-wa">
        WhatsApp
    </a>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // MAP
    var lat = {{ $property->latitude ?? -6.914744 }};
    var lng = {{ $property->longitude ?? 107.609810 }};

    var map = L.map('map').setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup("Lokasi Properti")
        .openPopup();

    // FAVORIT
    const btn = document.getElementById('btn-fav');

    btn.addEventListener('click', function () {

        fetch('/favorite/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                property_id: this.dataset.id
            })
        })
        .then(res => res.json())
        .then(data => {

            btn.classList.toggle('active');

        });
    });

});
</script>

</body>
</html>