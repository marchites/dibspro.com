<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $property->title }}</title>

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $property->title }}">
    <meta property="og:description" content="{{ Str::limit($property->description, 150) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('storage/' . optional($property->images->first())->image_path) }}">
    <meta property="og:site_name" content="DibsPro">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $property->title }}">
    <meta name="twitter:description" content="{{ Str::limit($property->description, 150) }}">
    <meta name="twitter:image" content="{{ asset('storage/' . optional($property->images->first())->image_path) }}">

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
        href="{{ asset('assets/css/property.css') }}">

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
            border-radius: 7px;
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

        /* Video */
        .carousel-item div {
            height: 280px;
        }

        .carousel-video {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: #000;
        }

        .video-wrapper {
            position: relative;
            width: 100%;
            height: 280px;
            overflow: hidden;
        }

        .play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: none;

            background: rgba(0, 0, 0, 0.55);
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 42px;
            cursor: pointer;

            backdrop-filter: blur(8px);
        }

        .play-btn:hover {
            background: rgba(0, 0, 0, 0.75);
        }

        /* Feature Badge  */
        .featured-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #f59e0b;
            color: white;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 600;
        }

        .property-img {
            position: relative;
        }

        /* End Feature Badge */
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

            <div class="carousel-inner">

                {{-- VIDEO FIRST --}}
                @if($property->video)
                <div class="carousel-item active">
                    <div class="video-wrapper">

                        <video id="property-video" class="carousel-video">

                            <source src="{{ asset('storage/' . $property->video) }}" type="video/mp4">
                        </video>

                        <button id="play-btn" class="play-btn" type="button">
                            <i class="bi bi-play-fill"></i>
                        </button>
                    </div>
                </div>
                @endif

                {{-- IMAGES --}}
                @forelse ($property->images as $key => $image)

                <div class="carousel-item {{ !$property->video && $key == 0 ? 'active' : '' }}">
                    <div style="background-image:url('{{ asset('storage/' . $image->image_path) }}');">
                    </div>
                </div>

                @empty

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

            {{-- FEATURED BADGE --}}
            @if($property->is_featured)
            <div class="featured-badge">
                ⭐ Unggulan
            </div>
            @endif

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

        {{-- AGENT --}}
        <div class="section">

            <div class="fw-bold mb-3">
                Agen Properti
            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body d-flex align-items-center">

                    <img
                        src="{{ $property->user->avatar
                    ? asset('storage/'.$property->user->avatar)
                    : 'https://ui-avatars.com/api/?name=' . strtoupper(substr($property->user->name, 0, 1)) }}"
                        style="
                    width:60px;
                    height:60px;
                    border-radius:50%;
                    object-fit:cover;
                    
                ">

                    <div class="ms-3">

                        <div class="fw-bold">
                            {{ $property->user->name }}
                        </div>

                        <small class="text-muted">
                            Agen Properti
                        </small>

                    </div>

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
        <a
            href="{{ route('property.whatsapp', $property->id) }}"
            target="_blank"
            class="btn btn-success">
            <i class="bi bi-whatsapp"></i>
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

        // Video 
        const video = document.getElementById('property-video');
        const playBtn = document.getElementById('play-btn');

        if (video && playBtn) {
            playBtn.addEventListener('click', function() {
                video.play();
                video.controls = true;
                playBtn.style.display = 'none';
            });

            video.addEventListener('pause', function() {
                playBtn.style.display = 'flex';
            });

            video.addEventListener('ended', function() {
                playBtn.style.display = 'flex';
            });
        }
    </script>

</body>

</html>