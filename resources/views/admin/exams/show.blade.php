@extends('layouts.admin')
@section('title', $exam->name)
@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>{{ $exam->name }}</h4>
    <div><a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-main">Modifier</a> <a href="{{ route('admin.exams.index') }}" class="btn bg-danger-600">Retour</a></div>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row">
        <div class="col-md-3"><strong>Classe :</strong> {{ $exam->class->name }}</div>
        <div class="col-md-3"><strong>Année :</strong> {{ $exam->academicYear->label }}</div>
        <div class="col-md-3"><strong>Période :</strong> {{ ucfirst($exam->term) }}</div>
        <div class="col-md-3"><strong>Type :</strong> {{ ucfirst($exam->exam_type) }}</div>
        <div class="col-md-3"><strong>Dates :</strong> {{ $exam->start_date?->format('d/m/Y') }} → {{ $exam->end_date?->format('d/m/Y') }}</div>
        <div class="col-md-3"><strong>Note passage :</strong> {{ $exam->passing_mark ?? '—' }}</div>
        <div class="col-md-3"><strong>Note totale :</strong> {{ $exam->total_mark ?? '100' }}</div>
    </div>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <h5>Matières de l'examen</h5>
    @if($exam->examSubjects->count())
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr><th>Matière</th><th>Date épreuve</th><th>Horaire</th><th>Note totale</th><th>Moyenne</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($exam->examSubjects as $examSubject)
                @php $marks = $examSubject->marks; $avg = $marks->avg('mark'); @endphp
                <tr>
                    <td>{{ $examSubject->subject->name }} (@if($examSubject->subject->coefficient) coeff {{ $examSubject->subject->coefficient }} @endif)</td>
                    <td>{{ $examSubject->exam_date?->format('d/m/Y') ?? '—' }}</td>
                    <td>{{ $examSubject->start_time ? \Carbon\Carbon::parse($examSubject->start_time)->format('H:i') : '—' }} - {{ $examSubject->end_time ? \Carbon\Carbon::parse($examSubject->end_time)->format('H:i') : '—' }}</td>
                    <td>{{ $examSubject->total_mark ?? $exam->total_mark ?? '—' }}</td>
                    <td>@if($marks->count()) {{ number_format($avg, 2) }} ({{ $marks->count() }}/{{ $exam->class->classEnrollments->count() ?? 0 }} notes) @else — @endif</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('admin.exam-subjects.marks.edit', $examSubject) }}" class="btn btn-sm bg-primary-400">Saisir notes</a>
                        <form action="{{ route('admin.exams.subjects.destroy', $examSubject) }}" method="POST" onsubmit="return confirm('Retirer cette matière ?')">@csrf @method('DELETE')<button class="btn btn-sm bg-danger-600"><i class="ph ph-trash"></i></button></form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted">Aucune matière ajoutée à cet examen.</p>
    @endif

    <hr class="my-24">
    <h5>Ajouter une matière</h5>
    <form action="{{ route('admin.exams.subjects.store', $exam) }}" method="POST" class="row g-3 align-items-end">
        @csrf
        <div class="col-md-3"><label>Matière</label><select name="subject_id" class="form-select" required>@foreach($exam->class->subjects ?? [] as $subj)<option value="{{ $subj->id }}">{{ $subj->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label>Date</label><input type="date" name="exam_date" class="form-control"></div>
        <div class="col-md-2"><label>Début</label><input type="time" name="start_time" class="form-control"></div>
        <div class="col-md-2"><label>Fin</label><input type="time" name="end_time" class="form-control"></div>
        <div class="col-md-2"><label>Total</label><input type="number" name="total_mark" class="form-control" placeholder="100"></div>
        <div class="col-md-1"><button type="submit" class="btn btn-main">Ajouter</button></div>
    </form>
</div>
@endsection