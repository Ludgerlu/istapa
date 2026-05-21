@extends('layouts.admin')

@section('title', 'Demandes de congé')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>Demandes de congé</h4>
    <div>
        <a href="{{ route('admin.leaves.index') }}" class="btn bg-main-600 rounded-pill">Toutes</a>
        <a href="{{ route('admin.leaves.index', ['status' => 'pending']) }}" class="btn bg-main-600 rounded-pill">En attente</a>
        <a href="{{ route('admin.leaves.index', ['status' => 'approved']) }}" class="btn bg-main-600 rounded-pill">Approuvées</a>
        <a href="{{ route('admin.leaves.index', ['status' => 'rejected']) }}" class="btn bg-main-600 rounded-pill">Refusées</a>
    </div>
</div>

<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label>Élève (nom)</label>
            <input type="text" name="student_name" class="form-control" placeholder="Nom de l'élève" value="{{ request('student_name') }}">
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
                <tr><th>Élève</th><th>Type</th><th>Période</th><th>Motif</th><th>Date demande</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr>
                    <td>{{ $leave->student->user->first_name ?? '' }} {{ $leave->student->user->last_name ?? '' }}</td>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>{{ $leave->start_date->format('d/m/Y') }} → {{ $leave->end_date->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($leave->reason, 50) }}</td>
                    <td>{{ $leave->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($leave->status == 'pending')
                            <span class="badge bg-warning-600">En attente</span>
                        @elseif($leave->status == 'approved')
                            <span class="badge bg-success-600">Approuvé</span>
                        @else
                            <span class="badge bg-danger-600">Refusé</span>
                        @endif
                    </td>
                    <td class="d-flex gap-8">
                        <!-- <a href="{{ route('admin.leaves.show', $leave) }}" class="btn btn-sm btn-outline-secondary"><i class="ph ph-eye"></i></a> -->
                        @if($leave->status == 'pending')
                            <button type="button" class="btn btn-sm bg-success-600" data-bs-toggle="modal" data-bs-target="#approveModal-{{ $leave->id }}"><i class="ph ph-check"></i> Approuver</button>
                            <button type="button" class="btn btn-sm bg-danger-600" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $leave->id }}"><i class="ph ph-x"></i> Refuser</button>
                        @endif
                        <form action="{{ route('admin.leaves.destroy', $leave) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette demande ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm bg-danger-600"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>

                {{-- Approve Modal --}}
                @if($leave->status == 'pending')
                <div class="modal fade" id="approveModal-{{ $leave->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.leaves.approve', $leave) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-success-100">
                                    <h5 class="modal-title">Approuver la demande</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>{{ $leave->student->user->first_name ?? '' }} {{ $leave->student->user->last_name ?? '' }}</strong> – {{ $leave->leave_type }}</p>
                                    <div class="mb-3">
                                        <label>Commentaire (optionnel)</label>
                                        <textarea name="comment" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-danger-600" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn bg-success-600">Confirmer l'approbation</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="rejectModal-{{ $leave->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.leaves.reject', $leave) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-danger-100">
                                    <h5 class="modal-title">Refuser la demande</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>{{ $leave->student->user->first_name ?? '' }} {{ $leave->student->user->last_name ?? '' }}</strong></p>
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
                <tr><td colspan="7" class="text-center py-40">Aucune demande de congé trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $leaves->withQueryString()->links() }}
</div>
@endsection