@extends('layouts.admin')

@section('title', 'Modifier un article')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Modifier l'article</h4>
</div>

<form action="{{ route('gestionnaire.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-4">
            <div class="col-md-6">
                <label>Titre (EN)</label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $blog->title_en) }}" required>
            </div>
            <div class="col-md-6">
                <label>Titre (FR)</label>
                <input type="text" name="title_fr" class="form-control" value="{{ old('title_fr', $blog->title_fr) }}" required>
            </div>
            <div class="col-md-6">
                <label>Catégorie</label>
                <select name="blog_category_id" class="form-select">
                    <option value="">Aucune</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $blog->blog_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label>Extrait (EN)</label>
                <textarea name="excerpt_en" rows="3" class="form-control">{{ old('excerpt_en', $blog->excerpt_en) }}</textarea>
            </div>
            <div class="col-md-12">
                <label>Extrait (FR)</label>
                <textarea name="excerpt_fr" rows="3" class="form-control">{{ old('excerpt_fr', $blog->excerpt_fr) }}</textarea>
            </div>
            <div class="col-md-12">
                <label>Contenu (EN)</label>
                <textarea name="content_en" rows="6" class="form-control" required>{{ old('content_en', $blog->content_en) }}</textarea>
            </div>
            <div class="col-md-12">
                <label>Contenu (FR)</label>
                <textarea name="content_fr" rows="6" class="form-control" required>{{ old('content_fr', $blog->content_fr) }}</textarea>
            </div>
            <div class="col-md-12">
                <label>Image de couverture</label>
                @if($blog->cover_image)
                    <div class="mb-8">
                        <img src="{{ asset('storage/' . $blog->cover_image) }}" alt="Cover image" class="rounded-8" style="height: 80px; object-fit: cover">
                    </div>
                @endif
                <input type="file" name="cover_image" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Statut</label>
                <select name="status" class="form-select" required>
                    <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="archived" {{ $blog->status === 'archived' ? 'selected' : '' }}>Archivé</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Date de publication</label>
                <input type="date" name="published_at" class="form-control" value="{{ optional($blog->published_at)->format('Y-m-d') }}">
            </div>
        </div>
    </div>
    <div class="d-flex gap-12 justify-content-end">
        <a href="{{ route('gestionnaire.blogs.index') }}" class="btn btn-outline-secondary">Annuler</a>
        <button type="submit" class="btn bg-main-600 text-white">Mettre à jour</button>
    </div>
</form>
@endsection
