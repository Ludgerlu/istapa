@extends('layouts.admin')

@section('title', 'Modifier les frais')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Modifier les frais</h4>
</div>

<form action="{{ route('admin.fees.update', $fee) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-4">
            {{-- Class --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Classe <span class="text-danger">*</span></label>
                <select name="class_id" class="form-select" required>
                    <option value="">Sélectionner une classe</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id', $fee->class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Academic Year --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Année scolaire <span class="text-danger">*</span></label>
                <select name="academic_year_id" class="form-select" required>
                    <option value="">Sélectionner une année</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ old('academic_year_id', $fee->academic_year_id) == $year->id ? 'selected' : '' }}>
                            {{ $year->label }}
                        </option>
                    @endforeach
                </select>
                @error('academic_year_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Fee Category --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Catégorie de frais <span class="text-danger">*</span></label>
                <select name="fee_category_id" class="form-select" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('fee_category_id', $fee->fee_category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('fee_category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Amount --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Montant (FCFA) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $fee->amount) }}" required>
                @error('amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Due Date --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Date d'échéance</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $fee->due_date ? $fee->due_date->format('Y-m-d') : '') }}">
                @error('due_date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            {{-- Description --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $fee->description) }}</textarea>
                @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    <div class="d-flex gap-12 justify-content-end">
        <a href="{{ route('admin.fees.show', $fee) }}" class="btn btn-outline-secondary rounded-pill px-24">Annuler</a>
        <button type="submit" class="btn bg-main-600 text-white rounded-pill px-24">Mettre à jour</button>
    </div>
</form>
@endsection