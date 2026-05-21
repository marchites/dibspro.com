@extends('layouts.app')
@section('title', 'DibsPro - ' . $article->title)

<title>{{ $article->title }}</title>

<meta name="description" content="{{ Str::limit(strip_tags($article->content), 150) }}">
<meta property="og:title" content="{{ $article->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($article->content), 150) }}">
<meta property="og:image" content="{{ asset('storage/' . $article->thumbnail) }}">

@push('styles')
<link rel="stylesheet" href="{{ asset('build/assets/css/article.css') }}">
@endpush

@section('content')
<div class="app-container">

    {{-- THUMBNAIL --}}
    <img src="{{ asset('storage/' . $article->thumbnail) }}" style="width:100%; height:200px; object-fit:cover;">

    {{-- CONTENT --}}
    <div class="content">

        <h5>{{ $article->title }}</h5>

        <span class="badge bg-primary">
            {{ $article->category->name ?? 'Umum' }}
        </span>

        <div style="font-size:12px; color:#777;" class="mb-2">
            {{ $article->created_at->format('d M Y') }}
        </div>

        <p>
            {!! nl2br(e($article->content)) !!}
        </p>

    </div>

</div>
@endsection