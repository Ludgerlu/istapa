@extends('layouts.admin')
@section('title', 'Modifier la matière')
@section('content')
<div class="mb-24"><h4>Modifier : {{ $subject->name }}</h4></div>
<form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
    @csrf @method('PUT')
    <div class="bg-white rounded-10 p-24">
        <div class="row g-3">
            <div class="col-md-6">
                <label>Nom *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name) }}" required>
            </div>
            <div class="col-md-6">
                <label>Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $subject->code) }}">
            </div>
            <div class="col-md-4">
                <label>Classe *</label>
                <select name="class_id" class="form-select" required disabled>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ old('class_id', $subject->class_id)==$c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Enseignant</label>
                <select name="teacher_id" class="form-select">
                    <option value="">-- Aucun --</option>
                    @foreach($teachers as $t)
                        <option value="{{ $t->user_id }}" {{ old('teacher_id', $subject->teacher_id)==$t->user_id ? 'selected' : '' }}>{{ $t->user->first_name }} {{ $t->user->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Coefficient</label>
                <input type="number" step="0.5" name="coefficient" class="form-control" value="{{ old('coefficient', $subject->coefficient) }}">
            </div>
            <div class="col-md-2">
                <label>Heures/semaine</label>
                <input type="number" step="0.5" name="hours_per_week" class="form-control" value="{{ old('hours_per_week', $subject->hours_per_week) }}">
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $subject->description) }}</textarea>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24">
        <a href="{{ route('admin.classes.show', $subject->class_id) }}" class="btn bg-danger-600 rounded-pill">Annuler</a>
        <button type="submit" class="btn btn-main rounded-pill">Mettre à jour</button>
    </div>
</form>
@endsection