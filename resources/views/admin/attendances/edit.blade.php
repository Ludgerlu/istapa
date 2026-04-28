@extends('layouts.admin')
@section('title', 'Modifier la présence')
@section('content')
<div class="mb-24"><h4>Modifier la session du {{ $attendance->session_date->format('d/m/Y') }}</h4></div>

<form method="POST" action="{{ route('admin.attendances.update', $attendance) }}">
    @csrf @method('PUT')
    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-3">
            <div class="col-md-4">
                <label>Classe *</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $attendance->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Matière *</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $attendance->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Date *</label>
                <input type="date" name="session_date" class="form-control" required value="{{ $attendance->session_date->format('Y-m-d') }}">
            </div>
            <div class="col-md-2">
                <label>Heure début</label>
                <input type="time" name="start_time" class="form-control" value="{{ $attendance->start_time ? \Carbon\Carbon::parse($attendance->start_time)->format('H:i') : '' }}">
            </div>
            <div class="col-md-2">
                <label>Heure fin</label>
                <input type="time" name="end_time" class="form-control" value="{{ $attendance->end_time ? \Carbon\Carbon::parse($attendance->end_time)->format('H:i') : '' }}">
            </div>
            <div class="col-md-12">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ $attendance->notes }}</textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-10 p-24">
        <h5 class="mb-16">Liste des élèves</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-main-25">
                    <tr><th>Élève</th><th>Statut</th><th>Commentaire</th></tr>
                </thead>
                <tbody>
                    @foreach($presenceList as $student)
                    <tr>
                        <td>{{ $student->name }} <br><small class="text-muted">{{ $student->matricule }}</small></td>
                        <td>
                            <select name="students[{{ $student->id }}][status]" class="form-select" required>
                                <option value="present" {{ $student->status == 'present' ? 'selected' : '' }}>Présent</option>
                                <option value="absent" {{ $student->status == 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="late" {{ $student->status == 'late' ? 'selected' : '' }}>En retard</option>
                                <option value="excused" {{ $student->status == 'excused' ? 'selected' : '' }}>Excusé</option>
                            </select>
                            <input type="hidden" name="students[{{ $student->id }}][id]" value="{{ $student->id }}">
                        </td>
                        <td><input type="text" name="students[{{ $student->id }}][comment]" class="form-control" value="{{ $student->comment }}"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end gap-12">
            <button type="submit" class="btn btn-main rounded-pill px-30">Mettre à jour</button>
        </div>
    </div>
</form>
@endsection