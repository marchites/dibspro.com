@extends('layouts.app')
@section('title', 'Properti Favorit')

@section('content')
<div class="section">
    <div class="container mt-3">
        <h5>Properti Favorit</h5>

        @forelse ($properties as $property)
        <div class="card mb-2">
            <div class="card-body">
                <a href="/property/{{ $property->slug }}">
                    {{ $property->title }}
                </a>
            </div>
        </div>
        @empty
        <p>Tidak ada favorit</p>
        @endforelse
    </div>
</div>
@endsection