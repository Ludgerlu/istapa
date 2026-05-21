@extends('layouts.admin')

@section('title', 'Modifier l\'examen')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Modifier l'examen</h4>
</div>

<form action="{{ route('admin.exams.update', $exam) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-3">
            {{-- Exam Name --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Nom de l'examen <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $exam->name) }}" required>
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- Class --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Classe <span class="text-danger">*</span></label>
                <select name="class_id" class="form-select" required>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id', $exam->class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- Academic Year --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Année scolaire <span class="text-danger">*</span></label>
                <select name="academic_year_id" class="form-select" required>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ old('academic_year_id', $exam->academic_year_id) == $year->id ? 'selected' : '' }}>
                            {{ $year->label }}
                        </option>
                    @endforeach
                </select>
                @error('academic_year_id') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- Term (Period) --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Période <span class="text-danger">*</span></label>
                <select name="term" class="form-select" required>
                    <option value="first" {{ old('term', $exam->term) == 'first' ? 'selected' : '' }}>Premier semestre</option>
                    <option value="second" {{ old('term', $exam->term) == 'second' ? 'selected' : '' }}>Deuxième semestre</option>
                    <option value="third" {{ old('term', $exam->term) == 'third' ? 'selected' : '' }}>Troisième semestre</option>
                    <option value="final" {{ old('term', $exam->term) == 'final' ? 'selected' : '' }}>Final</option>
                </select>
                @error('term') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- Exam Type --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Type d'examen <span class="text-danger">*</span></label>
                <select name="exam_type" class="form-select" required>
                    <option value="midterm" {{ old('exam_type', $exam->exam_type) == 'midterm' ? 'selected' : '' }}>Mi-période</option>
                    <option value="final" {{ old('exam_type', $exam->exam_type) == 'final' ? 'selected' : '' }}>Final</option>
                    <option value="quiz" {{ old('exam_type', $exam->exam_type) == 'quiz' ? 'selected' : '' }}>Quiz</option>
                    <option value="assignment" {{ old('exam_type', $exam->exam_type) == 'assignment' ? 'selected' : '' }}>Devoir</option>
                </select>
                @error('exam_type') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- Passing Mark --}}
            <div class="col-md-2">
                <label class="form-label text-14 fw-medium">Note de passage</label>
                <input type="number" step="0.5" name="passing_mark" class="form-control" value="{{ old('passing_mark', $exam->passing_mark) }}">
                @error('passing_mark') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- Total Mark --}}
            <div class="col-md-2">
                <label class="form-label text-14 fw-medium">Note totale</label>
                <input type="number" step="0.5" name="total_mark" class="form-control" value="{{ old('total_mark', $exam->total_mark ?? 100) }}">
                @error('total_mark') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- Start Date --}}
            <div class="col-md-3">
                <label class="form-label text-14 fw-medium">Date début</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $exam->start_date ? $exam->start_date->format('Y-m-d') : '') }}">
                @error('start_date') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- End Date --}}
            <div class="col-md-3">
                <label class="form-label text-14 fw-medium">Date fin</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $exam->end_date ? $exam->end_date->format('Y-m-d') : '') }}">
                @error('end_date') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    <div class="d-flex gap-12 justify-content-end">
        <a href="{{ route('admin.exams.show', $exam) }}" class="btn btn-outline-secondary rounded-pill px-24">Annuler</a>
        <button type="submit" class="btn bg-main-600 text-white rounded-pill px-24">Mettre à jour</button>
    </div>
</form>
@endsection