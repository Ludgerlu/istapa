@extends('layouts.admin')
@section('title', 'Examens')
@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>Examens</h4>
    <a href="{{ route('admin.exams.create') }}" class="btn btn-main rounded-pill"><i class="ph ph-plus-circle"></i> Nouvel examen</a>
</div>

<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-3">
            <label>Classe</label>
            <select name="class_id" class="form-select">
                <option value="">Toutes</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('class_id')==$c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3"><label>Année scolaire</label><select name="academic_year_id" class="form-select"><option value="">Toutes</option>@foreach($academicYears as $y)<option value="{{ $y->id }}" {{ request('academic_year_id')==$y->id ? 'selected' : '' }}>{{ $y->label }}</option>@endforeach</select></div>
        <div class="col-md-3"><label>Période</label><select name="term" class="form-select"><option value="">Toutes</option><option value="term_1" {{ request('term')=='term_1' ? 'selected' : '' }}>Premier semestre</option><option value="term_2" {{ request('term')=='term_2' ? 'selected' : '' }}>Deuxième semestre</option><option value="term_3" {{ request('term')=='term_3' ? 'selected' : '' }}>Troisième semestre</option><option value="final" {{ request('term')=='final' ? 'selected' : '' }}>Final</option></select></div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-main w-100">Filtrer</button> 
            <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-main w-100 ms-2">Réinitialiser</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-10 p-24">
    <table class="table table-bordered">
        <thead class="bg-main-25"><tr><th>Nom</th><th>Classe</th><th>Année scolaire</th><th>Période</th><th>Type</th><th>Dates</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($exams as $exam)
            <tr>
                <td>{{ $exam->name }}</td>
                <td>{{ $exam->class->name ?? '—' }}</td>
                <td>{{ $exam->academicYear->label ?? '—' }}</td>
                <td>{{ ucfirst($exam->term) }}</td>
                <td>{{ ucfirst($exam->exam_type) }}</td>
                <td>{{ $exam->start_date ? $exam->start_date->format('d/m/Y') : '—' }} → {{ $exam->end_date ? $exam->end_date->format('d/m/Y') : '—' }}</td>
                <td class="d-flex gap-8">
                    <a href="{{ route('admin.exams.show', $exam) }}" class="btn btn-sm bg-main-600"><i class="ph ph-eye"></i></a>
                    <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-sm bg-main-600"><i class="ph ph-pencil"></i></a>
                    <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('Supprimer cet examen ?')">@csrf @method('DELETE')<button class="btn btn-sm bg-danger-600"><i class="ph ph-trash"></i></button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-40">Aucun examen trouvé. <a href="{{ route('admin.exams.create') }}">Créer le premier</a></td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $exams->withQueryString()->links() }}
</div>
@endsection