@extends('dashboard.layouts.app')

@section('title', 'Edit Properti')

@section('content')

<div class="section">

    <form action="/dashboard/properties/{{ $property->id }}/update"
      method="POST"
      enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Judul Properti</label>

            <input type="text"
                name="title"
                value="{{ $property->title }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Harga</label>

            <input type="number"
                name="price"
                value="{{ $property->price }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi</label>

            <input type="text"
                name="location"
                value="{{ $property->location }}"
                class="form-control">
        </div>

        <div class="mb-3">

            <label>Tambah Foto Properti</label>

            <input type="file"
                name="images[]"
                class="form-control"
                multiple>

        </div>

        <div class="row">

            @foreach($property->images as $image)

            <div class="col-4 mb-2">

                <img src="{{ asset('storage/' . $image->image_path) }}"
                    style="
                    width:100%;
                    height:100px;
                    object-fit:cover;
                    border-radius:12px;
                 ">

            </div>

            @endforeach

        </div>

        <div class="mb-3">
            <label>Deskripsi</label>

            <textarea name="description"
                rows="5"
                class="form-control">{{ $property->description }}</textarea>
        </div>

        <button class="btn btn-primary w-100">
            Update Properti
        </button>

    </form>

</div>

@endsection