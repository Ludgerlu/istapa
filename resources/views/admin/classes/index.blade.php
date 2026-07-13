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
                    <option value="{{ $p->id }}" {{ request('program_id')==$p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Année scolaire</label>
            <select name="academic_year_id" class="form-select">
                <option value="">Toutes</option>
                @foreach($academicYears as $y)
                    <option value="{{ $y->id }}" {{ request('academic_year_id')==$y->id ? 'selected' : '' }}>{{ $y->label }}</option>
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
        <table class="table table-bordered" id="classesTable">
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
                    <td>{{ $class->program->name ?? '—' }}</td>
                    <td>{{ $class->academicYear->label ?? '—' }}</td>
                    <td>{{ $class->capacity ?? '∞' }}</td>
                    <td>{{ $class->headTeacher->user->full_name ?? '—' }}</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('admin.classes.show', $class) }}" class="action-btn action-btn--view"><i class="ph ph-eye"></i></a>
                        <a href="{{ route('admin.classes.edit', $class) }}" class="action-btn action-btn--edit"><i class="ph ph-pencil"></i></a>
                        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Supprimer cette classe ?')">
                            @csrf @method('DELETE')
                            <button class="action-btn action-btn--delete"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-40">Aucune classe trouvée. <a href="{{ route('admin.classes.create') }}">Créer la première</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-24 d-flex justify-content-end">
        {{ $classes->withQueryString()->links() }}
    </div>
</div>
@endsection
@push('styles')
<style>
/* ── Stat cards ─────────────────────────────────────── */
.stat-card {
    border: 1px solid #F0F1F3;
    transition: box-shadow .2s, transform .2s;
}
.stat-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,.08);
    transform: translateY(-2px);
}

/* ── Role badge pills ───────────────────────────────── */
.role-badge {
    letter-spacing: .3px;
}
.role-student { background:rgba(6,106,201,.10);  color:#066AC9; }
.role-teacher { background:rgba(22,163,74,.10);  color:#16A34A; }
.role-admin   { background:rgba(217,119,6,.10);  color:#D97706; }

/* ── Status badges ──────────────────────────────────── */
.status-badge { letter-spacing:.3px; }
.status-active   { background:rgba(22,163,74,.10); color:#16A34A; }
.status-inactive { background:rgba(107,114,128,.10); color:#6B7280; }
.status-dot {
    width:6px; height:6px; border-radius:50%;
    background: currentColor; display:inline-block;
}

/* ── Action buttons ─────────────────────────────────── */
.action-btn {
    display:inline-flex; align-items:center; justify-content:center;
    width:32px; height:32px; border-radius:8px;
    border:1px solid; font-size:15px;
    cursor:pointer; background:transparent;
    transition: background .15s, color .15s, border-color .15s, transform .1s;
}
.action-btn:hover { transform: scale(1.08); }
.action-btn--view  { border-color:#DBEAFE; color:#066AC9; }
.action-btn--view:hover  { background:#066AC9; color:#fff; border-color:#066AC9; }
.action-btn--edit  { border-color:#D1FAE5; color:#16A34A; }
.action-btn--edit:hover  { background:#16A34A; color:#fff; border-color:#16A34A; }
.action-btn--delete { border-color:#FEE2E2; color:#DC2626; }
.action-btn--delete:hover { background:#DC2626; color:#fff; border-color:#DC2626; }


/* Table head */
#usersTable thead th {
    background: #F8FAFC;
    color: #6B7280;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .5px;
    text-transform: uppercase;
    padding: 14px 16px;
    border-bottom: 2px solid #E5E7EB;
    white-space: nowrap;
}

#usersTable tbody tr {
    transition: background .12s;
}
#usersTable tbody tr:hover td {
    background: #F8FAFC;
}

/* ── Add button ─────────────────────────────────────── */
.btn-add { text-decoration: none; }
.btn-add:hover { opacity: .92; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(6,106,201,.3); }

/* ── Role filter pills ──────────────────────────────── */
.role-pill { text-decoration: none; }

/* ── Rounded helpers ────────────────────────────────── */
.rounded-12 { border-radius: 12px; }
.rounded-10 { border-radius: 10px; }
.h-3 { height: 3px; }
.text-13 { font-size: 13px; }
.text-22 { font-size: 22px; }
.mb-28 { margin-bottom: 28px; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        // Initialiser DataTable
        $("#classesTable").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json",
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
                    className: "btn btn-main btn-sm",
                    text: "Excel",
                },
                {
                    extend: "csv",
                    className: "btn btn-main btn-sm",
                    text: "CSV",
                },
                {
                    extend: "pdf",
                    className: "btn btn-main btn-sm",
                    text: "PDF",
                },
            ],
            order: [[0, "desc"]],
        });
    });
</script>
@endpush