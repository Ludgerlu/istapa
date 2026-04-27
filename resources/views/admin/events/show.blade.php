@extends('layouts.admin')

@section('title', $event->title)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-24 flex-wrap gap-12">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $event->title }}</h4>
    <div class="d-flex gap-8">
        <a href="{{ route('admin.events.edit', $event) }}" class="btn bg-main-600 text-white rounded-pill px-20">
            <i class="ph ph-pencil"></i> Modifier
        </a>
        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet événement ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn bg-warning-100 text-warning-600 rounded-pill px-20">
                <i class="ph ph-trash"></i> Supprimer
            </button>
        </form>
    </div>
</div>

{{-- Event details card --}}
<div class="bg-white rounded-10 p-24 mb-32">
    <div class="row">
        @if($event->cover_image)
        <div class="col-md-4 mb-3 mb-md-0">
            <img src="{{ asset('storage/' . $event->cover_image) }}" class="img-fluid rounded-10" alt="Cover">
        </div>
        <div class="col-md-8">
        @else
        <div class="col-12">
        @endif
            <div class="d-flex flex-wrap gap-16 align-items-center mb-16">
                <span class="badge {{ $event->is_published ? 'bg-success-100 text-success-600' : 'bg-neutral-100 text-neutral-500' }}">
                    {{ $event->is_published ? 'Publié' : 'Brouillon' }}
                </span>
                <span class="text-13 text-neutral-400">
                    <i class="ph ph-calendar"></i> 
                    {{ $event->start_date->format('d/m/Y') }}
                    @if($event->start_time) à {{ $event->start_time }} @endif
                    @if($event->end_date)
                        → {{ $event->end_date->format('d/m/Y') }}
                        @if($event->end_time) à {{ $event->end_time }} @endif
                    @endif
                </span>
                @if($event->location)
                <span class="text-13 text-neutral-400">
                    <i class="ph ph-map-pin"></i> {{ $event->location }}
                </span>
                @endif
            </div>
            <div class="content text-neutral-600 mb-16">
                <strong>Brève description :</strong>
                <p>{{ $event->short_description_en }}</p>
                <strong>Contenu :</strong>
                <div>{!! nl2br(e($event->content_en)) !!}</div>
            </div>
            <div class="content text-neutral-600 mb-16">
                <strong>Brève description :</strong>
                <p>{{ $event->short_description_fr }}</p>
                <strong>Contenu :</strong>
                <div>{!! nl2br(e($event->content_fr)) !!}</div>
            </div>
            @if($event->video_url)
            <div class="mt-16">
                <strong>Vidéo :</strong>
                <a href="{{ $event->video_url }}" target="_blank" class="text-main-600">{{ $event->video_url }}</a>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Gallery management section --}}
<div class="bg-white rounded-10 p-24">
    <div class="d-flex align-items-center justify-content-between mb-20 flex-wrap gap-12">
        <h5 class="fw-semibold text-16 mb-0">Galerie d'images</h5>
        <span class="text-12 text-neutral-400">{{ $event->images->count() }} image(s)</span>
    </div>

    {{-- Upload form --}}
    <form action="{{ route('admin.events.storeImage', $event) }}" method="POST" enctype="multipart/form-data" class="mb-30">
        @csrf
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label text-14">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-4">
                <label class="form-label text-14">Légende (optionnelle)</label>
                <input type="text" name="caption" class="form-control" placeholder="Description de l'image">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn bg-main-600 text-white w-100 rounded-pill">
                    <i class="ph ph-plus-circle"></i> Ajouter
                </button>
            </div>
        </div>
    </form>

    {{-- Sortable gallery list --}}
    @if($event->images->count())
    <div class="sortable-images" data-reorder-url="{{ route('admin.events.reorderImages') }}">
        <div class="row g-3">
            @foreach($event->images->sortBy('sort_order') as $image)
            <div class="col-md-3 gallery-item" data-id="{{ $image->id }}">
                <div class="card h-100 shadow-sm border-0 rounded-10 overflow-hidden">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                    <div class="card-body p-12">
                        <p class="small text-muted mb-8">{{ $image->caption ?: 'Sans légende' }}</p>
                        <form action="{{ route('admin.events.destroyImage', $image) }}" method="POST" onsubmit="return confirm('Supprimer cette image ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm bg-warning-100 text-warning-600 w-100 rounded-pill">
                                <i class="ph ph-trash"></i> Supprimer
                            </button>
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
        <i class="ph ph-image text-40 text-muted d-block mb-8"></i>
        Aucune image dans la galerie. Ajoutez-en via le formulaire ci-dessus.
    </div>
    @endif
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
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    });
                }
            });
        }
    });
</script>
@endpush