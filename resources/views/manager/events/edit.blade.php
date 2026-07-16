@extends('layouts.admin')

@section('title', 'Modifier l\'événement')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Modifier l'événement</h4>
</div>

<form action="{{ route('manager.events.update', $event) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-4">
            {{-- Titles --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Titre (EN) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $event->title_en) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Titre (FR) <span class="text-danger">*</span></label>
                <input type="text" name="title_fr" class="form-control" value="{{ old('title_fr', $event->title_fr) }}" required>
            </div>

            {{-- Short descriptions --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Brève description (EN)</label>
                <textarea name="short_description_en" rows="2" class="form-control">{{ old('short_description_en', $event->short_description_en) }}</textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Brève description (FR)</label>
                <textarea name="short_description_fr" rows="2" class="form-control">{{ old('short_description_fr', $event->short_description_fr) }}</textarea>
            </div>

            {{-- Full content --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Contenu (EN) <span class="text-danger">*</span></label>
                <textarea name="content_en" rows="10" class="form-control" required>{{ old('content_en', $event->content_en) }}</textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Contenu (FR) <span class="text-danger">*</span></label>
                <textarea name="content_fr" rows="10" class="form-control" required>{{ old('content_fr', $event->content_fr) }}</textarea>
            </div>

            {{-- Dates & times --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Date de début <span class="text-danger">*</span></label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d') : '') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label text-14 fw-medium">Heure début</label>
                <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $event->start_time) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Date de fin</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-14 fw-medium">Heure fin</label>
                <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $event->end_time) }}">
            </div>

            {{-- Location & video --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Lieu</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}">
            </div>
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">URL vidéo (YouTube, Vimeo...)</label>
                <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $event->video_url) }}">
                <small class="text-neutral-400 text-12">Laissez vide si aucune vidéo.</small>
            </div>

            {{-- Cover image --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Image de couverture</label>
                @if($event->cover_image)
                    <div class="mb-8">
                        <img src="{{ asset('storage/' . $event->cover_image) }}" alt="Current cover" class="rounded-8" style="height: 80px; object-fit: cover">
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

            {{-- Publication status --}}
            <div class="col-md-12">
                <div class="form-check">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" {{ old('is_published', $event->is_published) ? 'checked' : '' }}>
                    <label class="form-check-label text-14" for="is_published">Publié (visible sur le site)</label>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-12 justify-content-end">
        <a href="{{ route('manager.events.show', $event) }}" class="btn btn-outline-secondary rounded-pill px-24">Annuler</a>
        <button type="submit" class="btn bg-main-600 text-white rounded-pill px-24">Mettre à jour</button>
    </div>
</form>
@endsection