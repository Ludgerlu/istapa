@extends('layouts.admin')

@section('title', 'Créer un événement')

@section('content')
<div class="mb-24"><h4>Nouvel événement</h4></div>
<form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-4">
            <div class="col-md-6"><label>Titre (EN)</label><input type="text" name="title_en" class="form-control" required></div>
            <div class="col-md-6"><label>Titre (FR)</label><input type="text" name="title_fr" class="form-control" required></div>
            <div class="col-md-6"><label>Date de début</label><input type="date" name="start_date" class="form-control" required></div>
            <div class="col-md-3"><label>Heure début</label><input type="time" name="start_time" class="form-control"></div>
            <div class="col-md-6"><label>Date de fin</label><input type="date" name="end_date" class="form-control"></div>
            <div class="col-md-3"><label>Heure fin</label><input type="time" name="end_time" class="form-control"></div>
            <div class="col-md-12"><label>Lieu</label><input type="text" name="location" class="form-control"></div>
            <div class="col-md-12"><label>URL vidéo (YouTube/Vimeo)</label><input type="url" name="video_url" class="form-control"></div>
            <div class="col-md-12"><label>Image de couverture</label><input type="file" name="cover_image" class="form-control"></div>
            <div class="col-md-12"><label>Brève description (EN)</label><textarea name="short_description_en" rows="2" class="form-control"></textarea></div>
            <div class="col-md-12"><label>Brève description (FR)</label><textarea name="short_description_fr" rows="2" class="form-control"></textarea></div>
            <div class="col-md-12"><label>Contenu (EN)</label><textarea name="content_en" rows="8" class="form-control" required></textarea></div>
            <div class="col-md-12"><label>Contenu (FR)</label><textarea name="content_fr" rows="8" class="form-control" required></textarea></div>
            <div class="col-md-12"><div class="form-check"><input type="checkbox" name="is_published" value="1" class="form-check-input"> Publié</div></div>
        </div>
    </div>
    <div class="d-flex gap-12 justify-content-end"><a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Annuler</a><button type="submit" class="btn bg-main-600 text-white">Créer</button></div>
</form>
@endsection