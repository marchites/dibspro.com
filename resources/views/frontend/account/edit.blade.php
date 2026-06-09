@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

<div class="section">

    <div class="card-box">

        <form action="/account/profile/update"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-3">

                <label>Foto Profil</label>

                <input
                    type="file"
                    name="avatar"
                    class="form-control">

            </div>

            <div class="mb-3">

                <label>Nama</label>

                <input
                    type="text"
                    name="name"
                    value="{{ auth()->user()->name }}"
                    class="form-control">

            </div>

            <button class="btn btn-primary w-100">

                Simpan Perubahan

            </button>

        </form>

    </div>

</div>

@endsection