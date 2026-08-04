@extends('layouts.admin')

@section('title', $program->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $program->title }}</h4>
    <div>
        <a href="{{ route('manager.programs.index') }}" class="btn bg-main-600 text-white rounded-pill">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="bg-white rounded-10 p-24">
    <div class="row g-4">
        {{-- Cover image --}}
        @if($program->cover_image)
            <div class="col-md-4">
                <img src="{{ asset('storage/' . $program->cover_image) }}" alt="Cover" class="img-fluid rounded-8">
            </div>
            <div class="col-md-8">
        @else
            <div class="col-md-12">
        @endif
            <dl class="row">
                <dt class="col-sm-3">Titre (EN)</dt>
                <dd class="col-sm-9">{{ $program->title_en }}</dd>

                <dt class="col-sm-3">Titre (FR)</dt>
                <dd class="col-sm-9">{{ $program->title_fr }}</dd>

                <dt class="col-sm-3">Durée</dt>
                <dd class="col-sm-9">{{ $program->duration_months ? $program->duration_months . ' mois' : '—' }}</dd>

                <dt class="col-sm-3">Statut</dt>
                <dd class="col-sm-9">
                    @if($program->is_published)
                        <span class="badge bg-success">Publié</span>
                    @else
                        <span class="badge bg-secondary">Brouillon</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Ordre</dt>
                <dd class="col-sm-9">{{ $program->sort_order }}</dd>

                <dt class="col-sm-3">Vues</dt>
                <dd class="col-sm-9">{{ $program->view_count ?? 0 }}</dd>

                <dt class="col-sm-3">Slug</dt>
                <dd class="col-sm-9"><code>{{ $program->slug }}</code></dd>

                <dt class="col-sm-3">Brève description (EN)</dt>
                <dd class="col-sm-9">{{ $program->short_description_en ?: '—' }}</dd>

                <dt class="col-sm-3">Brève description (FR)</dt>
                <dd class="col-sm-9">{{ $program->short_description_fr ?: '—' }}</dd>

                <dt class="col-sm-3">Contenu (EN)</dt>
                <dd class="col-sm-9">{!! $program->content_en !!}</dd>

                <dt class="col-sm-3">Contenu (FR)</dt>
                <dd class="col-sm-9">{!! $program->content_fr !!}</dd>
            </dl>
        </div>
    </div>
</div>

@endsection