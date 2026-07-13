@extends('layouts.admin')

@section('title', 'Détail de l événement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <div>
        <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $event->title_en ?? $event->title }}</h4>
    </div>
    <a href="{{ route('gestionnaire.events.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    @if($event->cover_image)
        <div class="mb-24"><img src="{{ asset('storage/' . $event->cover_image) }}" alt="Cover" class="rounded-10 w-100" style="max-height:360px;object-fit:cover;"></div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <p><strong>Date :</strong> {{ optional($event->start_date)->format('d/m/Y') }} {{ $event->start_time ? $event->start_time : '' }}</p>
            <p><strong>Lieu :</strong> {{ $event->location ?: '—' }}</p>
            <p><strong>Statut :</strong> {{ $event->is_published ? 'Publié' : 'Brouillon' }}</p>
            <p><strong>Publié le :</strong> {{ optional($event->created_at)->format('d/m/Y') }}</p>
        </div>
        <div class="col-md-8">
            <h6 class="mb-12">Description EN</h6>
            <div class="mb-24 text-neutral-600">{!! nl2br(e($event->content_en)) !!}</div>
            <h6 class="mb-12">Description FR</h6>
            <div class="text-neutral-600">{!! nl2br(e($event->content_fr)) !!}</div>
        </div>
    </div>
</div>
@endsection
