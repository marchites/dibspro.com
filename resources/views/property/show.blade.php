<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $property->title }} - DibsPro</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Leaflet --}}
    <link rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Custom CSS --}}
    <link rel="stylesheet"
        href="{{ asset('build/assets/css/property.css') }}">

    <style>
        body {
            background: #f5f5f5;
            font-family: sans-serif;
        }

        .app-container {
            max-width: 480px;
            margin: auto;
            background: #fff;
            min-height: 100vh;
            position: relative;
            padding-bottom: 100px;
        }

        /*
        |--------------------------------------------------------------------------
        | CAROUSEL
        |--------------------------------------------------------------------------
        */

        .carousel-item div {
            height: 280px;
            background-size: cover;
            background-position: center;
        }

        /*
        |--------------------------------------------------------------------------
        | TOP ACTIONS
        |--------------------------------------------------------------------------
        */

        .top-actions {
            position: absolute;
            top: 20px;
            left: 0;

            width: 100%;

            padding: 0 16px;

            display: flex;
            justify-content: space-between;

            z-index: 1000;
        }

        .top-action-btn {
            width: 42px;
            height: 42px;

            border: none;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.92);

            display: flex;
            align-items: center;
            justify-content: center;

            color: #111;

            text-decoration: none;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);

            backdrop-filter: blur(10px);
        }

        .top-action-btn i {
            font-size: 18px;
        }

        /*
        |--------------------------------------------------------------------------
        | SECTION
        |--------------------------------------------------------------------------
        */

        .section {
            padding: 16px;
        }

        /*
        |--------------------------------------------------------------------------
        | PRICE
        |--------------------------------------------------------------------------
        */

        .location {
            font-size: 14px;
            color: #777;
        }

        /*
        |--------------------------------------------------------------------------
        | SPEC
        |--------------------------------------------------------------------------
        */

        .spec-box {
            display: flex;
            justify-content: space-between;

            margin-top: 20px;

            background: #fafafa;

            border-radius: 14px;

            padding: 14px;
        }

        .spec-item {
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .spec-item strong {
            display: block;
            font-size: 16px;
            color: #111;
            margin-bottom: 2px;
        }

        /*
        |--------------------------------------------------------------------------
        | CTA BAR
        |--------------------------------------------------------------------------
        */

        .cta-bar {
            position: fixed;
            bottom: 0;

            width: 100%;
            max-width: 480px;

            background: #fff;

            padding: 12px;

            display: flex;
            gap: 10px;

            left: 50%;
            transform: translateX(-50%);

            z-index: 1000;

            box-shadow: 0 -5px 20px rgba(255, 255, 255, 0.95);
        }

        .btn-call {
            flex: 1;
            border-radius: 12px;
            height: 48px;
        }

        .btn-wa {
            flex: 2;
            border-radius: 12px;
            background: #25D366;
            color: #fff;
            border: none;

            display: flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;

            height: 48px;
        }

        .btn-wa:hover {
            background: #22c55e;
            color: #fff;
        }

        /*
        |--------------------------------------------------------------------------
        | FAVORITE ACTIVE
        |--------------------------------------------------------------------------
        */

        .favorite-active {
            color: red;
        }

        /*
        |--------------------------------------------------------------------------
        | MAP
        |--------------------------------------------------------------------------
        */

        #map {
            height: 220px;
            border-radius: 14px;
        }
    </style>

</head>

<body>

    @php

        $message = urlencode(
            "Halo, saya tertarik dengan properti: " . $property->title
        );

        /*
        |--------------------------------------------------------------------------
        | PHONE FORMAT
        |--------------------------------------------------------------------------
        */

        $phone = preg_replace('/^0/', '62', $property->phone);

        /*
        |--------------------------------------------------------------------------
        | DEFAULT BANDUNG
        |--------------------------------------------------------------------------
        */

        $latitude = $property->latitude ?? '-6.914744';

        $longitude = $property->longitude ?? '107.609810';

    @endphp

    <div class="app-container">

        {{-- CAROUSEL --}}
        <div id="propertyCarousel"
            class="carousel slide"
            data-bs-ride="carousel">

            {{-- TOP ACTIONS --}}
            <div class="top-actions">

                {{-- BACK --}}
                <a href="{{ url()->previous() }}"
                    class="top-action-btn">

                    <i class="bi bi-arrow-left"></i>

                </a>

                <div class="d-flex gap-2">

                    {{-- FAVORITE --}}
                    <button
                        id="btn-fav-top"
                        class="top-action-btn"
                        data-id="{{ $property->id }}">

                        <i id="fav-icon"
                            class="bi bi-heart"></i>

                    </button>

                    {{-- SHARE --}}
                    <button class="top-action-btn"
                        onclick="shareProperty()">

                        <i class="bi bi-share"></i>

                    </button>

                </div>

            </div>

            {{-- IMAGES --}}
            <div class="carousel-inner">

                @forelse ($property->images as $key => $image)

                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                        <div
                            style="
                                background-image:url('{{ asset('storage/' . $image->image_path) }}');
                            ">
                        </div>

                    </div>

                @empty

                    <div class="carousel-item active">

                        <div
                            style="
                                background:#ddd;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">

                            No Image

                        </div>

                    </div>

                @endforelse

            </div>

            {{-- PREV --}}
            <button
                class="carousel-control-prev"
                type="button"
                data-bs-target="#propertyCarousel"
                data-bs-slide="prev">

                <span class="carousel-control-prev-icon"></span>

            </button>

            {{-- NEXT --}}
            <button
                class="carousel-control-next"
                type="button"
                data-bs-target="#propertyCarousel"
                data-bs-slide="next">

                <span class="carousel-control-next-icon"></span>

            </button>

        </div>

        {{-- PROPERTY INFO --}}
        <div class="section">

            <div class="price">
                Rp {{ number_format($property->price, 0, ',', '.') }}
            </div>

            <h5 class="mb-1">
                {{ $property->title }}
            </h5>

            <div class="location">
                <i class="bi bi-geo-alt"></i>
                {{ $property->location }}
            </div>

            {{-- SPEC --}}
            <div class="spec-box">

                <div class="spec-item">
                    <strong>{{ $property->bedroom ?? '-' }}</strong>
                    K. Tidur
                </div>

                <div class="spec-item">
                    <strong>{{ $property->bathroom ?? '-' }}</strong>
                    K. Mandi
                </div>

                <div class="spec-item">
                    <strong>{{ $property->land_size ?? '-' }}</strong>
                    LT
                </div>

                <div class="spec-item">
                    <strong>{{ $property->building_size ?? '-' }}</strong>
                    LB
                </div>

            </div>

        </div>

        {{-- DESCRIPTION --}}
        <div class="section">

            <div class="fw-bold mb-2">
                Deskripsi
            </div>

            <p style="font-size:14px; color:#555; line-height:1.7;">

                {{ $property->description }}

            </p>

        </div>

        {{-- MAP --}}
        <div class="section">

            <div class="fw-bold mb-3">
                Lokasi Properti
            </div>

            <div id="map"></div>

            <a href="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}"
                target="_blank"
                class="btn btn-outline-primary mt-3 w-100">

                <i class="bi bi-geo-alt"></i>

                Buka di Google Maps

            </a>

        </div>

    </div>

    {{-- CTA BAR --}}
    <div class="cta-bar">

        {{-- CALL --}}
        <a href="tel:{{ $property->phone }}"
            class="btn btn-outline-dark btn-call">

            <i class="bi bi-telephone"></i>

        </a>

        {{-- WHATSAPP --}}
        <a href="https://wa.me/{{ $phone }}?text={{ $message }}"
            target="_blank"
            class="btn-wa">

            <i class="bi bi-whatsapp me-2"></i>

            Hubungi via WhatsApp

        </a>

    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- LEAFLET --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            /*
            |--------------------------------------------------------------------------
            | MAP
            |--------------------------------------------------------------------------
            */

            const lat = Number("{{ $latitude }}");

            const lng = Number("{{ $longitude }}");

            const map = L.map('map').setView([lat, lng], 15);

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }
            ).addTo(map);

            L.marker([lat, lng])
                .addTo(map)
                .bindPopup("Lokasi Properti")
                .openPopup();

            /*
            |--------------------------------------------------------------------------
            | FIX LEAFLET RESIZE
            |--------------------------------------------------------------------------
            */

            setTimeout(() => {
                map.invalidateSize();
            }, 300);

            /*
            |--------------------------------------------------------------------------
            | FAVORITE
            |--------------------------------------------------------------------------
            */

            const btnFav =
                document.getElementById('btn-fav-top');

            const favIcon =
                document.getElementById('fav-icon');

            if (btnFav) {

                btnFav.addEventListener('click', function() {

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

                            /*
                            |--------------------------------------------------------------------------
                            | TOGGLE ICON
                            |--------------------------------------------------------------------------
                            */

                            favIcon.classList.toggle('bi-heart');

                            favIcon.classList.toggle('bi-heart-fill');

                            favIcon.classList.toggle('favorite-active');

                        })
                        .catch(error => {

                            console.error(
                                'Favorite Error:',
                                error
                            );

                        });

                });

            }

        });

        /*
        |--------------------------------------------------------------------------
        | SHARE PROPERTY
        |--------------------------------------------------------------------------
        */

        function shareProperty() {

            if (navigator.share) {

                navigator.share({

                    title: "{{ $property->title }}",

                    text: "Lihat properti ini di DibsPro",

                    url: window.location.href

                });

            } else {

                navigator.clipboard.writeText(
                    window.location.href
                );

                alert("Link berhasil disalin");

            }

        }
    </script>

</body>

</html>