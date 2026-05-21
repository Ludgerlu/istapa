@extends('layouts.admin')

@section('title', $album->title)

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>{{ $album->title }}</h4>
    <div>
        <a href="{{ route('admin.gallery.edit', $album) }}" class="btn btn-main rounded-pill"><i class="ph ph-pencil"></i> Modifier</a>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary rounded-pill">Retour</a>
    </div>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row">
        @if($album->cover_image)
        <div class="col-md-3">
            <img src="{{ asset('storage/'.$album->cover_image) }}" class="img-fluid rounded-10">
        </div>
        <div class="col-md-9">
        @else
        <div class="col-12">
        @endif
            <p><strong>Description (EN):</strong> {{ $album->description_en ?: '—' }}</p>
            <p><strong>Description (FR):</strong> {{ $album->description_fr ?: '—' }}</p>
            <p><strong>Ordre :</strong> {{ $album->sort_order ?? '—' }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-10 p-24">
    <div class="d-flex justify-content-between align-items-center mb-20">
        <h5>Images de l'album ({{ $album->images->count() }})</h5>
        <button type="button" class="btn btn-outline-main rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
            <i class="ph ph-plus-circle"></i> Ajouter des images
        </button>
    </div>

    @if($album->images->count())
    <div class="sortable-images" data-reorder-url="{{ route('admin.gallery.images.reorder') }}">
        <div class="row g-3">
            @foreach($album->images->sortBy('sort_order') as $image)
            <div class="col-md-3 gallery-item" data-id="{{ $image->id }}">
                <div class="card h-100 border-0 shadow-sm rounded-10 overflow-hidden">
                    <img src="{{ asset('storage/'.$image->image_path) }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                    <div class="card-body p-12">
                        <p class="small text-muted mb-2">{{ $image->caption ?: 'Sans légende' }}</p>
                        <p class="small text-muted mb-2"><i class="ph ph-user"></i> {{ $image->uploader->name ?? '—' }}</p>
                        <form action="{{ route('admin.gallery.images.destroy', $image) }}" method="POST" onsubmit="return confirm('Supprimer cette image ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100 rounded-pill"><i class="ph ph-trash"></i> Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <p class="mt-3 text-muted small"><i class="ph ph-drag"></i> Glissez-déposez les images pour les réorganiser</p>
    @else
    <div class="alert alert-light text-center py-40">
        <i class="ph ph-image text-60 text-muted mb-8 d-block"></i>
        Aucune image dans cet album. Ajoutez-en maintenant.
    </div>
    @endif
</div>

{{-- Modal for uploading images --}}
<div class="modal fade" id="uploadImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.gallery.images.store', $album) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-main-25">
                    <h5 class="modal-title">Ajouter une image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Fichier image *</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label>Légende (optionnelle)</label>
                        <input type="text" name="caption" class="form-control" placeholder="Description de l'image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-main">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.sortable-images .row');
        if (container) {
            new Sortable(container, {
                animation: 150,
                handle: '.gallery-item',
                onEnd: function() {
                    let order = [];
                    document.querySelectorAll('.gallery-item').forEach((item, idx) => {
                        order.push(item.dataset.id);
                    });
                    const reorderUrl = container.closest('.sortable-images').dataset.reorderUrl;
                    fetch(reorderUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    }).then(response => response.json()).then(data => {
                        if (data.success) console.log('Reorder saved');
                    });
                }
            });
        }
    });
</script>
@endpush