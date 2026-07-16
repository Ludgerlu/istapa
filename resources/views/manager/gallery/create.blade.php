@extends('layouts.admin')
@section('title', 'Créer un album')
@section('content')
<div class="mb-24"><h4>Nouvel album photo</h4></div>
<form action="{{ route('manager.gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="bg-white rounded-10 p-24">
        <div class="row g-3">
            <div class="col-md-6"><label>Titre (EN) *</label><input type="text" name="title_en" class="form-control" required></div>
            <div class="col-md-6"><label>Titre (FR) *</label><input type="text" name="title_fr" class="form-control" required></div>
            <div class="col-md-12"><label>Description (EN)</label><textarea name="description_en" rows="3" class="form-control"></textarea></div>
            <div class="col-md-12"><label>Description (FR)</label><textarea name="description_fr" rows="3" class="form-control"></textarea></div>
            <div class="col-md-6"><label>Image de couverture</label><input type="file" name="cover_image" class="form-control" accept="image/*"></div>
            <div class="col-md-6"><label>Ordre de tri</label><input type="number" name="sort_order" class="form-control" value="0"></div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24">
        <a href="{{ route('manager.gallery.index') }}" class="btn btn-outline-secondary rounded-pill">Annuler</a>
        <button type="submit" class="btn btn-main rounded-pill">Créer l'album</button>
    </div>
</form>
@endsection