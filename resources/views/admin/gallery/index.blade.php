@extends('layouts.admin')

@section('title', 'Albums photo')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Albums photo</h4>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-main rounded-pill"><i class="ph ph-plus-circle"></i> Nouvel album</a>
</div>

<div class="bg-white rounded-10 p-24">
    @if($albums->count())
    <div class="row g-4">
        @foreach($albums as $album)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-10 overflow-hidden">
                @if($album->cover_image)
                <img src="{{ asset('storage/'.$album->cover_image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                @else
                <div class="bg-main-25 d-flex align-items-center justify-content-center" style="height: 180px;">
                    <i class="ph ph-image text-main-600 text-40"></i>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $album->title }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($album->description, 60) }}</p>
                    <p class="mb-2"><i class="ph ph-image"></i> {{ $album->images->count() }} image(s)</p>
                </div>
                <div class="card-footer bg-transparent border-0 d-flex gap-8 pb-16">
                    <a href="{{ route('admin.gallery.show', $album) }}" class="btn btn-sm btn-outline-secondary rounded-pill"><i class="ph ph-eye"></i> Voir</a>
                    <a href="{{ route('admin.gallery.edit', $album) }}" class="btn btn-sm btn-outline-secondary rounded-pill"><i class="ph ph-pencil"></i> Éditer</a>
                    <form action="{{ route('admin.gallery.destroy', $album) }}" method="POST" onsubmit="return confirm('Supprimer cet album ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="ph ph-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-24 d-flex justify-content-end">
        {{ $albums->links() }}
    </div>
    @else
    <div class="text-center py-40">
        <i class="ph ph-images text-60 text-muted mb-16"></i>
        <p class="text-muted">Aucun album. <a href="{{ route('admin.gallery.create') }}">Créez le premier album</a></p>
    </div>
    @endif
</div>
@endsection