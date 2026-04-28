@extends('layouts.admin')

@section('title', 'Classes')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>Classes</h4>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-main rounded-pill"><i class="ph ph-plus-circle"></i> Nouvelle classe</a>
</div>

<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-4"><label>Programme</label><select name="program_id" class="form-select"><option value="">Tous</option>@foreach($programs as $p)<option value="{{ $p->id }}" {{ request('program_id')==$p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label>Année scolaire</label><select name="academic_year_id" class="form-select"><option value="">Toutes</option>@foreach($academicYears as $y)<option value="{{ $y->id }}" {{ request('academic_year_id')==$y->id ? 'selected' : '' }}>{{ $y->name }}</option>@endforeach</select></div>
        <div class="col-md-4 d-flex align-items-end"><button type="submit" class="btn btn-main w-100">Filtrer</button></div>
    </form>
</div>

<div class="bg-white rounded-10 p-24">
    <table class="table">
        <thead>
            <tr><th>Nom</th><th>Section</th><th>Programme</th><th>Année scolaire</th><th>Capacité</th><th>Professeur principal</th><th>Actions</th>
            </thead>
        <tbody>
            @forelse($classes as $class)
            <tr>
                <td>{{ $class->name }}</td>
                <td>{{ $class->section ?? '—' }}</td>
                <td>{{ $class->program->name ?? '—' }}</td>
                <td>{{ $class->academicYear->name ?? '—' }}</td>
                <td>{{ $class->capacity ?? '∞' }}</td>
                <td>{{ $class->headTeacher->user->full_name ?? '—' }}</td>
                <td class="d-flex gap-8">
                    <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-sm btn-outline-secondary"><i class="ph ph-eye"></i></a>
                    <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-outline-secondary"><i class="ph ph-pencil"></i></a>
                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Supprimer cette classe ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="ph ph-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-40">Aucune classe trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $classes->withQueryString()->links() }}
</div>
@endsection