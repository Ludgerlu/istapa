{{-- resources/views/manager/programs/show.blade.php --}}
@extends('layouts.admin')

@section('title', $program->title)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-24 flex-wrap gap-12">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $program->title }}</h4>
    <div class="d-flex gap-8">
        <a href="{{ route('manager.programs.edit', $program) }}" class="btn bg-main-600 text-white rounded-pill px-20">
            <i class="ph ph-pencil"></i> Modifier
        </a>
        <form action="{{ route('manager.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce programme ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn bg-warning-100 text-warning-600 rounded-pill px-20">
                <i class="ph ph-trash"></i> Supprimer
            </button>
        </form>
    </div>
</div>

{{-- Program details card --}}
<div class="bg-white rounded-10 p-24 mb-32">
    <div class="row">
        @if($program->cover_image)
        <div class="col-md-4 mb-3 mb-md-0">
            <img src="{{ asset('storage/' . $program->cover_image) }}" class="img-fluid rounded-10" alt="Cover">
        </div>
        <div class="col-md-8">
        @else
        <div class="col-12">
        @endif
            <div class="d-flex flex-wrap gap-16 align-items-center mb-16">
                <span class="badge {{ $program->is_published ? 'bg-success-100 text-success-600' : 'bg-neutral-100 text-neutral-500' }}">
                    {{ $program->is_published ? 'Publié' : 'Brouillon' }}
                </span>
                <span class="text-13 text-neutral-400">Vues : {{ $program->view_count ?? 0 }}</span>
                <span class="text-13 text-neutral-400">Durée : {{ $program->duration_months ?? '—' }} mois</span>
                <span class="text-13 text-neutral-400">Ordre : {{ $program->sort_order ?? '—' }}</span>
            </div>

            <div class="content text-neutral-600 mb-16">
                <strong>Diplôme :</strong>
                <p>{{ $program->degree_name ?: 'Non défini' }}</p>
                <strong>Description du diplôme :</strong>
                <p>{{ $program->degree_description ?: '—' }}</p>
            </div>

            <div class="content text-neutral-600 mb-16">
                <strong>Certificats requis :</strong>
                @if($program->certificates->count())
                    <ul>
                        @foreach($program->certificates as $cert)
                            <li>{{ $cert->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucun certificat spécifié.</p>
                @endif
            </div>

            <div class="content text-neutral-600 mb-16">
                <strong>Brève description (EN) :</strong>
                <p>{{ $program->short_description_en }}</p>
                <strong>Brève description (FR) :</strong>
                <p>{{ $program->short_description_fr }}</p>
            </div>

            <div class="content text-neutral-600 mb-16">
                <strong>Contenu (EN) :</strong>
                <div>{!! $program->content_en !!}</div>
            </div>
            <div class="content text-neutral-600 mb-16">
                <strong>Contenu (FR) :</strong>
                <div>{!! $program->content_fr !!}</div>
            </div>
        </div>
    </div>
</div>

{{-- Gallery management --}}
<div class="bg-white rounded-10 p-24">
    <div class="d-flex align-items-center justify-content-between mb-20 flex-wrap gap-12">
        <h5 class="fw-semibold text-16 mb-0">Galerie d'images</h5>
        <span class="text-12 text-neutral-400">{{ $program->images->count() }} image(s)</span>
    </div>

    {{-- Upload form --}}
    <form action="{{ route('manager.programs.storeImage', $program) }}" method="POST" enctype="multipart/form-data" class="mb-30">
        @csrf
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-14">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-3">
                <label class="form-label text-14">Texte alternatif (EN)</label>
                <input type="text" name="alt_en" class="form-control" placeholder="Description en anglais">
            </div>
            <div class="col-md-3">
                <label class="form-label text-14">Texte alternatif (FR)</label>
                <input type="text" name="alt_fr" class="form-control" placeholder="Description en français">
            </div>
            <div class="col-md-1">
                <label class="form-label text-14">Couverture</label>
                <div class="form-check mt-1">
                    <input class="form-check-input" type="checkbox" name="is_cover" value="1" id="is_cover">
                    <label class="form-check-label" for="is_cover">Oui</label>
                </div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn bg-main-600 text-white w-100 rounded-pill">
                    <i class="ph ph-plus-circle"></i> Ajouter
                </button>
            </div>
        </div>
    </form>

    {{-- Sortable gallery list --}}
    @if($program->images->count())
    <div class="sortable-images" data-reorder-url="{{ route('manager.programs.reorderImages') }}">
        <div class="row g-3">
            @foreach($program->images as $image)
            <div class="col-md-3 gallery-item" data-id="{{ $image->id }}">
                <div class="card h-100 shadow-sm border-0 rounded-10 overflow-hidden">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                    <div class="card-body p-12">
                        @if($image->is_cover)
                            <span class="badge bg-primary mb-8">Couverture</span>
                        @endif
                        <p class="small text-muted mb-8">{{ $image->alt ?: 'Sans légende' }}</p>
                        <form action="{{ route('manager.programs.destroyImage', $image) }}" method="POST" onsubmit="return confirm('Supprimer cette image ?')">
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
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        console.error('Reorder failed');
                    }
                })
                .catch(err => console.error(err));
            }
        });
    }

    // Optional: add compression for gallery image upload (similar to cover)
    // The form action will handle it via normal POST; you can add compression if desired.
});
</script>
@endpush