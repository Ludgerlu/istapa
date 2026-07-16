@extends('layouts.admin')

@section('title', 'Demandes d\'admission')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>Demandes d'admission</h4>
    <div>
        <a href="{{ route('manager.admissions.index') }}" class="btn bg-main-600 rounded-pill">Toutes</a>
        <a href="{{ route('manager.admissions.index', ['status' => 'pending']) }}" class="btn bg-main-600 rounded-pill">En attente</a>
        <a href="{{ route('manager.admissions.index', ['status' => 'approved']) }}" class="btn bg-main-600 rounded-pill">Approuvées</a>
        <a href="{{ route('manager.admissions.index', ['status' => 'rejected']) }}" class="btn bg-main-600 rounded-pill">Refusées</a>
    </div>
</div>

<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label>Rechercher</label>
            <input type="text" name="q" class="form-control" placeholder="Nom, email, référence..." value="{{ request('q') }}">
        </div>
        <div class="col-md-3">
            <label>Statut</label>
            <select name="status" class="form-select">
                <option value="">Tous</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>En attente</option>
                <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approuvé</option>
                <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Refusé</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-main w-100">Filtrer</button>
        </div>
    </form>
</div>

<div class="bg-white rounded-10 p-24">
    <div class="overflow-x-auto">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr><th>Référence</th><th>Nom complet</th><th>Email</th><th>Téléphone</th><th>Programme</th><th>Date</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($admissions as $admission)
                <tr>
                    <td>{{ $admission->reference_code }}</td>
                    <td>{{ $admission->first_name }} {{ $admission->last_name }}</td>
                    <td>{{ $admission->email }}</td>
                    <td>{{ $admission->phone }}</td>
                    <td>{{ $admission->program->name ?? '—' }}</td>
                    <td>{{ $admission->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($admission->status == 'pending')
                            <span class="badge bg-warning-600">En attente</span>
                        @elseif($admission->status == 'approved')
                            <span class="badge bg-success-600">Approuvé</span>
                        @else
                            <span class="badge bg-danger-600">Refusé</span>
                        @endif
                    </td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('manager.admissions.show', $admission) }}" class="btn btn-sm bg-main-600"><i class="ph ph-eye"></i></a>
                        @if($admission->status == 'pending')
                            <button type="button" class="btn btn-sm bg-success-600" data-bs-toggle="modal" data-bs-target="#approveModal-{{ $admission->id }}"><i class="ph ph-check"></i> Approuver</button>
                            <button type="button" class="btn btn-sm bg-danger-600" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $admission->id }}"><i class="ph ph-x"></i> Refuser</button>
                        @endif
                        <form action="{{ route('manager.admissions.destroy', $admission) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette demande ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm bg-danger-600"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>

                {{-- Approve Modal --}}
                @if($admission->status == 'pending')
                <div class="modal fade" id="approveModal-{{ $admission->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('manager.admissions.approve', $admission) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-success-100">
                                    <h5 class="modal-title">Approuver la demande</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>{{ $admission->first_name }} {{ $admission->last_name }}</strong> ({{ $admission->email }})</p>
                                    <div class="mb-3">
                                        <label>Commentaire (optionnel)</label>
                                        <textarea name="comment" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-main-600" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-warning-600">Confirmer l'approbation</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="rejectModal-{{ $admission->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('manager.admissions.reject', $admission) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-danger-100">
                                    <h5 class="modal-title">Refuser la demande</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>{{ $admission->first_name }} {{ $admission->last_name }}</strong></p>
                                    <div class="mb-3">
                                        <label>Motif du refus *</label>
                                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-main-600" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn bg-danger-600">Confirmer le refus</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                @empty
                <tr><td colspan="8" class="text-center py-40">Aucune demande trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $admissions->withQueryString()->links() }}
</div>
@endsection