@extends('layouts.admin')

@section('title', 'Modifier un événement gestionnaire')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Modifier l'événement</h4>
</div>

<form action="{{ route('gestionnaire.events.update', $event) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-4">
            <div class="col-md-6"><label>Titre (EN)</label><input type="text" name="title_en" class="form-control" value="{{ old('title_en', $event->title_en) }}" required></div>
            <div class="col-md-6"><label>Titre (FR)</label><input type="text" name="title_fr" class="form-control" value="{{ old('title_fr', $event->title_fr) }}" required></div>
            <div class="col-md-6"><label>Date de début</label><input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($event->start_date)->format('Y-m-d')) }}" required></div>
            <div class="col-md-3"><label>Heure début</label><input type="time" name="start_time" class="form-control" value="{{ old('start_time', $event->start_time) }}"></div>
            <div class="col-md-6"><label>Date de fin</label><input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($event->end_date)->format('Y-m-d')) }}"></div>
            <div class="col-md-3"><label>Heure fin</label><input type="time" name="end_time" class="form-control" value="{{ old('end_time', $event->end_time) }}"></div>
            <div class="col-md-12"><label>Lieu</label><input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}"></div>
            <div class="col-md-12"><label>URL vidéo</label><input type="url" name="video_url" class="form-control" value="{{ old('video_url', $event->video_url) }}"></div>
            <div class="col-md-12"><label>Image de couverture</label>@if($event->cover_image)<div class="mb-8"><img src="{{ asset('storage/' . $event->cover_image) }}" alt="Cover" class="rounded-8" style="height: 80px; object-fit: cover"></div>@endif<input type="file" name="cover_image" class="form-control"></div>
            <div class="col-md-12"><label>Description courte (EN)</label><textarea name="short_description_en" rows="3" class="form-control">{{ old('short_description_en', $event->short_description_en) }}</textarea></div>
            <div class="col-md-12"><label>Description courte (FR)</label><textarea name="short_description_fr" rows="3" class="form-control">{{ old('short_description_fr', $event->short_description_fr) }}</textarea></div>
            <div class="col-md-12"><label>Contenu (EN)</label><textarea name="content_en" rows="6" class="form-control" required>{{ old('content_en', $event->content_en) }}</textarea></div>
            <div class="col-md-12"><label>Contenu (FR)</label><textarea name="content_fr" rows="6" class="form-control" required>{{ old('content_fr', $event->content_fr) }}</textarea></div>
            <div class="col-md-12"><div class="form-check"><input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" {{ old('is_published', $event->is_published) ? 'checked' : '' }}><label class="form-check-label" for="is_published">Publié</label></div></div>
        </div>
    </div>
    <div class="d-flex gap-12 justify-content-end"><a href="{{ route('gestionnaire.events.index') }}" class="btn btn-outline-secondary">Annuler</a><button type="submit" class="btn bg-main-600 text-white">Mettre à jour</button></div>
</form>
@endsection
