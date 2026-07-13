@extends('layouts.admin')

@section('title', 'Profil gestionnaire')

@section('content')
<div class="bg-white rounded-10 p-24">
    <div class="d-flex align-items-center justify-content-between mb-24">
        <div>
            <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Mon profil</h4>
            <p class="text-neutral-400 mt-8">Informations de votre compte gestionnaire.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="mb-16">
                <span class="text-12 text-neutral-400 d-block mb-2">Nom complet</span>
                <p class="fw-medium text-14 text-neutral-600">{{ $user->first_name }} {{ $user->last_name }}</p>
            </div>
            <div class="mb-16">
                <span class="text-12 text-neutral-400 d-block mb-2">Email</span>
                <p class="fw-medium text-14 text-neutral-600">{{ $user->email }}</p>
            </div>
            <div class="mb-16">
                <span class="text-12 text-neutral-400 d-block mb-2">Rôle</span>
                <p class="fw-medium text-14 text-neutral-600">{{ ucfirst($user->role) }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-16">
                <span class="text-12 text-neutral-400 d-block mb-2">Téléphone</span>
                <p class="fw-medium text-14 text-neutral-600">{{ $user->phone ?? '—' }}</p>
            </div>
            <div class="mb-16">
                <span class="text-12 text-neutral-400 d-block mb-2">Ville</span>
                <p class="fw-medium text-14 text-neutral-600">{{ $user->city ?? '—' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
