@extends('layouts.admin')

@section('title', 'Modifier l\'article')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Modifier l'article</h4>
</div>


@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Veuillez corriger les erreurs suivantes :</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('manager.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-4">
            {{-- Category --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Catégorie</label>
                <select name="blog_category_id" class="form-select">
                    <option value="">-- Aucune --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('blog_category_id', $blog->blog_category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->slug }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Statut</label>
                <select name="status" class="form-select" required>
                    <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="archived" {{ old('status', $blog->status) == 'archived' ? 'selected' : '' }}>Archivé</option>
                </select>
            </div>

            {{-- Published at --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Date de publication</label>
                <input type="datetime-local" name="published_at" class="form-control"
                       value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">
            </div>

            {{-- Cover image --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Image de couverture</label>
                @if($blog->cover_image)
                    <div class="mb-8">
                        <img src="{{ asset('storage/' . $blog->cover_image) }}" alt="Current cover" class="rounded-8" style="height: 60px; object-fit: cover">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="remove_cover" id="remove_cover" value="1">
                            <label class="form-check-label text-12 text-neutral-500" for="remove_cover">
                                Supprimer l'image actuelle
                            </label>
                        </div>
                    </div>
                @endif
                <input type="file" name="cover_image" class="form-control" accept="image/*">
                <small class="text-neutral-400 text-12">Laissez vide pour conserver l'image actuelle.</small>
            </div>

            {{-- Titles --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Titre (EN) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $blog->title_en) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Titre (FR) <span class="text-danger">*</span></label>
                <input type="text" name="title_fr" class="form-control" value="{{ old('title_fr', $blog->title_fr) }}" required>
            </div>

            {{-- Excerpts --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Extrait (EN)</label>
                <textarea name="excerpt_en" rows="2" class="form-control">{{ old('excerpt_en', $blog->excerpt_en) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Extrait (FR)</label>
                <textarea name="excerpt_fr" rows="2" class="form-control">{{ old('excerpt_fr', $blog->excerpt_fr) }}</textarea>
            </div>

            {{-- Content --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Contenu (EN) <span class="text-danger">*</span></label>
                <textarea name="content_en" rows="10" class="form-control" required>{{ old('content_en', $blog->content_en) }}</textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Contenu (FR) <span class="text-danger">*</span></label>
                <textarea name="content_fr" rows="10" class="form-control" required>{{ old('content_fr', $blog->content_fr) }}</textarea>
            </div>

            {{-- Meta descriptions --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Meta description (EN)</label>
                <textarea name="meta_description_en" rows="2" class="form-control">{{ old('meta_description_en', $blog->meta_description_en) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Meta description (FR)</label>
                <textarea name="meta_description_fr" rows="2" class="form-control">{{ old('meta_description_fr', $blog->meta_description_fr) }}</textarea>
            </div>
        </div>
    </div>

    <div class="d-flex gap-12 justify-content-end">
        <a href="{{ route('manager.blogs.show', $blog) }}" class="btn btn-outline-secondary rounded-pill px-24">Annuler</a>
        <button type="submit" class="btn bg-main-600 text-white rounded-pill px-24">Mettre à jour</button>
    </div>
</form>
@endsection