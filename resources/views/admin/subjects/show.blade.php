@extends('layouts.admin')

@section('title', $subject->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Matière : {{ $subject->name }}</h4>
    <div>
        <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-main rounded-pill"><i class="ph ph-pencil"></i> Modifier</a>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary rounded-pill">Retour</a>
    </div>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row">
        <div class="col-md-3"><strong>Code :</strong><br>{{ $subject->code ?? '—' }}</div>
        <div class="col-md-3"><strong>Classe :</strong><br>{{ $subject->class->name ?? '—' }}</div>
        <div class="col-md-3"><strong>Enseignant :</strong><br>{{ $subject->teacher->user->full_name ?? 'Non assigné' }}</div>
        <div class="col-md-3"><strong>Coefficient :</strong><br>{{ $subject->coefficient ?? '—' }}</div>
        <div class="col-md-3"><strong>Heures/semaine :</strong><br>{{ $subject->hours_per_week ?? '—' }}</div>
        <div class="col-md-12 mt-3"><strong>Description :</strong><br>{{ $subject->description ?: 'Aucune description' }}</div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="bg-white rounded-10 p-24 mb-24">
            <h5>Examens utilisant cette matière</h5>
            @if($exams->count())
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr><th>Examen</th><th>Type</th><th>Période</th><th>Date épreuve</th></tr>
                    </thead>
                    <tbody>
                        @foreach($exams as $exam)
                        @php
                            $examSubject = $subject->examSubjects->where('exam_id', $exam->id)->first();
                        @endphp
                        <tr>
                            <td><a href="{{ route('admin.exams.show', $exam) }}">{{ $exam->name }}</a></td>
                            <td>{{ ucfirst($exam->exam_type) }}</td>
                            <td>{{ $exam->term }}</td>
                            <td>{{ $examSubject && $examSubject->exam_date ? $examSubject->exam_date->format('d/m/Y') : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">Cette matière n'est utilisée dans aucun examen.</p>
            @endif
        </div>
    </div>
    <div class="col-lg-6">
        <div class="bg-white rounded-10 p-24">
            <h5>Sessions de présence</h5>
            @if($attendanceSessions->count())
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr><th>Date</th><th>Horaire</th><th>Enseignant</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceSessions as $session)
                        <tr>
                            <td>{{ $session->session_date->format('d/m/Y') }}</td>
                            <td>{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '—' }} - {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '—' }}</td>
                            <td>{{ $session->takenBy->full_name ?? '—' }}</td>
                            <td><a href="{{ route('admin.attendances.show', $session) }}" class="btn btn-sm bg-main-600">Détails</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-16 d-flex justify-content-end">
                {{ $attendanceSessions->links() }}
            </div>
            @else
            <p class="text-muted">Aucune session de présence pour cette matière.</p>
            @endif
        </div>
    </div>
</div>
@endsection