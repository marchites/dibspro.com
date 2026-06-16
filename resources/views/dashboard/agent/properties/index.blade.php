@extends('dashboard.layouts.agent')
@section('title', 'Kelola Properti')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/property.css') }}">
@endpush

@section('content')
<div class="section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div style="font-weight:700;">
            Kelola Properti
        </div>
        <a href="/agent/properties/create"
            class="btn btn-primary btn-sm">
            Tambah
        </a>
    </div>

    @foreach($properties as $property)
    <div class="card-box mb-2">
        <div class="d-flex gap-3">
            {{-- Thumbnail --}}
            <div
                style="position:relative; width:80px; height:80px; border-radius:10px; overflow:hidden; background:#eee; flex-shrink:0;">
                <img src="{{ $property->images->first()?->image_path ? asset('storage/' . $property->images->first()->image_path) : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1470&auto=format&fit=crop' }}"
                    style="width:100%; height:100%; object-fit:cover;">
                @if($property->video)
                <div
                    style="position:absolute; top:6px; right:6px; background:rgba(0,0,0,.6); color:white; padding:3px 6px; border-radius:6px; font-size:11px;">
                    <i class="bi bi-camera-video-fill"></i>
                </div>
                @endif
            </div>

            {{-- Content --}}
            <div style="flex:1;">
                <div style="font-size:14px; font-weight:600;">
                    {{ $property->title }}
                </div>
                <div style="font-size:12px; color:#777;">
                    {{ $property->location }}
                </div>
                <div style="font-size:12px; color:#999;">
                    Agent:
                    {{ $property->user?->name ?? 'Admin' }}
                </div>
                <div style="font-size:14px; font-weight:700; color:#2c7be5; margin-top:4px;">
                    Rp
                    {{ number_format($property->price, 0, ',', '.') }}
                </div>

                {{-- Status --}}
                <div class="mt-2 d-flex gap-1 flex-wrap">
                    @if($property->status == 'sold')
                    <span class="badge bg-danger">
                        Terjual
                    </span>
                    @else
                    <span class="badge bg-success">
                        Tersedia
                    </span>
                    @endif
                    @if($property->approval_status == 'pending')
                    <span class="badge bg-warning text-dark">
                        Pending Approval
                    </span>
                    <blade
                        elseif|(%24property-%3Eapproval_status%20%3D%3D%20%26%2339%3Bapproved%26%2339%3B)%0D />
                    <span class="badge bg-primary">
                        Approved
                    </span>
                    <blade
                        elseif|(%24property-%3Eapproval_status%20%3D%3D%20%26%2339%3Brejected%26%2339%3B)%0D />
                    <span class="badge bg-secondary">
                        Rejected
                    </span>
                    @endif
                    @if($property->is_featured)
                    <span class="badge bg-warning text-dark">
                        ⭐ Unggulan
                    </span>
                    @endif
                </div>

                {{-- Action --}}
                <div class="mt-3 d-flex gap-2 flex-wrap">
                    <a href="/agent/properties/{{ $property->id }}/edit"
                        class="btn btn-sm btn-outline-primary">
                        Edit
                    </a>
                    <form action="/dashboard/properties/{{ $property->id }}/toggle-status" method="POST">
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

                    @if($property->approval_status == 'pending')
                    <form
                        action="{{ route('admin.properties.approve', $property->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-sm btn-success">
                            Approve
                        </button>
                    </form>

                    <form
                        action="{{ route('admin.properties.reject', $property->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-sm btn-danger">
                            Reject
                        </button>
                    </form>
                    @endif

                    {{-- Delete optional --}}
                    {{--
                        <form action="/dashboard/properties/{{ $property->id }}/delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        Hapus
                    </button>
                    </form>
                    --}}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- PAGINATION --}}
<div class="d-flex justify-content-center mt-4">
    {{ $properties->withQueryString()->links() }}
</div>

@endsection