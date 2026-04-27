@extends('layouts.admin')
@section('title', 'Créer un frais')
@section('content')
<div class="mb-24"><h4>Ajouter des frais</h4></div>
<form action="{{ route('admin.fees.store') }}" method="POST">
    @csrf
    <div class="bg-white rounded-10 p-24">
        <div class="row g-3">
            <div class="col-md-4"><label>Classe *</label><select name="class_id" class="form-select" required>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
            <div class="col-md-4"><label>Année scolaire *</label><select name="academic_year_id" class="form-select" required>@foreach($academicYears as $y)<option value="{{ $y->id }}">{{ $y->name }}</option>@endforeach</select></div>
            <div class="col-md-4"><label>Catégorie *</label><select name="fee_category_id" class="form-select" required>@foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach</select></div>
            <div class="col-md-4"><label>Montant (FCFA) *</label><input type="number" step="0.01" name="amount" class="form-control" required></div>
            <div class="col-md-4"><label>Date d'échéance</label><input type="date" name="due_date" class="form-control"></div>
            <div class="col-md-12"><label>Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24"><a href="{{ route('admin.fees.index') }}" class="btn bg-warning-100 text-warning-700">Annuler</a><button type="submit" class="btn btn-main">Enregistrer</button></div>
</form>
@endsection