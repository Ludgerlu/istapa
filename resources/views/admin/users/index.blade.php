@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-28">
    <div>
        <h4 class="fw-semibold text-neutral-500 text-20 mb-4">Gestion des utilisateurs</h4>
        <p class="text-14 text-neutral-400 mb-0">Gérez les étudiants, enseignants et administrateurs</p>
    </div>
    <a href="{{ route('admin.users.create') }}"
       class="btn-add d-flex align-items-center gap-8 px-20 py-10 bg-main-600 text-white rounded-10 text-14 fw-medium hover-bg-main-700 transition-03 border-0">
        <i class="ph ph-plus-circle text-18"></i>
        Ajouter un utilisateur
    </a>
</div>

{{-- ═══ KPI CARDS ══════════════════════════════════════════════════════════════ --}}
<div class="row gy-4 mb-28">
    {{-- Students --}}
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card px-20 py-20 bg-white rounded-12 d-flex align-items-center gap-16 position-relative overflow-hidden">
            <div class="stat-card__icon w-52 h-52 rounded-12 d-flex align-items-center justify-content-center flex-shrink-0" style="background:rgba(6,106,201,.12)">
                <i class="ph ph-student text-24" style="color:#066AC9"></i>
            </div>
            <div>
                <span class="text-13 fw-normal text-neutral-400 d-block mb-4">Étudiants</span>
                <h6 class="text-22 fw-bold text-neutral-600 mb-0">{{ number_format($stats['students']) }}</h6>
            </div>
            <div class="stat-card__bar position-absolute bottom-0 start-0 h-3 w-100" style="background:rgba(6,106,201,.20)">
                <div class="h-100" style="width:{{ $stats['students'] > 0 ? min(100, $stats['students'] / max(1,($stats['students']+$stats['teachers']+$stats['admins'])) * 100) : 0 }}%;background:#066AC9;transition:width .8s ease"></div>
            </div>
        </div>
    </div>

    {{-- Teachers --}}
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card px-20 py-20 bg-white rounded-12 d-flex align-items-center gap-16 position-relative overflow-hidden">
            <div class="stat-card__icon w-52 h-52 rounded-12 d-flex align-items-center justify-content-center flex-shrink-0" style="background:rgba(34,197,94,.12)">
                <i class="ph ph-chalkboard-teacher text-24" style="color:#16A34A"></i>
            </div>
            <div>
                <span class="text-13 fw-normal text-neutral-400 d-block mb-4">Enseignants</span>
                <h6 class="text-22 fw-bold text-neutral-600 mb-0">{{ number_format($stats['teachers']) }}</h6>
            </div>
            <div class="stat-card__bar position-absolute bottom-0 start-0 h-3 w-100" style="background:rgba(34,197,94,.20)">
                <div class="h-100" style="width:{{ $stats['teachers'] > 0 ? min(100, $stats['teachers'] / max(1,($stats['students']+$stats['teachers']+$stats['admins'])) * 100) : 0 }}%;background:#22C55E;transition:width .8s ease"></div>
            </div>
        </div>
    </div>

    {{-- Admins --}}
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card px-20 py-20 bg-white rounded-12 d-flex align-items-center gap-16 position-relative overflow-hidden">
            <div class="stat-card__icon w-52 h-52 rounded-12 d-flex align-items-center justify-content-center flex-shrink-0" style="background:rgba(245,158,11,.12)">
                <i class="ph ph-shield-check text-24" style="color:#D97706"></i>
            </div>
            <div>
                <span class="text-13 fw-normal text-neutral-400 d-block mb-4">Administrateurs</span>
                <h6 class="text-22 fw-bold text-neutral-600 mb-0">{{ number_format($stats['admins']) }}</h6>
            </div>
            <div class="stat-card__bar position-absolute bottom-0 start-0 h-3 w-100" style="background:rgba(245,158,11,.20)">
                <div class="h-100" style="width:{{ $stats['admins'] > 0 ? min(100, $stats['admins'] / max(1,($stats['students']+$stats['teachers']+$stats['admins'])) * 100) : 0 }}%;background:#F59E0B;transition:width .8s ease"></div>
            </div>
        </div>
    </div>

    {{-- Active --}}
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card px-20 py-20 bg-white rounded-12 d-flex align-items-center gap-16 position-relative overflow-hidden">
            <div class="stat-card__icon w-52 h-52 rounded-12 d-flex align-items-center justify-content-center flex-shrink-0" style="background:rgba(99,102,241,.12)">
                <i class="ph ph-check-circle text-24" style="color:#6366F1"></i>
            </div>
            <div>
                <span class="text-13 fw-normal text-neutral-400 d-block mb-4">Utilisateurs actifs</span>
                <h6 class="text-22 fw-bold text-neutral-600 mb-0">{{ number_format($stats['active']) }}</h6>
            </div>
            <div class="stat-card__bar position-absolute bottom-0 start-0 h-3 w-100" style="background:rgba(99,102,241,.20)">
                <div class="h-100" style="width:{{ ($stats['students']+$stats['teachers']+$stats['admins']) > 0 ? min(100, $stats['active'] / ($stats['students']+$stats['teachers']+$stats['admins']) * 100) : 0 }}%;background:#6366F1;transition:width .8s ease"></div>
            </div>
        </div>
    </div>
</div>

{{-- ═══ TABLE CARD ═══════════════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-12 overflow-hidden" style="box-shadow:0 1px 4px rgba(0,0,0,.06)">

    {{-- Card Header --}}
    <div class="px-24 py-18 border-bottom border-neutral-40 d-flex align-items-center justify-content-between flex-wrap gap-12">
        <div class="d-flex align-items-center gap-10">
            <span class="w-8 h-8 rounded-circle bg-main-600 d-inline-block"></span>
            <span class="text-16 fw-semibold text-neutral-600">Tous les utilisateurs</span>
        </div>

        {{-- Role filter pills --}}
        <div class="d-flex align-items-center gap-8 flex-wrap">
            <a href="{{ route('admin.users.index') }}"
               class="role-pill px-16 py-6 rounded-pill text-13 fw-medium border transition-03 {{ !request('role') ? 'bg-main-600 text-white border-main-600' : 'bg-white text-neutral-500 border-neutral-40 hover-bg-main-25 hover-border-main-600 hover-text-main-600' }}">
                Tous
            </a>
            @foreach(['student' => ['Étudiants','#066AC9'], 'teacher' => ['Enseignants','#16A34A'], 'admin' => ['Admins','#D97706']] as $role => [$label, $color])
            <a href="{{ route('admin.users.index', ['role' => $role]) }}"
               class="role-pill px-16 py-6 rounded-pill text-13 fw-medium border transition-03 {{ request('role') === $role ? 'text-white border-transparent' : 'bg-white text-neutral-500 border-neutral-40 hover-bg-main-25' }}"
               style="{{ request('role') === $role ? "background:{$color};border-color:{$color}" : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Table --}}
    <div class="px-16 py-16">
        <table id="usersTable" class="w-100" style="width:100%">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Rôle</th>
                    <th>Email</th>
                    <th>Classe / Dépt.</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    @php
                        $initials  = strtoupper(substr($user->first_name ?? $user->name ?? '', 0, 1) . substr($user->last_name ?? '', 0, 1));
                        $roleConf  = match($user->role) {
                            'student' => ['label' => 'Étudiant',    'bg' => 'rgba(6,106,201,.12)',   'color' => '#066AC9',  'badge' => 'role-student'],
                            'teacher' => ['label' => 'Enseignant',  'bg' => 'rgba(22,163,74,.12)',   'color' => '#16A34A',  'badge' => 'role-teacher'],
                            default   => ['label' => 'Admin',       'bg' => 'rgba(217,119,6,.12)',   'color' => '#D97706',  'badge' => 'role-admin'],
                        };
                    @endphp
                    <tr>
                        {{-- Name --}}
                        <td>
                            <div class="d-flex align-items-center gap-10">
                                <div class="user-avatar flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle text-13 fw-bold"
                                     style="width:36px;height:36px;background:{{ $roleConf['bg'] }};color:{{ $roleConf['color'] }}">
                                    {{ $initials ?: '?' }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="d-block text-14 fw-semibold text-neutral-600 hover-text-main-600 transition-03 text-decoration-none">
                                        {{ $user->full_name ?? ($user->first_name . ' ' . $user->last_name) }}
                                    </a>
                                    <span class="text-12 text-neutral-400">ID #{{ $user->id }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Role --}}
                        <td>
                            <span class="role-badge {{ $roleConf['badge'] }} px-12 py-5 rounded-pill text-12 fw-semibold">
                                {{ $roleConf['label'] }}
                            </span>
                        </td>

                        {{-- Email --}}
                        <td>
                            <span class="text-14 text-neutral-500">{{ $user->email }}</span>
                        </td>

                        {{-- Class / Dept --}}
                        <td>
                            <span class="text-14 text-neutral-500">{{ $user->class_dept ?? '—' }}</span>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($user->is_active)
                                <span class="status-badge status-active d-inline-flex align-items-center gap-6 px-12 py-5 rounded-pill text-12 fw-semibold">
                                    <span class="status-dot"></span> Actif
                                </span>
                            @else
                                <span class="status-badge status-inactive d-inline-flex align-items-center gap-6 px-12 py-5 rounded-pill text-12 fw-semibold">
                                    <span class="status-dot"></span> Inactif
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="d-flex align-items-center gap-6">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="action-btn action-btn--view"
                                   title="Voir">
                                    <i class="ph ph-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="action-btn action-btn--edit"
                                   title="Modifier">
                                    <i class="ph ph-pencil-simple"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Désactiver cet utilisateur ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-btn--delete" title="Supprimer">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-neutral-400 py-32">
                            <i class="ph ph-users text-48 d-block mb-8 text-neutral-300"></i>
                            Aucun utilisateur trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
    $('#usersTable').DataTable({
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
        dom: "<'row'<'col-sm-12 col-md-8 mb-3'l><'col-sm-12 col-md-4 mb-3'f>>" +
            "<'row'<'col-md-6 mb-3'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: "excel",
                className: "btn bg-main-600 text-white btn-sm",
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
            },
            {
                extend: "csv",
                className: "btn bg-main-600 text-white btn-sm",
                text: '<i class="bi bi-filetype-csv"></i> CSV',
            },
            {
                extend: "pdf",
                className: "btn bg-main-600 text-white btn-sm",
                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
            },
        ],
        language: {
            search:          '<i class="ph ph-magnifying-glass"></i>',
            searchPlaceholder: 'Rechercher…',
            lengthMenu:      'Afficher _MENU_ lignes',
            info:            'Affichage de _START_ à _END_ sur _TOTAL_ utilisateurs',
            infoEmpty:       'Aucun utilisateur',
            infoFiltered:    '(filtré sur _MAX_ utilisateurs)',
            paginate: {
                first:    '«',
                last:     '»',
                next:     '›',
                previous: '‹',
            },
            emptyTable:      'Aucun utilisateur trouvé.',
            zeroRecords:     'Aucun résultat pour cette recherche.',
        },
        order: [[0, 'asc']],
        drawCallback: function () {
            // Animate new rows on draw
            $('#usersTable tbody tr').addClass('dt-row-visible');
        }
    });
});
</script>
@endpush