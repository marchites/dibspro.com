@extends('layouts.app')
@section('title', 'DibsPro - Artikel Properti')

@section('content')
<div class="section">
    <div class="container" style="max-width:480px;">

        <h5 class="mt-3">Artikel Properti</h5>

        {{-- CATEGORY NAVIGATION --}}
        <div class="mb-3 d-flex gap-2 overflow-auto">

            @foreach($categories as $cat)
            <a href="/article/category/{{ $cat->slug }}"
                class="btn btn-sm btn-outline-primary">
                {{ $cat->name }}
            </a>
            @endforeach

        </div>

        {{-- LIST ARTIKEL --}}
        @foreach($articles as $article)

        <a href="/article/{{ $article->slug }}"
            style="text-decoration:none; color:inherit;">

            <div class="card mb-2">

                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                    style="height:120px; object-fit:cover; border-radius: 5px 5px 0 0;">

                <div class="card-body">

                    <div style="font-size:14px; font-weight:600;">
                        {{ $article->title }}
                    </div>

                </div>

            </div>

        </a>

        @endforeach
        {{ $articles->links() }}

    </div>
</div>
@endsection