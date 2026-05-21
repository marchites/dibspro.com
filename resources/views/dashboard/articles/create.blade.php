@extends('dashboard.layouts.app')

@section('title', 'Tambah Artikel')

@section('content')

<div class="section">

    <form action="/dashboard/articles/store"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="mb-3">

            <label>Judul Artikel</label>

            <input type="text"
                name="title"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Thumbnail Artikel</label>

            <input type="file"
                name="thumbnail"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Kategori</label>

            <select name="category_id"
                class="form-control">

                <option value="">
                    Pilih Kategori
                </option>

                @foreach($categories as $category)

                <option value="{{ $category->id }}">

                    {{ $category->name }}

                </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Konten Artikel</label>

            <textarea name="content"
                rows="8"
                class="form-control"></textarea>

        </div>

        <button class="btn btn-primary w-100">
            Simpan Artikel
        </button>

    </form>

</div>

@endsection