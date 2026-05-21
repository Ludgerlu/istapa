@extends('layouts.admin')

@section('title', $academicYear->label)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $academicYear->label }}</h4>
    <div>
        <a href="{{ route('admin.academic-years.edit', $academicYear) }}" class="btn btn-main rounded-pill"><i class="ph ph-pencil"></i> Modifier</a>
        <a href="{{ route('admin.academic-years.index') }}" class="btn btn-outline-secondary rounded-pill">Retour</a>
    </div>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row">
        <div class="col-md-6">
            <p><strong>Date début :</strong> {{ $academicYear->start_date->format('d/m/Y') }}</p>
            <p><strong>Date fin :</strong> {{ $academicYear->end_date->format('d/m/Y') }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Année en cours :</strong>
                @if($academicYear->is_current)
                    <span class="badge bg-success-600">Oui</span>
                @else
                    <span class="badge bg-neutral-400">Non</span>
                @endif
            </p>
            <p><strong>Classes associées :</strong> {{ $academicYear->classes_count ?? 0 }}</p>
            <p><strong>Frais associés :</strong> {{ $academicYear->fees_count ?? 0 }}</p>
            <p><strong>Examens associés :</strong> {{ $academicYear->exams_count ?? 0 }}</p>
        </div>
    </div>
</div>

@if(($academicYear->classes_count ?? 0) > 0)
<div class="bg-white rounded-10 p-24">
    <h5>Classes rattachées</h5>
    <div class="overflow-x-auto">
        <table class="table table-sm">
            <thead>
                <tr><th>Nom de la classe</th><th>Section</th><th>Programme</th></tr>
            </thead>
            <tbody>
                @foreach($academicYear->classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->section ?? '—' }}</td>
                    <td>{{ $class->program->name ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection