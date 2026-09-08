@extends('layouts.admin')

@section('title', 'Demande d\'admission - ' . $admission->first_name . ' ' . $admission->last_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">
        Demande #{{ $admission->reference_code }}
    </h4>
    <div>
        <a href="{{ route('admin.admissions.index') }}" class="btn bg-main-600 rounded-pill">
            <i class="ph ph-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<div class="row">
    {{-- Left column: Personal info & program --}}
    <div class="col-lg-8">
        <div class="bg-white rounded-10 p-24 mb-24">
            <h5 class="mb-20">Informations personnelles</h5>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Nom complet</div>
                <div class="col-md-8">{{ $admission->first_name }} {{ $admission->last_name }}</div>
            </div>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Email</div>
                <div class="col-md-8">{{ $admission->email }}</div>
            </div>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Téléphone</div>
                <div class="col-md-8">{{ $admission->phone }}</div>
            </div>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Date de naissance</div>
                <div class="col-md-8">{{ $admission->birth_date ? $admission->birth_date->format('d/m/Y') : '—' }}</div>
            </div>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Genre</div>
                <div class="col-md-8">{{ ucfirst($admission->gender ?? '—') }}</div>
            </div>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Adresse</div>
                <div class="col-md-8">{{ $admission->address ?: '—' }}</div>
            </div>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Ville / Pays</div>
                <div class="col-md-8">{{ $admission->city ?: '—' }} @if($admission->country) ({{ $admission->country }}) @endif</div>
            </div>
        </div>

        <div class="bg-white rounded-10 p-24 mb-24">
            <h5 class="mb-20">Cursus & motivation</h5>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Programme demandé</div>
                <div class="col-md-8">{{ $admission->program->title ?? 'Non spécifié' }}</div>
            </div>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Établissement précédent</div>
                <div class="col-md-8">{{ $admission->previous_school ?: '—' }}</div>
            </div>
            <div class="row mb-16">
                <div class="col-md-4 fw-semibold">Diplôme précédent</div>
                <div class="col-md-8">{{ $admission->previous_diploma ?: '—' }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 fw-semibold">Lettre de motivation</div>
                <div class="col-md-8">{{ $admission->motivation ? nl2br(e($admission->motivation)) : '—' }}</div>
            </div>
        </div>

        @if($admission->documents->count())
        <div class="bg-white rounded-10 p-24">
            <h5 class="mb-20">Documents joints</h5>
            <div class="list-group">
                @foreach($admission->documents as $doc)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="ph ph-file-text me-2"></i> {{ $doc->document_type ?? 'Document' }}
                        @if($doc->original_name) <span class="text-muted">({{ $doc->original_name }})</span> @endif
                    </div>
                    @if($doc->file_path && Storage::disk('public')->exists($doc->file_path))
                        <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="ph ph-download"></i> Télécharger
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Right column: Status & actions --}}
    <div class="col-lg-4">
        <div class="bg-white rounded-10 p-24 mb-24">
            <h5 class="mb-20">Statut</h5>
            <div class="mb-16">
                @if($admission->status == 'pending')
                    <span class="badge bg-warning-600 fs-14 px-16 py-8">En attente</span>
                @elseif($admission->status == 'approved')
                    <span class="badge bg-success-600 fs-14 px-16 py-8">Approuvé</span>
                @else
                    <span class="badge bg-danger-600 fs-14 px-16 py-8">Refusé</span>
                @endif
            </div>
            <div class="mb-16">
                <strong>Date de la demande :</strong><br>
                {{ $admission->created_at->format('d/m/Y à H:i') }}
            </div>
            @if($admission->reviewed_at)
            <div class="mb-16">
                <strong>Traitée le :</strong><br>
                {{ $admission->reviewed_at->format('d/m/Y à H:i') }}
            </div>
            <div class="mb-16">
                <strong>Traitée par :</strong><br>
                {{ $admission->reviewer->name ?? '—' }}
            </div>
            @endif
            @if($admission->status_comment)
            <div class="mb-16">
                <strong>Commentaire du traitement :</strong><br>
                {{ $admission->status_comment }}
            </div>
            @endif
        </div>

        @if($admission->status == 'pending')
        <div class="bg-white rounded-10 p-24">
            <h5 class="mb-20">Actions</h5>
            <div class="d-flex gap-12 flex-column">
                <button type="button" class="btn bg-main-600 rounded-pill py-12" data-bs-toggle="modal" data-bs-target="#approveModal">
                    <i class="ph ph-check"></i> Approuver la demande
                </button>
                <button type="button" class="btn bg-danger-600 rounded-pill py-12" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="ph ph-x"></i> Refuser la demande
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Approve Modal --}}
@if($admission->status == 'pending')
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.admissions.approve', $admission) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-success-100">
                    <h5 class="modal-title">Approuver la demande</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Vous allez approuver la demande de <strong>{{ $admission->first_name }} {{ $admission->last_name }}</strong>.</p>
                    <div class="mb-3">
                        <label>Commentaire (optionnel)</label>
                        <textarea name="comment" class="form-control" rows="2" placeholder="Ajouter une note..."></textarea>
                    </div>
                    <p class="small text-muted mb-0">Un compte utilisateur sera créé pour l'étudiant (si configuré).</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning-600" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success-600">Confirmer l'approbation</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.admissions.reject', $admission) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-danger-100">
                    <h5 class="modal-title">Refuser la demande</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Vous allez refuser la demande de <strong>{{ $admission->first_name }} {{ $admission->last_name }}</strong>.</p>
                    <div class="mb-3">
                        <label>Motif du refus <span class="text-danger">*</span></label>
                        <textarea name="comment" class="form-control" rows="3" required placeholder="Expliquez la raison du refus..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-600" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger-600">Confirmer le refus</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@section('additional-scripts')
<script>
    // If you need to automatically refresh page after modal action, optional.
</script>
@endsection
@endsection