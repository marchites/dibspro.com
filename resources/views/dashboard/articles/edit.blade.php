@extends('dashboard.layouts.app')

@section('title', 'Edit Artikel')

@section('content')

<div class="section">

    <form action="/dashboard/articles/{{ $article->id }}/update"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label>Judul Artikel</label>

            <input type="text"
                name="title"
                value="{{ $article->title }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Thumbnail Artikel</label>

            <input type="file"
                name="thumbnail"
                class="form-control">

        </div>

        @if($article->thumbnail)

        <img src="{{ asset('storage/' . $article->thumbnail) }}"
            style="width:100%;
                border-radius:12px;
                margin-top:10px;">

        @endif

        <div class="mb-3">

            <label>Kategori</label>

            <select name="category_id"
                class="form-control">

                @foreach($categories as $category)

                <option value="{{ $category->id }}"
                    {{ $article->category_id == $category->id ? 'selected' : '' }}>

                    {{ $category->name }}

                </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Konten Artikel</label>

            <textarea name="content"
                rows="8"
                class="form-control">{{ $article->content }}</textarea>

        </div>

        <button class="btn btn-primary w-100">
            Update Artikel
        </button>

    </form>

</div>

@endsection