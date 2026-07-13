@extends('layouts.admin')

@section('title', 'Détail de l\'article')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <div>
        <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $blog->title_en ?? $blog->title }}</h4>
        <p class="text-neutral-400 mt-8">{{ Str::limit($blog->excerpt_en ?? $blog->excerpt_fr, 150) }}</p>
    </div>
    <div class="d-flex gap-12">
        <a href="{{ route('gestionnaire.blogs.index') }}" class="btn btn-outline-secondary">Retour</a>
        <a href="{{ route('gestionnaire.blogs.edit', $blog) }}" class="btn bg-main-600 text-white">Modifier</a>
    </div>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <div class="mb-24">
        @if($blog->cover_image)
            <img src="{{ asset('storage/' . $blog->cover_image) }}" alt="Cover" class="rounded-10 w-100" style="max-height:360px;object-fit:cover;">
        @endif
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <p><strong>Auteur :</strong> {{ $blog->author->display_name ?? '—' }}</p>
            <p><strong>Statut :</strong> {{ ucfirst($blog->status) }}</p>
            <p><strong>Publié le :</strong> {{ optional($blog->published_at)->format('d/m/Y') ?: $blog->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="col-md-8">
            <h6 class="mb-12">Contenu EN</h6>
            <div class="mb-24 text-neutral-600">{!! nl2br(e($blog->content_en)) !!}</div>
            <h6 class="mb-12">Contenu FR</h6>
            <div class="text-neutral-600">{!! nl2br(e($blog->content_fr)) !!}</div>
        </div>
    </div>
</div>
@endsection
