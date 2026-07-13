@extends('layouts.admin')

@section('title', 'Créer un article')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Nouvel article</h4>
</div>

<form action="{{ route('gestionnaire.blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-4">
            <div class="col-md-6">
                <label>Titre (EN)</label>
                <input type="text" name="title_en" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Titre (FR)</label>
                <input type="text" name="title_fr" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Catégorie</label>
                <select name="blog_category_id" class="form-select">
                    <option value="">Aucune</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label>Extrait (EN)</label>
                <textarea name="excerpt_en" rows="3" class="form-control"></textarea>
            </div>
            <div class="col-md-12">
                <label>Extrait (FR)</label>
                <textarea name="excerpt_fr" rows="3" class="form-control"></textarea>
            </div>
            <div class="col-md-12">
                <label>Contenu (EN)</label>
                <textarea name="content_en" rows="6" class="form-control" required></textarea>
            </div>
            <div class="col-md-12">
                <label>Contenu (FR)</label>
                <textarea name="content_fr" rows="6" class="form-control" required></textarea>
            </div>
            <div class="col-md-12">
                <label>Image de couverture</label>
                <input type="file" name="cover_image" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Statut</label>
                <select name="status" class="form-select" required>
                    <option value="draft">Brouillon</option>
                    <option value="published">Publié</option>
                    <option value="archived">Archivé</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Date de publication</label>
                <input type="date" name="published_at" class="form-control">
            </div>
        </div>
    </div>
    <div class="d-flex gap-12 justify-content-end">
        <a href="{{ route('gestionnaire.blogs.index') }}" class="btn btn-outline-secondary">Annuler</a>
        <button type="submit" class="btn bg-main-600 text-white">Créer</button>
    </div>
</form>
@endsection
