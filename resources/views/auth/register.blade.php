@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="section"
        style="padding-top:40px; min-height:100vh;">

        <div class="text-center mb-4">

            <h4 style="font-weight:700;">
                Daftar DibsPro
            </h4>

            <div style="font-size:13px; color:#777;">
                Buat akun baru
            </div>

        </div>

        <div class="card-box">

            <form action="/register"
                method="POST">

                @csrf

                <div class="mb-3">

                    <label>Nama</label>

                    <input type="text"
                        name="name"
                        class="form-control"
                        required>

                </div>

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

                <div class="mb-3">

                    <label>Daftar Sebagai</label>

                    <select name="role"
                        class="form-control">

                        <option value="user">
                            Pembeli
                        </option>

                        <option value="agent">
                            Agen Properti
                        </option>

                    </select>

                </div>

                <button class="btn btn-primary w-100">
                    Daftar
                </button>

            </form>

            <div class="text-center mt-3"
                style="font-size:13px;">

                Sudah punya akun?

                <a href="/login"
                    class="text-decoration-none">
                    Login
                </a>

            </div>

        </div>

    </div>
</div>
@endsection