@extends('layouts.admin')
@section('title', 'Modifier l\'album')
@section('content')
<div class="mb-24"><h4>Modifier : {{ $album->title }}</h4></div>
<form action="{{ route('admin.gallery.update', $album) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="bg-white rounded-10 p-24">
        <div class="row g-3">
            <div class="col-md-6"><label>Titre (EN) *</label><input type="text" name="title_en" class="form-control" value="{{ old('title_en', $album->title_en) }}" required></div>
            <div class="col-md-6"><label>Titre (FR) *</label><input type="text" name="title_fr" class="form-control" value="{{ old('title_fr', $album->title_fr) }}" required></div>
            <div class="col-md-12"><label>Description (EN)</label><textarea name="description_en" rows="3" class="form-control">{{ old('description_en', $album->description_en) }}</textarea></div>
            <div class="col-md-12"><label>Description (FR)</label><textarea name="description_fr" rows="3" class="form-control">{{ old('description_fr', $album->description_fr) }}</textarea></div>
            <div class="col-md-6">
                <label>Image de couverture</label>
                @if($album->cover_image)
                <div class="mb-8">
                    <img src="{{ asset('storage/'.$album->cover_image) }}" style="height: 80px;" class="rounded-8">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="remove_cover" id="remove_cover" value="1" class="form-check-input">
                        <label class="form-check-label" for="remove_cover">Supprimer l'image actuelle</label>
                    </div>
                </div>
                @endif
                <input type="file" name="cover_image" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6"><label>Ordre de tri</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $album->sort_order) }}"></div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24">
        <a href="{{ route('admin.gallery.show', $album) }}" class="btn btn-outline-secondary rounded-pill">Annuler</a>
        <button type="submit" class="btn btn-main rounded-pill">Mettre à jour</button>
    </div>
</form>
@endsection