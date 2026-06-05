@extends('layouts.app')

@section('title', 'Akun Saya')

@section('content')
<div class="container">
    <div class="section">

        {{-- PROFILE --}}
        <div class="card-box mb-3 text-center">

            <div class="mb-3">

                <div style="
                width:80px;
                height:80px;
                border-radius:50%;
                background:#2c7be5;
                color:white;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:28px;
                font-weight:700;
                margin:auto;
            ">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            </div>

            <div style="font-size:18px; font-weight:700;">

                {{ auth()->user()->name }}

            </div>

            <div style="font-size:13px; color:#777;">

                {{ auth()->user()->email }}

            </div>

            <div class="mt-2">

                @if(auth()->user()->role == 'admin')

                <span class="badge bg-danger">
                    Admin
                </span>

                @elseif(auth()->user()->role == 'agent')

                <span class="badge bg-primary">
                    Agen Properti
                </span>

                @else

                <span class="badge bg-success">
                    Pembeli
                </span>

                @endif

            </div>

        </div>

        {{-- MENU --}}
        <div class="card-box mb-2">

            <a href="/favorite"
                class="d-flex justify-content-between align-items-center text-decoration-none text-dark">

                <div class="d-flex align-items-center gap-2">

                    <i class="bi bi-heart"></i>

                    <span>Properti Favorit</span>

                </div>

                <i class="bi bi-chevron-right"></i>

            </a>

        </div>

        @if(auth()->user()->role == 'agent')

        <div class="card-box mb-2">

            <a href="/agent/dashboard"
                class="d-flex justify-content-between align-items-center text-decoration-none text-dark">

                <div class="d-flex align-items-center gap-2">

                    <i class="bi bi-buildings"></i>

                    <span>Dashboard Agent</span>

                </div>

                <i class="bi bi-chevron-right"></i>

            </a>

        </div>

        @endif

        @if(auth()->user()->role == 'admin')

        <div class="card-box mb-2">

            <a href="/dashboard"
                class="d-flex justify-content-between align-items-center text-decoration-none text-dark">

                <div class="d-flex align-items-center gap-2">

                    <i class="bi bi-speedometer2"></i>

                    <span>Dashboard Admin</span>

                </div>

                <i class="bi bi-chevron-right"></i>

            </a>

        </div>

        @endif

        {{-- LOGOUT --}}
        <div class="mt-4">

            <form action="/logout"
                method="POST">

                @csrf

                <button class="btn btn-danger w-100">

                    Logout

                </button>

            </form>

        </div>

    </div>
</div>
@endsection