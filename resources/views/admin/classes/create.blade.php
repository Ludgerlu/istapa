@extends('layouts.admin')
@section('title', 'Créer une classe')
@section('content')
<div class="mb-24"><h4>Nouvelle classe</h4></div>
<form action="{{ route('admin.classes.store') }}" method="POST">
    @csrf
    <div class="bg-white rounded-10 p-24">
        <div class="row g-3">
            <div class="col-md-6"><label>Nom *</label><input type="text" name="name" class="form-control" required></div>
            <div class="col-md-6"><label>Section</label><input type="text" name="section" class="form-control"></div>
            <div class="col-md-4"><label>Programme *</label><select name="program_id" class="form-select" required>@foreach($programs as $p)<option value="{{ $p->id }}">{{ $p->title }}</option>@endforeach</select></div>
            <div class="col-md-4"><label>Année scolaire *</label><select name="academic_year_id" class="form-select" required>@foreach($academicYears as $y)<option value="{{ $y->id }}">{{ $y->label }}</option>@endforeach</select></div>
            <div class="col-md-4"><label>Capacité</label><input type="number" name="capacity" class="form-control"></div>
            <div class="col-md-12"><label>Professeur principal</label><select name="head_teacher_id" class="form-select"><option value="">-- Aucun --</option>@foreach($teachers as $t)<option value="{{ $t->user_id }}">{{ $t->user->first_name }} {{ $t->user->last_name }}</option>@endforeach</select></div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24"><a href="{{ route('admin.classes.index') }}" class="btn bg-warning">Annuler</a><button type="submit" class="btn btn-main">Créer</button></div>
</form>
@endsection