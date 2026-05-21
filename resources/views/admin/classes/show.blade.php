@extends('layouts.admin')

@section('title', $class->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $class->name }} @if($class->section) ({{ $class->section }}) @endif</h4>
    <div>
        <a href="{{ route('admin.classes.index') }}" class="btn bg-danger-600 rounded-pill">Retour</a>
        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-main rounded-pill"><i class="ph ph-pencil"></i> Modifier</a>
    </div>
</div>

{{-- Basic Info Card --}}
<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row">
        <div class="col-md-3"><strong>Programme :</strong><br>{{ $class->program->name ?? '—' }}</div>
        <div class="col-md-3"><strong>Année scolaire :</strong><br>{{ $class->academicYear->label ?? '—' }}</div>
        <div class="col-md-3"><strong>Capacité :</strong><br>{{ $class->capacity ?? 'Illimitée' }}</div>
        <div class="col-md-3"><strong>Professeur principal :</strong><br>{{ $class->headTeacher->user->full_name ?? 'Non assigné' }}</div>
    </div>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-24" id="classTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#subjects" type="button">Matières</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#exams" type="button">Examens</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#students" type="button">Élèves</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#attendances" type="button">Présences</button>
    </li>
</ul>

<div class="tab-content">
    {{-- Subjects Tab --}}
    <div class="tab-pane fade show active" id="subjects">
        <div class="bg-white rounded-10 p-24">
            <div class="d-flex justify-content-between mb-16">
                <h5>Matières enseignées ({{ $subjects->count() }})</h5>
                <a href="{{ route('admin.subjects.create', ['class_id' => $class->id]) }}" class="btn btn-sm btn-outline-main rounded-pill"><i class="ph ph-plus"></i> Ajouter</a>
            </div>
            @if($subjects->count())
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-main-25">
                        <tr><th>Code</th><th>Nom</th><th>Coefficient</th><th>Heures/semaine</th><th>Enseignant</th></tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                        <tr>
                            <td>{{ $subject->code ?? '—' }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->coefficient }}</td>
                            <td>{{ $subject->hours_per_week ?? '—' }}</td>
                            <td>{{ $subject->teacher->user->full_name ?? 'Non assigné' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">Aucune matière associée.</p>
            @endif
        </div>
    </div>

    {{-- Exams Tab --}}
    <div class="tab-pane fade" id="exams">
        <div class="bg-white rounded-10 p-24">
            <h5>Examens planifiés ({{ $exams->count() }})</h5>
            @if($exams->count())
            @foreach($exams as $exam)
            <div class="card mb-20 border">
                <div class="card-header bg-main-25">
                    <strong>{{ $exam->name }}</strong> ({{ ucfirst($exam->exam_type) }} – {{ ucfirst($exam->term) }})<br>
                    <small>Du {{ $exam->start_date ? $exam->start_date->format('d/m/Y') : '—' }} au {{ $exam->end_date ? $exam->end_date->format('d/m/Y') : '—' }}</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr><th>Matière</th><th>Date</th><th>Horaire</th><th>Total</th><th>Notes saisies</th></tr>
                            </thead>
                            <tbody>
                                @foreach($exam->examSubjects as $examSubject)
                                @php $marksCount = $examSubject->marks->count(); @endphp
                                <tr>
                                    <td>{{ $examSubject->subject->name ?? '—' }}</td>
                                    <td>{{ $examSubject->exam_date ? $examSubject->exam_date->format('d/m/Y') : '—' }}</td>
                                    <td>{{ $examSubject->start_time ? \Carbon\Carbon::parse($examSubject->start_time)->format('H:i') : '—' }} - {{ $examSubject->end_time ? \Carbon\Carbon::parse($examSubject->end_time)->format('H:i') : '—' }}</td>
                                    <td>{{ $examSubject->total_mark ?? '—' }}</td>
                                    <td>
                                        @if($marksCount > 0)
                                            <span class="badge bg-success-600">{{ $marksCount }} notes</span>
                                        @else
                                            <span class="badge bg-neutral-400">Aucune</span>
                                        @endif
                                     </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p class="text-muted">Aucun examen planifié.</p>
            @endif
        </div>
    </div>

    {{-- Students Tab --}}
    <div class="tab-pane fade" id="students">
        <div class="bg-white rounded-10 p-24">
            <h5>Élèves inscrits ({{ $students->count() }})</h5>
            @if($students->count())
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-main-25">
                        <tr><th>Matricule</th><th>Nom complet</th><th>Email</th><th>Téléphone</th><th>Date inscription</th></tr>
                    </thead>
                    <tbody>
                        @foreach($students as $enrollment)
                        @php $student = $enrollment->student; @endphp
                        <tr>
                            <td>{{ $student->matricule ?? '—' }}</td>
                            <td>{{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? '' }}</td>
                            <td>{{ $student->user->email ?? '—' }}</td>
                            <td>{{ $student->user->phone ?? '—' }}</td>
                            <td>{{ $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d/m/Y') : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">Aucun élève inscrit.</p>
            @endif
        </div>
    </div>

    {{-- Attendance Sessions Tab --}}
    <div class="tab-pane fade" id="attendances">
        <div class="bg-white rounded-10 p-24">
            <h5>Dernières sessions de présence</h5>
            @if($attendanceSessions->count())
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-main-25">
                        <tr><th>Date</th><th>Matière</th><th>Horaire</th><th>Enseignant</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceSessions as $session)
                        <tr>
                            <td>{{ $session->session_date->format('d/m/Y') }}</td>
                            <td>{{ $session->subject->name ?? '—' }}</td>
                            <td>{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '—' }} - {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '—' }}</td>
                            <td>{{ $session->takenBy->full_name ?? '—' }}</td>
                            <td><a href="{{ route('admin.attendances.show', $session) }}" class="btn btn-sm btn-outline-secondary"><i class="ph ph-eye"></i> Détails</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-20 d-flex justify-content-end">
                {{ $attendanceSessions->links() }}
            </div>
            @else
            <p class="text-muted">Aucune session de présence enregistrée.</p>
            @endif
        </div>
    </div>
</div>
@endsection