@extends('layouts.admin')
@section('title', 'Créer une matière')
@section('content')
<div class="mb-24"><h4>Nouvelle matière</h4></div>
<form action="{{ route('admin.subjects.store') }}" method="POST">
    @csrf
    <div class="bg-white rounded-10 p-24">
        <div class="row g-3">
            <div class="col-md-6">
                <label>Nom *</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>
            <div class="col-md-6">
                <label>Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                <small class="text-muted">Ex: MATH101, PHY202</small>
            </div>
            <div class="col-md-4">
                <label>Classe *</label>
                <select name="class_id" class="form-select" required disabled>
                    <option value="">-- Sélectionner --</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ old(('class_id')==$c->id) || $classId==$c->id  ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Enseignant</label>
                <select name="teacher_id" class="form-select">
                    <option value="">-- Aucun --</option>
                    @foreach($teachers as $t)
                        <option value="{{ $t->user_id }}" {{ old('teacher_id')==$t->user_id ? 'selected' : '' }}>{{ $t->user->first_name }} {{ $t->user->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Coefficient</label>
                <input type="number" step="0.5" name="coefficient" class="form-control" value="{{ old('coefficient', 1) }}">
            </div>
            <div class="col-md-2">
                <label>Heures/semaine</label>
                <input type="number" step="0.5" name="hours_per_week" class="form-control" value="{{ old('hours_per_week') }}">
            </div>
            <div class="col-md-12">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24">
        <a href="{{ route('admin.classes.show', $classId) }}" class="btn bg-danger-600 rounded-pill">Annuler</a>
        <button type="submit" class="btn btn-main rounded-pill">Créer</button>
    </div>
</form>
@endsection