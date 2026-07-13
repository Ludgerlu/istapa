@extends('layouts.admin')
@section('title', 'Modifier la classe')
@section('content')
<div class="mb-24"><h4>Modifier : {{ $class->name }}</h4></div>
<form action="{{ route('admin.classes.update', $class) }}" method="POST">
    @csrf @method('PUT')
    <div class="bg-white rounded-10 p-24">
        <div class="row g-3">
            <div class="col-md-6"><label>Nom *</label><input type="text" name="name" class="form-control" value="{{ old('name', $class->name) }}" required></div>
            <div class="col-md-6"><label>Section</label><input type="text" name="section" class="form-control" value="{{ old('section', $class->section) }}"></div>
            <div class="col-md-4"><label>Programme *</label><select name="program_id" class="form-select" required>@foreach($programs as $p)<option value="{{ $p->id }}" {{ old('program_id', $class->program_id)==$p->id ? 'selected' : '' }}>{{ $p->title_fr }}</option>@endforeach</select></div>
            <div class="col-md-4"><label>Année scolaire *</label><select name="academic_year_id" class="form-select" required>@foreach($academicYears as $y)<option value="{{ $y->id }}" {{ old('academic_year_id', $class->academic_year_id)==$y->id ? 'selected' : '' }}>{{ $y->label }}</option>@endforeach</select></div>
            <div class="col-md-4"><label>Capacité</label><input type="number" name="capacity" class="form-control" value="{{ old('capacity', $class->capacity) }}"></div>
            <div class="col-md-12"><label>Professeur principal</label><select name="head_teacher_id" class="form-select"><option value="">-- Aucun --</option>@foreach($teachers as $t)<option value="{{ $t->user_id }}" {{ old('head_teacher_id', $class->head_teacher_id)==$t->user_id ? 'selected' : '' }}>{{ $t->user->first_name }} {{ $t->user->last_name }}</option>@endforeach</select></div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24"><a href="{{ route('admin.classes.show', $class) }}" class="btn bg-danger-600 rounded-pill">Annuler</a><button type="submit" class="btn btn-main rounded-pill">Mettre à jour</button></div>
</form>
@endsection

