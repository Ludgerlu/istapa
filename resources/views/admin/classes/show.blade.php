@extends('layouts.admin')

@section('title', $class->name)

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>{{ $class->name }} @if($class->section) ({{ $class->section }}) @endif</h4>
    <div><a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-main rounded-pill"><i class="ph ph-pencil"></i> Modifier</a></div>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row">
        <div class="col-md-4"><strong>Programme :</strong> {{ $class->program->name ?? '—' }}</div>
        <div class="col-md-4"><strong>Année scolaire :</strong> {{ $class->academicYear->name ?? '—' }}</div>
        <div class="col-md-4"><strong>Capacité :</strong> {{ $class->capacity ?? 'Illimitée' }}</div>
        <div class="col-md-12"><strong>Professeur principal :</strong> {{ $class->headTeacher->user->full_name ?? 'Non assigné' }}</div>
    </div>
</div>

{{-- Students list --}}
<div class="bg-white rounded-10 p-24 mb-24">
    <h5 class="mb-16">Élèves inscrits ({{ count($students) }})</h5>
    <div class="overflow-x-auto">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr><th>Matricule</th><th>Nom complet</th><th>Email</th><th>Téléphone</th><th>Date d'inscription</th></tr>
            </thead>
            <tbody>
                @forelse($students as $enrollment)
                @php $student = $enrollment->student; @endphp
                <tr>
                    <td>{{ $student->matricule ?? '—' }}</td>
                    <td>{{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? '' }}</td>
                    <td>{{ $student->user->email ?? '—' }}</td>
                    <td>{{ $student->user->phone ?? '—' }}</td>
                    <td>{{ $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d/m/Y') : '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Aucun élève inscrit.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Subjects list --}}
<div class="bg-white rounded-10 p-24 mb-24">
    <h5 class="mb-16">Matières enseignées ({{ count($subjects) }})</h5>
    <div class="overflow-x-auto">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr><th>Code</th><th>Nom</th><th>Coefficient</th><th>Heures/semaine</th><th>Enseignant</th></tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                <tr>
                    <td>{{ $subject->code ?? '—' }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->coefficient }}</td>
                    <td>{{ $subject->hours_per_week ?? '—' }}</td>
                    <td>{{ $subject->teacher->user->full_name ?? 'Non assigné' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Aucune matière associée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Attendance sessions and presence list --}}
<div class="bg-white rounded-10 p-24">
    <h5 class="mb-16">Sessions de présence</h5>
    @if($attendanceSessions->count())
    <div class="overflow-x-auto">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr><th>Date</th><th>Matière</th><th>Horaire</th><th>Enseignant</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($attendanceSessions as $session)
                <tr>
                    <td>{{ $session->session_date->format('d/m/Y') }}</td>
                    <td>{{ $session->subject->name ?? 'N/A' }}</td>
                    <td>{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '—' }} - {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '—' }}</td>
                    <td>{{ $session->takenBy->full_name ?? '—' }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#presenceModal" data-session-id="{{ $session->id }}" data-session-title="{{ $session->subject->name ?? 'Séance' }} du {{ $session->session_date->format('d/m/Y') }}">
                            <i class="ph ph-users"></i> Voir présence
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $attendanceSessions->links() }}
    @else
    <p class="text-muted">Aucune session de présence enregistrée.</p>
    @endif
</div>

{{-- Modal for presence list (will be loaded dynamically via AJAX) --}}
<div class="modal fade" id="presenceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-main-25">
                <h5 class="modal-title">Liste de présence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="presenceModalBody">
                <div class="text-center py-40"><i class="ph ph-spinner spin"></i> Chargement...</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Load presence data when modal is shown
    const presenceModal = document.getElementById('presenceModal');
    if (presenceModal) {
        presenceModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const sessionId = button.getAttribute('data-session-id');
            const sessionTitle = button.getAttribute('data-session-title');
            const modalTitle = presenceModal.querySelector('.modal-title');
            modalTitle.textContent = sessionTitle;

            const modalBody = document.getElementById('presenceModalBody');
            modalBody.innerHTML = '<div class="text-center py-40"><i class="ph ph-spinner spin"></i> Chargement...</div>';

            fetch(`{{ url('admin/attendance-sessions') }}/${sessionId}/presence`)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    modalBody.innerHTML = '<div class="alert alert-danger">Erreur de chargement.</div>';
                });
        });
    }
</script>
<style>
    .spin { animation: spin 1s linear infinite; display: inline-block; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
@endpush