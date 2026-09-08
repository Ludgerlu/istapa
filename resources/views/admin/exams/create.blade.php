@extends('layouts.admin')
@section('title', 'Créer un examen')
@section('content')
<div class="mb-24"><h4>Nouvel examen</h4></div>
<form action="{{ route('admin.exams.store') }}" method="POST">
    @csrf
    <div class="bg-white rounded-10 p-24">
        <div class="row g-3">
            <div class="col-md-6"><label>Nom *</label><input type="text" name="name" class="form-control" required></div>
            <div class="col-md-3"><label>Classe *</label>
                <select name="class_id" class="form-select" required>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3"><label>Année scolaire *</label><select name="academic_year_id" class="form-select" required>@foreach($academicYears as $y)<option value="{{ $y->id }}">{{ $y->label }}</option>@endforeach</select></div>
            <div class="col-md-3"><label>Période</label><select name="term" class="form-select"><option value="first">Premier semestre</option><option value="second">Deuxième semestre</option><option value="third">Troisième semestre</option><option value="final">Final</option></select></div>
            <div class="col-md-3"><label>Type d'examen</label><select name="exam_type" class="form-select"><option value="midterm">Mi-période</option><option value="final">Final</option><option value="quiz">Quiz</option><option value="assignment">Devoir</option></select></div>
            <div class="col-md-2"><label>Note de passage</label><input type="number" name="passing_mark" class="form-control" step="0.5"></div>
            <div class="col-md-2"><label>Note totale</label><input type="number" name="total_mark" class="form-control" step="0.5" value="100"></div>
            <div class="col-md-3"><label>Date début</label><input type="date" name="start_date" class="form-control"></div>
            <div class="col-md-3"><label>Date fin</label><input type="date" name="end_date" class="form-control"></div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24">
        <a href="{{ route('admin.exams.index') }}" class="btn bg-danger-600 rounded-pill">Annuler</a>
        <button type="submit" class="btn btn-main">Créer</button>
    </div>
</form>
@endsection