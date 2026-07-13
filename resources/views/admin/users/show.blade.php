@extends('layouts.admin')

@section('title', 'Profil — ' . $user->first_name . ' ' . $user->last_name)

@section('content')

@php
    $roleConf = match($user->role) {
        'student' => [
            'icon'    => 'ph-student',
            'label'   => 'Étudiant',
            'color'   => '#066AC9',
            'bg'      => 'rgba(6,106,201,.10)',
            'bgLight' => '#EFF6FF',
        ],
        'teacher' => [
            'icon'    => 'ph-chalkboard-teacher',
            'label'   => 'Enseignant',
            'color'   => '#16A34A',
            'bg'      => 'rgba(22,163,74,.10)',
            'bgLight' => '#F0FDF4',
        ],
        default => [
            'icon'    => 'ph-shield-check',
            'label'   => 'Administrateur',
            'color'   => '#D97706',
            'bg'      => 'rgba(217,119,6,.10)',
            'bgLight' => '#FFFBEB',
        ],
    };

    $initials   = strtoupper(substr($user->first_name ?? '', 0, 1) . substr($user->last_name ?? '', 0, 1));
    $fullName   = trim(($user->first_name ?? '') . ' ' . ($user->middle_name ? $user->middle_name . ' ' : '') . ($user->last_name ?? ''));
    $student         = ($user->role === 'student') ? ($user->studentDetails ?? null) : null;
    $teacher         = ($user->role === 'teacher') ? ($user->details ?? null) : null;
@endphp

{{-- ── Breadcrumb / actions bar ─────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-24 flex-wrap gap-12">
    <div class="d-flex align-items-center gap-8 text-14 text-neutral-400">
        <a href="{{ route('admin.users.index') }}" class="text-neutral-400 hover-text-main-600 transition-03 text-decoration-none">
            Utilisateurs
        </a>
        <i class="ph ph-caret-right text-12"></i>
        <span class="text-neutral-600 fw-medium">{{ $fullName }}</span>
    </div>
    <div class="d-flex align-items-center gap-8">
        <a href="{{ route('admin.users.edit', $user) }}"
           class="d-flex align-items-center gap-6 px-16 py-9 bg-main-600 text-white rounded-10 text-13 fw-semibold hover-bg-main-700 transition-03 text-decoration-none">
            <i class="ph ph-pencil-simple text-15"></i> Modifier
        </a>
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
              onsubmit="return confirm('Désactiver ce compte ?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="d-flex align-items-center gap-6 px-16 py-9 bg-white text-danger border border-neutral-40 rounded-10 text-13 fw-semibold hover-bg-neutral-20 transition-03">
                <i class="ph ph-trash text-15"></i> Désactiver
            </button>
        </form>
    </div>
</div>

<div class="row gy-4">

    {{-- ══════════════════════════════════════════════════════════════════════
         LEFT — Profile hero + info cards
    ══════════════════════════════════════════════════════════════════════ --}}
    <div class="col-xl-4 col-lg-5">

        {{-- Hero card --}}
        <div class="profile-hero rounded-14 overflow-hidden mb-20">
            {{-- Banner --}}
            <div class="profile-hero__banner position-relative" style="height:90px;background:linear-gradient(135deg, {{ $roleConf['color'] }}cc 0%, {{ $roleConf['color'] }}55 100%);">
                <div class="position-absolute inset-0"
                     style="background:repeating-linear-gradient(45deg,rgba(255,255,255,.04) 0,rgba(255,255,255,.04) 1px,transparent 1px,transparent 8px)">
                </div>
            </div>

            {{-- Avatar --}}
            <div class="px-20 pb-20 bg-white text-center position-relative">
                <div class="profile-avatar mx-auto"
                     style="margin-top:-36px;width:72px;height:72px;border-radius:50%;
                            background:{{ $roleConf['bg'] }};color:{{ $roleConf['color'] }};
                            border:3px solid #fff;box-shadow:0 4px 12px rgba(0,0,0,.10);
                            display:flex;align-items:center;justify-content:center;
                            font-size:26px;font-weight:700;">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="w-100 h-100 rounded-circle object-fit-cover">
                    @else
                        {{ $initials ?: '?' }}
                    @endif
                </div>

                <h5 class="fw-bold text-neutral-700 text-18 mb-4 mt-12">{{ $fullName }}</h5>

                <div class="d-flex align-items-center justify-content-center gap-8 mb-16">
                    <span class="role-pill px-12 py-4 rounded-pill text-12 fw-semibold"
                          style="background:{{ $roleConf['bg'] }};color:{{ $roleConf['color'] }}">
                        <i class="ph {{ $roleConf['icon'] }} me-4"></i>{{ $roleConf['label'] }}
                    </span>
                    @if($user->is_active)
                        <span class="status-dot-pill status-dot-pill--active">
                            <span class="pulse-dot"></span> Actif
                        </span>
                    @else
                        <span class="status-dot-pill status-dot-pill--inactive">
                            <span></span> Inactif
                        </span>
                    @endif
                </div>

                {{-- Contact quick links --}}
                <div class="d-flex flex-column gap-8 text-start">
                    @if($user->email)
                    <div class="info-row">
                        <span class="info-row__icon" style="color:{{ $roleConf['color'] }}"><i class="ph ph-envelope-simple"></i></span>
                        <a href="mailto:{{ $user->email }}" class="info-row__text hover-text-main-600 transition-03 text-decoration-none text-neutral-500 text-truncate">
                            {{ $user->email }}
                        </a>
                    </div>
                    @endif
                    @if($user->phone)
                    <div class="info-row">
                        <span class="info-row__icon" style="color:{{ $roleConf['color'] }}"><i class="ph ph-phone"></i></span>
                        <span class="info-row__text text-neutral-500">{{ $user->phone }}</span>
                    </div>
                    @endif
                    @if($user->city || $user->country)
                    <div class="info-row">
                        <span class="info-row__icon" style="color:{{ $roleConf['color'] }}"><i class="ph ph-map-pin"></i></span>
                        <span class="info-row__text text-neutral-500">
                            {{ collect([$user->city, $user->country])->filter()->implode(', ') }}
                        </span>
                    </div>
                    @endif
                    @if($user->preferred_language)
                    <div class="info-row">
                        <span class="info-row__icon" style="color:{{ $roleConf['color'] }}"><i class="ph ph-globe"></i></span>
                        <span class="info-row__text text-neutral-500">
                            {{ $user->preferred_language === 'fr' ? 'Français' : 'English' }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- System meta --}}
        <div class="info-card mb-20">
            <div class="info-card__header">
                <i class="ph ph-clock" style="color:{{ $roleConf['color'] }}"></i>
                <span>Informations système</span>
            </div>
            <div class="info-card__body">
                <div class="meta-row">
                    <span class="meta-row__label">ID utilisateur</span>
                    <span class="meta-row__val mono">#{{ $user->id }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-row__label">Créé le</span>
                    <span class="meta-row__val">{{ $user->created_at?->format('d/m/Y') ?? '—' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-row__label">Modifié le</span>
                    <span class="meta-row__val">{{ $user->updated_at?->format('d/m/Y') ?? '—' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-row__label">Dernière connexion</span>
                    <span class="meta-row__val">{{ $user->last_login_at?->diffForHumans() ?? 'Jamais' }}</span>
                </div>
                <div class="meta-row border-0 pb-0">
                    <span class="meta-row__label">Email vérifié</span>
                    <span class="meta-row__val">
                        @if($user->email_verified_at)
                            <span class="text-success fw-semibold"><i class="ph ph-check-circle me-4"></i>Oui</span>
                        @else
                            <span class="text-warning fw-semibold"><i class="ph ph-warning-circle me-4"></i>Non</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Quick stats (role-specific) --}}
        @if($user->role === 'student' && $student)
        <div class="info-card">
            <div class="info-card__header">
                <i class="ph ph-chart-bar" style="color:{{ $roleConf['color'] }}"></i>
                <span>Statistiques rapides</span>
            </div>
            <div class="info-card__body p-0">
                @php
                    $enrollments = $student->classEnrollments ?? collect();
                    $marks       = $student->marks ?? collect();
                    $leaves      = $student->leave ?? collect();
                    $payments    = $student->feePayments ?? collect();
                @endphp
                <div class="quick-stat-grid">
                    <div class="quick-stat">
                        <div class="quick-stat__val" style="color:{{ $roleConf['color'] }}">{{ $enrollments->count() }}</div>
                        <div class="quick-stat__label">Classes</div>
                    </div>
                    <div class="quick-stat">
                        <div class="quick-stat__val" style="color:#16A34A">{{ $marks->count() }}</div>
                        <div class="quick-stat__label">Notes</div>
                    </div>
                    <div class="quick-stat">
                        <div class="quick-stat__val" style="color:#D97706">{{ $leaves->count() }}</div>
                        <div class="quick-stat__label">Congés</div>
                    </div>
                    <div class="quick-stat">
                        <div class="quick-stat__val" style="color:#6366F1">{{ $payments->count() }}</div>
                        <div class="quick-stat__label">Paiements</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($user->role === 'teacher' && $teacher)
        <div class="info-card">
            <div class="info-card__header">
                <i class="ph ph-chart-bar" style="color:{{ $roleConf['color'] }}"></i>
                <span>Statistiques rapides</span>
            </div>
            <div class="info-card__body p-0">
                @php
                    $subjects = $teacher->subjects ?? collect();
                    $headed   = $teacher->classesHeaded ?? collect();
                @endphp
                <div class="quick-stat-grid">
                    <div class="quick-stat">
                        <div class="quick-stat__val" style="color:{{ $roleConf['color'] }}">{{ $subjects->count() }}</div>
                        <div class="quick-stat__label">Matières</div>
                    </div>
                    <div class="quick-stat">
                        <div class="quick-stat__val" style="color:#D97706">{{ $headed->count() }}</div>
                        <div class="quick-stat__label">Classes dirigées</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>{{-- /col --}}

    {{-- ══════════════════════════════════════════════════════════════════════
         RIGHT — Tabs content
    ══════════════════════════════════════════════════════════════════════ --}}
    <div class="col-xl-8 col-lg-7">

        {{-- Tab navigation --}}
        <div class="tab-nav mb-20">
            <button class="tab-btn tab-btn--active" data-tab="info">
                <i class="ph ph-user"></i> Informations
            </button>
            @if($user->role === 'student')
            <button class="tab-btn" data-tab="enrollments">
                <i class="ph ph-books"></i> Inscriptions
            </button>
            <button class="tab-btn" data-tab="fees">
                <i class="ph ph-money"></i> Paiements
            </button>
            <button class="tab-btn" data-tab="leaves">
                <i class="ph ph-calendar-x"></i> Congés
            </button>
            @endif
            @if($user->role === 'teacher')
            <button class="tab-btn" data-tab="subjects">
                <i class="ph ph-notepad"></i> Matières
            </button>
            @endif
        </div>

        {{-- ── TAB: Informations personnelles ──────────────────────────── --}}
        <div class="tab-panel tab-panel--active" id="tab-info">

            {{-- Personal details --}}
            <div class="info-card mb-20">
                <div class="info-card__header">
                    <i class="ph ph-identification-card" style="color:{{ $roleConf['color'] }}"></i>
                    <span>Informations personnelles</span>
                </div>
                <div class="info-card__body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-item__label">Prénom</span>
                            <span class="detail-item__val">{{ $user->first_name ?? '—' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-item__label">Nom</span>
                            <span class="detail-item__val">{{ $user->last_name ?? '—' }}</span>
                        </div>
                        @if($user->middle_name)
                        <div class="detail-item">
                            <span class="detail-item__label">Prénom additionnel</span>
                            <span class="detail-item__val">{{ $user->middle_name }}</span>
                        </div>
                        @endif
                        <div class="detail-item">
                            <span class="detail-item__label">Genre</span>
                            <span class="detail-item__val">
                                {{ match($user->gender) { 'M' => 'Masculin', 'F' => 'Féminin', 'other' => 'Autre', default => '—' } }}
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-item__label">Date de naissance</span>
                            <span class="detail-item__val">
                                {{ $user->birth_date ? $user->birth_date->format('d/m/Y') : '—' }}
                                @if($user->birth_date)
                                    <span class="text-neutral-400 text-12">({{ $user->birth_date->age }} ans)</span>
                                @endif
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-item__label">Téléphone</span>
                            <span class="detail-item__val">{{ $user->phone ?? '—' }}</span>
                        </div>
                        @if($user->alt_phone)
                        <div class="detail-item">
                            <span class="detail-item__label">Tél. alternatif</span>
                            <span class="detail-item__val">{{ $user->alt_phone }}</span>
                        </div>
                        @endif
                        <div class="detail-item">
                            <span class="detail-item__label">Email</span>
                            <span class="detail-item__val">
                                <a href="mailto:{{ $user->email }}" class="text-main-600 text-decoration-none hover-underline">
                                    {{ $user->email }}
                                </a>
                            </span>
                        </div>
                        @if($user->address)
                        <div class="detail-item detail-item--full">
                            <span class="detail-item__label">Adresse</span>
                            <span class="detail-item__val">{{ $user->address }}</span>
                        </div>
                        @endif
                        <div class="detail-item">
                            <span class="detail-item__label">Ville</span>
                            <span class="detail-item__val">{{ $user->city ?? '—' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-item__label">Pays</span>
                            <span class="detail-item__val">{{ $user->country ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Student-specific details --}}
            @if($user->role === 'student' && $student)
            <div class="info-card mb-20">
                <div class="info-card__header">
                    <i class="ph ph-student" style="color:{{ $roleConf['color'] }}"></i>
                    <span>Détails étudiant</span>
                </div>
                <div class="info-card__body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-item__label">Matricule</span>
                            <span class="detail-item__val mono">{{ $student->matricule ?? '—' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-item__label">Date d'inscription</span>
                            <span class="detail-item__val">{{ $student->enrollment_date?->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-item__label">Nom du tuteur</span>
                            <span class="detail-item__val">{{ $student->guardian_name ?? '—' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-item__label">Tél. tuteur</span>
                            <span class="detail-item__val">{{ $student->guardian_phone ?? '—' }}</span>
                        </div>
                        @if($student->guardian_email)
                        <div class="detail-item">
                            <span class="detail-item__label">Email tuteur</span>
                            <span class="detail-item__val">{{ $student->guardian_email }}</span>
                        </div>
                        @endif
                        @if($student->blood_group)
                        <div class="detail-item">
                            <span class="detail-item__label">Groupe sanguin</span>
                            <span class="detail-item__val">
                                <span class="badge-blood">{{ $student->blood_group }}</span>
                            </span>
                        </div>
                        @endif
                        @if($student->medical_notes)
                        <div class="detail-item detail-item--full">
                            <span class="detail-item__label">Notes médicales</span>
                            <span class="detail-item__val text-neutral-400">{{ $student->medical_notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Teacher-specific details --}}
            @if($user->role === 'teacher' && $teacher)
            <div class="info-card mb-20">
                <div class="info-card__header">
                    <i class="ph ph-chalkboard-teacher" style="color:{{ $roleConf['color'] }}"></i>
                    <span>Détails enseignant</span>
                </div>
                <div class="info-card__body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-item__label">Numéro employé</span>
                            <span class="detail-item__val mono">{{ $teacher->employee_number ?? '—' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-item__label">Date d'embauche</span>
                            <span class="detail-item__val">{{ $teacher->hire_date?->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        <div class="detail-item detail-item--full">
                            <span class="detail-item__label">Spécialisation</span>
                            <span class="detail-item__val">{{ $teacher->specialization ?? '—' }}</span>
                        </div>
                        @if($teacher->bio)
                        <div class="detail-item detail-item--full">
                            <span class="detail-item__label">Bio</span>
                            <span class="detail-item__val text-neutral-500">{{ $teacher->bio }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>{{-- /tab-info --}}

        {{-- ── TAB: Inscriptions (student only) ────────────────────────── --}}
        @if($user->role === 'student')
        <div class="tab-panel" id="tab-enrollments">
            <div class="info-card">
                <div class="info-card__header">
                    <i class="ph ph-books" style="color:{{ $roleConf['color'] }}"></i>
                    <span>Historique des inscriptions</span>
                </div>
                <div class="info-card__body p-0">
                    @php $enrollments = $student?->classEnrollments?->load('class.program') ?? collect(); @endphp
                    @if($enrollments->isNotEmpty())
                    <table class="show-table w-100">
                        <thead>
                            <tr>
                                <th>Classe</th>
                                <th>Programme</th>
                                <th>Inscrit le</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $e)
                            <tr>
                                <td class="fw-medium text-neutral-600">{{ $e->class->name ?? '—' }}</td>
                                <td class="text-neutral-500">{{ $e->class->program->title_fr ?? '—' }}</td>
                                <td class="text-neutral-500">{{ $e->enrolled_at?->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    @php
                                        $eConf = match($e->status) {
                                            'active'    => ['text' => 'Actif',    'class' => 'badge-status--active'],
                                            'withdrawn' => ['text' => 'Retiré',   'class' => 'badge-status--warn'],
                                            'completed' => ['text' => 'Terminé',  'class' => 'badge-status--info'],
                                            'excluded'  => ['text' => 'Exclu',    'class' => 'badge-status--danger'],
                                            default     => ['text' => $e->status, 'class' => 'badge-status--neutral'],
                                        };
                                    @endphp
                                    <span class="badge-status {{ $eConf['class'] }}">{{ $eConf['text'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <i class="ph ph-books"></i>
                        <p>Aucune inscription enregistrée.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── TAB: Paiements ───────────────────────────────────────────── --}}
        <div class="tab-panel" id="tab-fees">
            <div class="info-card">
                <div class="info-card__header">
                    <i class="ph ph-money" style="color:{{ $roleConf['color'] }}"></i>
                    <span>Historique des paiements</span>
                </div>
                <div class="info-card__body p-0">
                    @php $payments = $student?->feePayments?->load('fee.category') ?? collect(); @endphp
                    @if($payments->isNotEmpty())
                    <table class="show-table w-100">
                        <thead>
                            <tr>
                                <th>Reçu</th>
                                <th>Catégorie</th>
                                <th>Montant payé</th>
                                <th>Méthode</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $p)
                            <tr>
                                <td class="mono text-neutral-500 text-12">{{ $p->receipt_number ?? '—' }}</td>
                                <td class="fw-medium text-neutral-600">{{ $p->fee->category->name ?? '—' }}</td>
                                <td class="fw-semibold" style="color:#16A34A">
                                    {{ number_format($p->amount_paid, 0, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    <span class="badge-method">
                                        {{ match($p->payment_method) {
                                            'cash'          => '💵 Espèces',
                                            'bank_transfer' => '🏦 Virement',
                                            'mobile_money'  => '📱 Mobile Money',
                                            'card'          => '💳 Carte',
                                            'check'         => '📄 Chèque',
                                            default         => ucfirst($p->payment_method ?? '—'),
                                        } }}
                                    </span>
                                </td>
                                <td class="text-neutral-500">{{ $p->paid_on?->format('d/m/Y') ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Total row --}}
                    <div class="px-20 py-14 bg-neutral-20 border-top border-neutral-40 d-flex justify-content-between align-items-center">
                        <span class="text-14 fw-semibold text-neutral-500">Total versé</span>
                        <span class="text-16 fw-bold" style="color:#16A34A">
                            {{ number_format($payments->sum('amount_paid'), 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="ph ph-money"></i>
                        <p>Aucun paiement enregistré.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── TAB: Congés ──────────────────────────────────────────────── --}}
        <div class="tab-panel" id="tab-leaves">
            <div class="info-card">
                <div class="info-card__header">
                    <i class="ph ph-calendar-x" style="color:{{ $roleConf['color'] }}"></i>
                    <span>Demandes de congé</span>
                </div>
                <div class="info-card__body p-0">
                    @php $leaves = $student?->leave ?? collect(); @endphp
                    @if($leaves->isNotEmpty())
                    <table class="show-table w-100">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Du</th>
                                <th>Au</th>
                                <th>Raison</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $l)
                            <tr>
                                <td>
                                    <span class="badge-leave">
                                        {{ match($l->leave_type) {
                                            'medical'  => '🏥 Médical',
                                            'family'   => '👨‍👩‍👧 Famille',
                                            'personal' => '👤 Personnel',
                                            'academic' => '📚 Académique',
                                            default    => ucfirst($l->leave_type),
                                        } }}
                                    </span>
                                </td>
                                <td class="text-neutral-500">{{ $l->start_date?->format('d/m/Y') ?? '—' }}</td>
                                <td class="text-neutral-500">{{ $l->end_date?->format('d/m/Y') ?? '—' }}</td>
                                <td class="text-neutral-400 text-13">{{ \Str::limit($l->reason, 45) }}</td>
                                <td>
                                    @php
                                        $lConf = match($l->status) {
                                            'approved'  => ['text' => 'Approuvé',  'class' => 'badge-status--active'],
                                            'rejected'  => ['text' => 'Rejeté',    'class' => 'badge-status--danger'],
                                            'pending'   => ['text' => 'En attente','class' => 'badge-status--warn'],
                                            'cancelled' => ['text' => 'Annulé',    'class' => 'badge-status--neutral'],
                                            default     => ['text' => $l->status,  'class' => 'badge-status--neutral'],
                                        };
                                    @endphp
                                    <span class="badge-status {{ $lConf['class'] }}">{{ $lConf['text'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <i class="ph ph-calendar-x"></i>
                        <p>Aucune demande de congé.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- ── TAB: Matières (teacher only) ────────────────────────────── --}}
        @if($user->role === 'teacher')
        <div class="tab-panel" id="tab-subjects">
            <div class="info-card">
                <div class="info-card__header">
                    <i class="ph ph-notepad" style="color:{{ $roleConf['color'] }}"></i>
                    <span>Matières enseignées</span>
                </div>
                <div class="info-card__body p-0">
                    @php $subjects = $teacher?->subjects?->load('class') ?? collect(); @endphp
                    @if($subjects->isNotEmpty())
                    <table class="show-table w-100">
                        <thead>
                            <tr>
                                <th>Matière</th>
                                <th>Code</th>
                                <th>Classe</th>
                                <th>Coefficient</th>
                                <th>H/semaine</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $s)
                            <tr>
                                <td class="fw-medium text-neutral-600">{{ $s->name }}</td>
                                <td class="mono text-12 text-neutral-400">{{ $s->code ?? '—' }}</td>
                                <td class="text-neutral-500">{{ $s->class->name ?? '—' }}</td>
                                <td class="text-neutral-600 fw-medium">{{ $s->coefficient }}</td>
                                <td class="text-neutral-500">{{ $s->hours_per_week ?? '—' }}h</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <i class="ph ph-notepad"></i>
                        <p>Aucune matière assignée.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Classes dirigées --}}
            @php $headed = $teacher?->classesHeaded ?? collect(); @endphp
            @if($headed->isNotEmpty())
            <div class="info-card mt-20">
                <div class="info-card__header">
                    <i class="ph ph-crown" style="color:#D97706"></i>
                    <span>Classes dirigées (chef de classe)</span>
                </div>
                <div class="info-card__body p-0">
                    <table class="show-table w-100">
                        <thead>
                            <tr>
                                <th>Classe</th>
                                <th>Section</th>
                                <th>Capacité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($headed as $h)
                            <tr>
                                <td class="fw-medium text-neutral-600">{{ $h->name }}</td>
                                <td class="text-neutral-500">{{ $h->section ?? '—' }}</td>
                                <td class="text-neutral-500">{{ $h->capacity ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        @endif

    </div>{{-- /right col --}}
</div>

@endsection

@push('styles')
<style>
/* ── Helpers ─────────────────────────────────────────── */
.mb-20 { margin-bottom:20px; }
.mb-24 { margin-bottom:24px; }
.mb-16 { margin-bottom:16px; }
.mb-12 { margin-bottom:12px; }
.mb-4  { margin-bottom:4px; }
.mt-12 { margin-top:12px; }
.mt-20 { margin-top:20px; }
.mt-4  { margin-top:4px; }
.me-4  { margin-right:4px; }
.gap-8 { gap:8px; }
.gap-6 { gap:6px; }
.gap-12 { gap:12px; }
.text-15 { font-size:15px; }
.text-13 { font-size:13px; }
.text-12 { font-size:12px; }
.text-18 { font-size:18px; }
.rounded-14 { border-radius:14px; }
.inset-0 { inset:0; }
.mono { font-family: 'Courier New', monospace; }
.object-fit-cover { object-fit:cover; }
.text-truncate { white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px; }

/* ── Profile hero ────────────────────────────────────── */
.profile-hero { box-shadow:0 1px 4px rgba(0,0,0,.06); border:1px solid #F0F1F3; }

/* ── Status pill with pulse ──────────────────────────── */
.status-dot-pill {
    display:inline-flex;align-items:center;gap:5px;
    padding:3px 10px;border-radius:99px;
    font-size:11px;font-weight:600;
}
.status-dot-pill--active { background:rgba(22,163,74,.10);color:#16A34A; }
.status-dot-pill--inactive { background:rgba(107,114,128,.10);color:#6B7280; }
.pulse-dot {
    width:7px;height:7px;border-radius:50%;
    background:currentColor;position:relative;display:inline-block;
    animation:pulse-ring 1.6s ease-out infinite;
}
@keyframes pulse-ring {
    0%   { box-shadow:0 0 0 0 currentColor; }
    70%  { box-shadow:0 0 0 5px transparent; }
    100% { box-shadow:0 0 0 0 transparent; }
}

/* ── Info row (hero quick contacts) ──────────────────── */
.info-row {
    display:flex;align-items:center;gap:10px;
    padding:7px 0;border-bottom:1px solid #F3F4F6;
}
.info-row:last-child { border-bottom:none; }
.info-row__icon { font-size:16px;flex-shrink:0; }
.info-row__text { font-size:13px; }

/* ── Info card ───────────────────────────────────────── */
.info-card {
    background:#fff;border-radius:12px;
    border:1px solid #F0F1F3;overflow:hidden;
    box-shadow:0 1px 3px rgba(0,0,0,.04);
}
.info-card__header {
    display:flex;align-items:center;gap:10px;
    padding:13px 20px;border-bottom:1px solid #F0F1F3;
    background:#FAFBFC;font-size:13px;font-weight:600;color:#374151;
}
.info-card__body { padding:20px; }
.info-card__body.p-0 { padding:0; }

/* ── Meta rows ───────────────────────────────────────── */
.meta-row {
    display:flex;align-items:center;justify-content:space-between;
    padding:9px 0;border-bottom:1px solid #F3F4F6;gap:8px;
}
.meta-row__label { font-size:12px;color:#9CA3AF;font-weight:500; }
.meta-row__val { font-size:13px;color:#374151;font-weight:500;text-align:right; }

/* ── Quick stats grid ────────────────────────────────── */
.quick-stat-grid {
    display:grid;grid-template-columns:repeat(auto-fit,minmax(80px,1fr));
    border-top:1px solid #F3F4F6;
}
.quick-stat {
    padding:16px 12px;text-align:center;
    border-right:1px solid #F3F4F6;
}
.quick-stat:last-child { border-right:none; }
.quick-stat__val { font-size:22px;font-weight:700;line-height:1; }
.quick-stat__label { font-size:11px;color:#9CA3AF;margin-top:4px;font-weight:500; }

/* ── Tab navigation ──────────────────────────────────── */
.tab-nav {
    display:flex;gap:4px;
    background:#fff;padding:6px;border-radius:12px;
    border:1px solid #F0F1F3;box-shadow:0 1px 3px rgba(0,0,0,.04);
    overflow-x:auto;
}
.tab-btn {
    display:flex;align-items:center;gap:7px;
    padding:9px 16px;border-radius:8px;
    border:none;background:transparent;
    font-size:13px;font-weight:500;color:#6B7280;
    cursor:pointer;white-space:nowrap;
    transition:background .15s,color .15s;
    font-family:inherit;
}
.tab-btn:hover { background:#F3F4F6;color:#374151; }
.tab-btn--active {
    background:#066AC9;color:#fff;font-weight:600;
    box-shadow:0 2px 8px rgba(6,106,201,.25);
}

/* ── Tab panels ──────────────────────────────────────── */
.tab-panel { display:none; }
.tab-panel--active { display:block; }

/* ── Detail grid ─────────────────────────────────────── */
.detail-grid {
    display:grid;grid-template-columns:1fr 1fr;gap:0;
}
.detail-item {
    padding:12px 16px;border-bottom:1px solid #F3F4F6;
    border-right:1px solid #F3F4F6;
}
.detail-item:nth-child(even) { border-right:none; }
.detail-item--full {
    grid-column:1/-1;border-right:none;
}
.detail-item__label { font-size:11px;color:#9CA3AF;font-weight:600;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:4px; }
.detail-item__val { font-size:14px;color:#374151;font-weight:500; }

/* ── Tables ──────────────────────────────────────────── */
.show-table { border-collapse:collapse; }
.show-table thead th {
    background:#F8FAFC;color:#6B7280;font-size:11px;
    font-weight:600;letter-spacing:.5px;text-transform:uppercase;
    padding:12px 16px;border-bottom:2px solid #E5E7EB;
    white-space:nowrap;
}
.show-table tbody td {
    padding:12px 16px;border-bottom:1px solid #F3F4F6;
    font-size:13px;color:#374151;vertical-align:middle;
}
.show-table tbody tr:last-child td { border-bottom:none; }
.show-table tbody tr:hover td { background:#F8FAFC; }

/* ── Badges ──────────────────────────────────────────── */
.badge-status {
    display:inline-flex;align-items:center;
    padding:3px 10px;border-radius:99px;
    font-size:11px;font-weight:600;letter-spacing:.3px;
}
.badge-status--active  { background:rgba(22,163,74,.10);color:#16A34A; }
.badge-status--warn    { background:rgba(217,119,6,.10);color:#D97706; }
.badge-status--danger  { background:rgba(220,38,38,.10);color:#DC2626; }
.badge-status--info    { background:rgba(6,106,201,.10);color:#066AC9; }
.badge-status--neutral { background:#F3F4F6;color:#6B7280; }

.badge-method, .badge-leave {
    font-size:12px;color:#374151;
}
.badge-blood {
    display:inline-block;padding:2px 10px;border-radius:6px;
    background:#FEE2E2;color:#DC2626;font-weight:700;font-size:13px;
}
.role-pill { letter-spacing:.3px; }

/* ── Empty state ─────────────────────────────────────── */
.empty-state {
    text-align:center;padding:40px 20px;color:#D1D5DB;
}
.empty-state i { font-size:40px;display:block;margin-bottom:8px; }
.empty-state p { font-size:14px;margin:0;color:#9CA3AF; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btns   = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');

    btns.forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.tab;

            btns.forEach(b => b.classList.remove('tab-btn--active'));
            panels.forEach(p => p.classList.remove('tab-panel--active'));

            this.classList.add('tab-btn--active');
            document.getElementById('tab-' + target)?.classList.add('tab-panel--active');
        });
    });
});
</script>
@endpush