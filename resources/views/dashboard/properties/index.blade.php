@extends('dashboard.layouts.app')

@section('title', 'Kelola Properti')

@section('content')

<div class="section">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <div style="font-weight:700;">
                Kelola Properti
            </div>
        </div>

        <a href="/dashboard/properties/create"
            class="btn btn-primary btn-sm">
            Tambah
        </a>

    </div>

    @foreach($properties as $property)

    <div class="card-box mb-2">

        <div class="d-flex gap-3">

            <div style="width:80px; height:80px; border-radius:10px; overflow:hidden; background:#eee;">

                <div class="property-img"
                    style="background-image:url('{{ $property->images->first()?->image_path
                                ? asset('storage/' . $property->images->first()->image_path)
                                : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1470&auto=format&fit=crop' }}')">
                </div>

            </div>

            <div style="flex:1;">

                <div style="font-size:14px; font-weight:600;">
                    {{ $property->title }}
                </div>

                <div style="font-size:12px; color:#777;">
                    {{ $property->location }}
                </div>

                <div style="font-size:14px; font-weight:700; color:#2c7be5; margin-top:4px;">
                    Rp {{ number_format($property->price,0,',','.') }}
                </div>

                <div class="mt-1">
                    @if($property->status == 'sold')
                    <span class="badge bg-danger">
                        Terjual
                    </span>
                    @else

                    <span class="badge bg-success">
                        Tersedia
                    </span>
                    @endif
                </div>

                <div class="mt-2 d-flex gap-2">

                    <a href="/dashboard/properties/{{ $property->id }}/edit"
                        class="btn btn-sm btn-outline-primary">
                        Edit
                    </a>

                    <form action="/dashboard/properties/{{ $property->id }}/toggle-status"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <button class="btn btn-sm btn-warning">
                            @if($property->status == 'sold')
                            Tandai Tersedia
                            @else
                            Tandai Terjual
                            @endif
                        </button>
                    </form>

                    <form action="/dashboard/properties/{{ $property->id }}/delete"
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
        {{ $properties->links() }}
    </div>

</div>

@endsection