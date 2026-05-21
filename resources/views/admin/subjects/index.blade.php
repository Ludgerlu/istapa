@extends('layouts.admin')

@section('title', 'Matières')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Matières</h4>
    <a href="#" class="btn btn-main rounded-pill"><i class="ph ph-plus-circle"></i> Nouvelle matière</a>
</div>

<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-3">
            <label>Rechercher</label>
            <input type="text" name="q" class="form-control" placeholder="Nom, code..." value="{{ request('q') }}">
        </div>
        <div class="col-md-3">
            <label>Classe</label>
            <select name="class_id" class="form-select">
                <option value="">Toutes</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('class_id')==$c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Enseignant</label>
            <select name="teacher_id" class="form-select">
                <option value="">Tous</option>
                @foreach($teachers as $t)
                    <option value="{{ $t->user_id }}" {{ request('teacher_id')==$t->user_id ? 'selected' : '' }}>{{ $t->user->first_name }} {{ $t->user->last_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-main w-100">Filtrer</button>
        </div>
    </form>
</div>

<div class="bg-white rounded-10 p-24">
    <div class="overflow-x-auto">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Classe</th>
                    <th>Enseignant</th>
                    <th>Coefficient</th>
                    <th>Heures/semaine</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                <tr>
                    <td>{{ $subject->code ?? '—' }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->class->name ?? '—' }}</td>
                    <td>{{ $subject->teacher->user->full_name ?? 'Non assigné' }}</td>
                    <td>{{ $subject->coefficient ?? '—' }}</td>
                    <td>{{ $subject->hours_per_week ?? '—' }}</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('admin.subjects.show', $subject) }}" class="btn btn-sm bg-main-600"><i class="ph ph-eye"></i></a>
                        <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-sm bg-warning-600"><i class="ph ph-pencil"></i></a>
                        <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Supprimer cette matière ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm bg-danger-600"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-40">Aucune matière trouvée. <a href="{{ route('admin.subjects.create') }}">Créer la première</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-24 d-flex justify-content-end">
        {{ $subjects->withQueryString()->links() }}
    </div>
</div>
@endsection