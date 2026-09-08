@extends('layouts.admin')

@section('title', 'Classes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Classes</h4>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-main rounded-pill"><i class="ph ph-plus-circle"></i> Nouvelle classe</a>
</div>

<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-3">
            <label>Rechercher</label>
            <input type="text" name="q" class="form-control" placeholder="Nom, section..." value="{{ request('q') }}">
        </div>
        <div class="col-md-3">
            <label>Programme</label>
            <select name="program_id" class="form-select">
                <option value="">Tous</option>
                @foreach($programs as $p)
                    <option value="{{ $p->id }}" {{ request('program_id')==$p->id ? 'selected' : '' }}>{{ $p->slug }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Année scolaire</label>
            <select name="academic_year_id" class="form-select">
                <option value="">Toutes</option>
                @foreach($academicYears as $y)
                    <option value="{{ $y->id }}" {{ $year_id==$y->id ? 'selected' : '' }}>{{ $y->label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-main w-100">Filtrer</button>
            <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-main w-100 ms-2">Réinitialiser</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-10 p-24">
    <div class="overflow-x-auto">
        <table class="table table-bordered" id="classes-table">
            <thead class="bg-main-25">
                <tr>
                    <th>Nom</th>
                    <th>Section</th>
                    <th>Programme</th>
                    <th>Année scolaire</th>
                    <th>Capacité</th>
                    <th>Professeur principal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->section ?? '—' }}</td>
                    <td>{{ $class->program->slug ?? '—' }}</td>
                    <td>{{ $class->academicYear->label ?? '—' }}</td>
                    <td>{{ $class->capacity ?? '∞' }}</td>
                    <td>{{ $class->headTeacher->user->full_name ?? '—' }}</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-sm bg-main-600"><i class="ph ph-eye"></i></a>
                        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm bg-main-600"><i class="ph ph-pencil"></i></a>
                        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Supprimer cette classe ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm bg-danger-600"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-40">Aucune classe trouvée. <a href="{{ route('admin.classes.create') }}">Créer la première</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function() {
    // ---------- Select2 ----------
    $('#program_id').select2({
        placeholder: 'Choisir...',
        allowClear: true,
        width: '100%'
    });

    // ---------- DataTable ----------
    var table = $('#classes-table').DataTable({
       
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
        dom: "<'row'<'col-sm-12 col-md-6 mb-3'l><'col-sm-12 col-md-6 mb-3'f>>" +
             "<'row'<'col-md-6 mb-3'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: "excel",
                className: "btn btn-sm btn-main",
                text: '<i class="ph ph-file-xls"></i> Excel'
            },
            {
                extend: "csv",
                className: "btn btn-sm btn-main",
                text: '<i class="ph ph-file-csv"></i> CSV'
            },
            {
                extend: "pdf",
                className: "btn btn-sm btn-main",
                text: '<i class="ph ph-file-pdf"></i> PDF'
            }
        ],
        order: [[0, 'asc']],
        columnDefs: [
            { targets: [6], orderable: false } // Actions non triable
        ]
    });
});
</script>
@endpush