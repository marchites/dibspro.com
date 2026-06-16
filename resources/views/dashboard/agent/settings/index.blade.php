@extends('dashboard.layouts.agent')

@section('title', 'General Setting')

@section('content')

<div class="section">

    <!-- <div class="card-box">

        <form action="/dashboard/settings/update"
              method="POST">

            @csrf

            <div class="mb-3">

                <label>Nama Website</label>

                <input type="text"
                       name="site_name"
                       class="form-control"
                       value="{{ $settings['site_name'] ?? '' }}">

            </div>

            <div class="mb-3">

                <label>Tagline</label>

                <input type="text"
                       name="tagline"
                       class="form-control"
                       value="{{ $settings['tagline'] ?? '' }}">

            </div>

            <div class="mb-3">

                <label>WhatsApp</label>

                <input type="text"
                       name="whatsapp"
                       class="form-control"
                       value="{{ $settings['whatsapp'] ?? '' }}">

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ $settings['email'] ?? '' }}">

            </div>

            <div class="mb-3">

                <label>Logo URL</label>

                <input type="text"
                       name="logo"
                       class="form-control"
                       value="{{ $settings['logo'] ?? '' }}">

            </div>

            <button class="btn btn-primary w-100">

                Simpan Setting

            </button>

        </form>

    </div> -->

    {{-- LOGOUT --}}
    <div class="mt-3">

        <form action="/logout"
              method="POST">

            @csrf

            <button class="btn btn-danger w-100">

                Logout

            </button>

        </form>

    </div>

</div>

@endsection