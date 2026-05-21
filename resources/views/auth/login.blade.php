@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="section"
        style="padding-top:40px; min-height:100vh;">

        <div class="text-center mb-4">

            <h4 style="font-weight:700;">
                Masuk ke DibsPro
            </h4>

            <div style="font-size:13px; color:#777;">
                Temukan properti impianmu
            </div>

        </div>

        <div class="card-box">

            <form action="/login" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Email</label>

                    <input type="email"
                        name="email"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label>Password</label>

                    <input type="password"
                        name="password"
                        class="form-control"
                        required>

                </div>

                <button class="btn btn-primary w-100">
                    Masuk
                </button>

            </form>

            <div class="text-center mt-3"
                style="font-size:13px;">

                Belum punya akun?

                <a href="/register"
                    class="text-decoration-none">
                    Daftar
                </a>

            </div>

        </div>

    </div>
</div>
@endsection