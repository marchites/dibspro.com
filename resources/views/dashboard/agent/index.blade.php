@extends('dashboard.layouts.agent')

@section('title', 'Dashboard Agent')

@section('content')
<div class="container">
    <div class="section">

        <div class="mb-3">

            <div style="font-size:20px; font-weight:700;">
                Halo, {{ auth()->user()->name }} 👋
            </div>

            <div style="font-size:13px; color:#777;">
                Selamat datang di dashboard agent
            </div>

        </div>

        <div class="card-box mb-2">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div style="font-size:14px; font-weight:600;">
                        Properti Saya
                    </div>

                    <div style="font-size:12px; color:#777;">
                        <a href="{{ route('agent.properties.index') }}"
                            style="color:#777; text-decoration:underline;">
                        Kelola listing properti milikmu
                        </a>
                    </div>
                </div>

                <i class="bi bi-house-door-fill"
                    style="font-size:20px;"></i>

            </div>

        </div>

        <!-- <div class="card-box mb-2">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div style="font-size:14px; font-weight:600;">
                        Statistik
                    </div>

                    <div style="font-size:12px; color:#777;">
                        Lihat performa listing
                    </div>
                </div>

                <i class="bi bi-bar-chart-fill"
                    style="font-size:20px;"></i>

            </div>

        </div> -->

    </div>
</div>
@endsection