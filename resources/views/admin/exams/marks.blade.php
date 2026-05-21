@extends('layouts.admin')
@section('title', 'Saisie des notes - ' . $examSubject->subject->name)
@section('content')
<div class="mb-24">
    <h4>Saisie des notes : {{ $examSubject->subject->name }}</h4>
    <p>Examen : {{ $examSubject->exam->name }} | Classe : {{ $examSubject->exam->class->name }} | Note totale : {{ $examSubject->total_mark ?? $examSubject->exam->total_mark ?? 100 }}</p>
</div>

<form action="{{ route('admin.exam-subjects.marks.update', $examSubject) }}" method="POST">
    @csrf @method('PUT')
    <div class="bg-white rounded-10 p-24">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-main-25">
                    <tr><th>Élève</th><th>Matricule</th><th>Note / {{ $examSubject->total_mark ?? $examSubject->exam->total_mark ?? 100 }}</th><th>Commentaire</th></tr>
                </thead>
                <tbody>
                    @foreach($students as $enrollment)
                    @php $student = $enrollment->student; $mark = $marks->get($student->user_id); @endphp
                    <tr>
                        <td>{{ $student->user->first_name }} {{ $student->user->last_name }}</td>
                        <td>{{ $student->matricule ?? '—' }}</td>
                        <td>
                            <input type="number" step="0.01" name="marks[{{ $student->user_id }}]" class="form-control" value="{{ $mark ? $mark->mark : '' }}" min="0" max="{{ $examSubject->total_mark ?? $examSubject->exam->total_mark ?? 100 }}">
                         </td>
                        <td><input type="text" name="comments[{{ $student->user_id }}]" class="form-control" value="{{ $mark ? $mark->comment : '' }}"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end gap-12 mt-24">
            <a href="{{ route('admin.exams.show', $examSubject->exam_id) }}" class="btn bg-danger-600">Annuler</a>
            <button type="submit" class="btn btn-main">Enregistrer les notes</button>
        </div>
    </div>
</form>
@endsection