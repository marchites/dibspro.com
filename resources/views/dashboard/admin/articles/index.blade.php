@extends('dashboard.layouts.app')

@section('title', 'Kelola Artikel')

@section('content')

<div class="section">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div style="font-weight:700;">
            Kelola Artikel
        </div>

        <a href="/dashboard/articles/create"
           class="btn btn-primary btn-sm">
            Tambah
        </a>

    </div>

    @foreach($articles as $article)

        <div class="card-box mb-2">

            <div class="d-flex gap-3">

                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                     style="width:80px; height:80px; object-fit:cover; border-radius:10px;">

                <div style="flex:1;">

                    <div style="font-size:14px; font-weight:600;">
                        {{ $article->title }}
                    </div>

                    <div style="font-size:12px; color:#777; margin-top:4px;">
                        {{ $article->created_at->format('d M Y') }}
                    </div>

                    <div class="mt-2 d-flex gap-2">

                        <a href="/dashboard/articles/{{ $article->id }}/edit"
                           class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>

                        <form action="/dashboard/articles/{{ $article->id }}/delete"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-outline-danger">
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

    <div class="mt-3">
        {{ $articles->links() }}
    </div>

</div>

@endsection