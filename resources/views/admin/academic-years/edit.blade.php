@extends('layouts.admin')

@section('title', 'Modifier l\'année académique')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Modifier : {{ $academicYear->label }}</h4>
</div>

<form action="{{ route('admin.academic-years.update', $academicYear) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="bg-white rounded-10 p-24">
        <div class="row g-4">
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Libellé <span class="text-danger">*</span></label>
                <input type="text" name="label" class="form-control" value="{{ old('label', $academicYear->label) }}" required>
                @error('label') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Date début <span class="text-danger">*</span></label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $academicYear->start_date->format('Y-m-d')) }}" required>
                @error('start_date') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Date fin <span class="text-danger">*</span></label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $academicYear->end_date->format('Y-m-d')) }}" required>
                @error('end_date') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-12">
                <div class="form-check">
                    <input type="checkbox" name="is_current" value="1" class="form-check-input" id="is_current" {{ old('is_current', $academicYear->is_current) ? 'checked' : '' }}>
                    <label class="form-check-label text-14" for="is_current">Définir comme année en cours</label>
                    <small class="d-block text-muted">Si coché, toute autre année actuelle sera désactivée.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-12 mt-24">
        <a href="{{ route('admin.academic-years.index') }}" class="btn btn-outline-secondary rounded-pill px-24">Annuler</a>
        <button type="submit" class="btn btn-main rounded-pill px-24">Mettre à jour</button>
    </div>
</form>
@endsection