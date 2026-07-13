@extends('layouts.admin')

@section('title', 'Détail du message')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Détail du message</h4>
    <a href="{{ route('gestionnaire.contact-messages.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row mb-20">
        <div class="col-md-6">
            <p><strong>De :</strong> {{ $message->full_name }}</p>
            <p><strong>Email :</strong> {{ $message->email }}</p>
            <p><strong>Téléphone :</strong> {{ $message->phone ?? '—' }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Reçu le :</strong> {{ $message->created_at }}</p>
            <p><strong>IP :</strong> {{ $message->ip_address ?? '—' }}</p>
            <p><strong>Statut :</strong>
                @if($message->status == 'new')
                    <span class="badge bg-warning-600">Non lu</span>
                @elseif($message->status == 'read')
                    <span class="badge bg-success-600">Lu</span>
                @else
                    <span class="badge bg-neutral-400">Archivé</span>
                @endif
            </p>
        </div>
    </div>
    <hr>
    <div class="mt-16">
        <h6><strong>Sujet :</strong> {{ $message->subject }}</h6>
        <div class="mt-16 p-16 bg-main-25 rounded-10">
            <p class="mb-0">{!! nl2br(e($message->message)) !!}</p>
        </div>
    </div>
</div>

<div class="d-flex gap-12 justify-content-end">
    @if($message->status == 'new')
        <form action="{{ route('gestionnaire.contact-messages.mark-read', $message) }}" method="POST">
            @csrf @method('PATCH')
            <button class="btn bg-success-600 rounded-pill px-24">Marquer comme lu</button>
        </form>
    @else
        <form action="{{ route('gestionnaire.contact-messages.mark-unread', $message) }}" method="POST">
            @csrf @method('PATCH')
            <button class="btn bg-warning-600 rounded-pill px-24">Marquer non lu</button>
        </form>
    @endif
    <form action="{{ route('gestionnaire.contact-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Supprimer ce message ?')">
        @csrf @method('DELETE')
        <button class="btn bg-danger-600 rounded-pill px-24">Supprimer</button>
    </form>
</div>
@endsection
