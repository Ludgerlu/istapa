@extends('layouts.admin')

@section('title', 'Ajouter un utilisateur')

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-28">
    <div>
        <h4 class="fw-semibold text-neutral-500 text-20 mb-4">Ajouter un utilisateur</h4>
        <p class="text-14 text-neutral-400 mb-0">
            <a href="{{ route('admin.users.index') }}" class="text-neutral-400 hover-text-main-600 transition-03 text-decoration-none">
                <i class="ph ph-arrow-left me-4"></i> Retour à la liste
            </a>
        </p>
    </div>
</div>

<form method="POST" action="{{ route('admin.users.store') }}" id="createUserForm">
    @csrf

    <div class="row gy-4">

        {{-- ══ LEFT COLUMN ══════════════════════════════════════════════════════ --}}
        <div class="col-xl-8">

            {{-- Role Selector --}}
            <div class="form-card mb-20">
                <div class="form-card__header">
                    <i class="ph ph-identification-badge text-main-600 text-18"></i>
                    <span>Rôle de l'utilisateur</span>
                </div>
                <div class="form-card__body">
                    <div class="row gy-3">
                        @foreach([
                            'student' => ['label' => 'Étudiant',       'icon' => 'ph-student',              'color' => '#066AC9', 'bg' => 'rgba(6,106,201,.08)'],
                            'teacher' => ['label' => 'Enseignant',     'icon' => 'ph-chalkboard-teacher',   'color' => '#16A34A', 'bg' => 'rgba(22,163,74,.08)'],
                            'admin'   => ['label' => 'Administrateur', 'icon' => 'ph-shield-check',         'color' => '#D97706', 'bg' => 'rgba(217,119,6,.08)'],
                        ] as $value => $conf)
                        <div class="col-sm-4">
                            <label class="role-card {{ old('role', 'student') === $value ? 'role-card--active' : '' }}"
                                   data-role="{{ $value }}"
                                   style="--role-color:{{ $conf['color'] }};--role-bg:{{ $conf['bg'] }}">
                                <input type="radio" name="role" value="{{ $value }}"
                                       {{ old('role', 'student') === $value ? 'checked' : '' }}>
                                <div class="role-card__icon">
                                    <i class="ph {{ $conf['icon'] }}"></i>
                                </div>
                                <span class="role-card__label">{{ $conf['label'] }}</span>
                                <div class="role-card__check"><i class="ph-bold ph-check"></i></div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('role')
                        <div class="field-error mt-8"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="form-card mb-20">
                <div class="form-card__header">
                    <i class="ph ph-user text-main-600 text-18"></i>
                    <span>Informations personnelles</span>
                </div>
                <div class="form-card__body">
                    <div class="row gy-16">
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('first_name') ? 'field-group--error' : '' }}">
                                <label class="field-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                       class="field-input" placeholder="ex : Jean">
                                @error('first_name')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('last_name') ? 'field-group--error' : '' }}">
                                <label class="field-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                       class="field-input" placeholder="ex : Dupont">
                                @error('last_name')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('email') ? 'field-group--error' : '' }}">
                                <label class="field-label">Email <span class="text-danger">*</span></label>
                                <div class="field-input-icon">
                                    <i class="ph ph-envelope-simple"></i>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           class="field-input" placeholder="jean@istapa.cm">
                                </div>
                                @error('email')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('phone') ? 'field-group--error' : '' }}">
                                <label class="field-label">Téléphone</label>
                                <div class="field-input-icon">
                                    <i class="ph ph-phone"></i>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                           class="field-input" placeholder="+237 6XX XXX XXX">
                                </div>
                                @error('phone')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('gender') ? 'field-group--error' : '' }}">
                                <label class="field-label">Genre</label>
                                <select name="gender" class="field-input field-select">
                                    <option value="">— Sélectionner —</option>
                                    <option value="M"     {{ old('gender') === 'M'     ? 'selected' : '' }}>Masculin</option>
                                    <option value="F"     {{ old('gender') === 'F'     ? 'selected' : '' }}>Féminin</option>
                                    <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('gender')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('birth_date') ? 'field-group--error' : '' }}">
                                <label class="field-label">Date de naissance</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="field-input">
                                @error('birth_date')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Student-specific fields --}}
            <div class="form-card mb-20 role-fields" id="fields-student">
                <div class="form-card__header">
                    <i class="ph ph-student text-main-600 text-18"></i>
                    <span>Détails étudiant</span>
                </div>
                <div class="form-card__body">
                    <div class="row gy-16">
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('class_id') ? 'field-group--error' : '' }}">
                                <label class="field-label">Classe <span class="text-danger">*</span></label>
                                <select name="class_id" class="field-input field-select">
                                    <option value="">— Sélectionner une classe —</option>
                                    @foreach(\App\Models\Classes::orderBy('name')->get() as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}{{ $class->section ? ' – ' . $class->section : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('matricule') ? 'field-group--error' : '' }}">
                                <label class="field-label">Matricule</label>
                                <input type="text" name="matricule" value="{{ old('matricule') }}"
                                       class="field-input" placeholder="ex : IST-2024-001">
                                @error('matricule')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group">
                                <label class="field-label">Nom du tuteur</label>
                                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}"
                                       class="field-input" placeholder="ex : Marie Dupont">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group">
                                <label class="field-label">Téléphone du tuteur</label>
                                <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}"
                                       class="field-input" placeholder="+237 6XX XXX XXX">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Teacher-specific fields --}}
            <div class="form-card mb-20 role-fields" id="fields-teacher" style="display:none">
                <div class="form-card__header">
                    <i class="ph ph-chalkboard-teacher text-main-600 text-18"></i>
                    <span>Détails enseignant</span>
                </div>
                <div class="form-card__body">
                    <div class="row gy-16">
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('specialization') ? 'field-group--error' : '' }}">
                                <label class="field-label">Spécialisation <span class="text-danger">*</span></label>
                                <input type="text" name="specialization" value="{{ old('specialization') }}"
                                       class="field-input" placeholder="ex : Mathématiques">
                                @error('specialization')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('employee_number') ? 'field-group--error' : '' }}">
                                <label class="field-label">Numéro employé</label>
                                <input type="text" name="employee_number" value="{{ old('employee_number') }}"
                                       class="field-input" placeholder="ex : EMP-001">
                                @error('employee_number')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group">
                                <label class="field-label">Date d'embauche</label>
                                <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="field-input">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-group">
                                <label class="field-label">Bio</label>
                                <textarea name="bio" class="field-input field-textarea"
                                          placeholder="Brève description de l'enseignant…" rows="3">{{ old('bio') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Admin-specific fields --}}
            <div class="form-card mb-20 role-fields" id="fields-admin" style="display:none">
                <div class="form-card__header">
                    <i class="ph ph-shield-check text-main-600 text-18"></i>
                    <span>Détails administrateur</span>
                </div>
                <div class="form-card__body">
                    <div class="row gy-16">
                        <div class="col-sm-8">
                            <div class="field-group {{ $errors->has('title') ? 'field-group--error' : '' }}">
                                <label class="field-label">Titre / Fonction <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                       class="field-input" placeholder="ex : Directeur pédagogique">
                                @error('title')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══ RIGHT COLUMN ═════════════════════════════════════════════════════ --}}
        <div class="col-xl-4">

            {{-- Account settings --}}
            <div class="form-card mb-20">
                <div class="form-card__header">
                    <i class="ph ph-lock-key text-main-600 text-18"></i>
                    <span>Compte & accès</span>
                </div>
                <div class="form-card__body">
                    <div class="field-group mb-16 {{ $errors->has('password') ? 'field-group--error' : '' }}">
                        <label class="field-label">Mot de passe <span class="text-danger">*</span></label>
                        <div class="field-input-icon field-input-icon--toggle">
                            <i class="ph ph-lock-simple"></i>
                            <input type="password" name="password" class="field-input" placeholder="••••••••" id="pwdInput">
                            <button type="button" class="pwd-toggle" onclick="togglePwd('pwdInput', this)">
                                <i class="ph ph-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field-group mb-16 {{ $errors->has('password_confirmation') ? 'field-group--error' : '' }}">
                        <label class="field-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                        <div class="field-input-icon field-input-icon--toggle">
                            <i class="ph ph-lock-simple"></i>
                            <input type="password" name="password_confirmation" class="field-input" placeholder="••••••••" id="pwdConfirm">
                            <button type="button" class="pwd-toggle" onclick="togglePwd('pwdConfirm', this)">
                                <i class="ph ph-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Statut du compte</label>
                        <div class="toggle-switch-group">
                            <label class="toggle-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1"
                                       {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <span class="toggle-switch__track"></span>
                                <span class="toggle-switch__labels">
                                    <span class="on-label">Actif</span>
                                    <span class="off-label">Inactif</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Langue --}}
            <div class="form-card mb-20">
                <div class="form-card__header">
                    <i class="ph ph-globe text-main-600 text-18"></i>
                    <span>Préférences</span>
                </div>
                <div class="form-card__body">
                    <div class="field-group">
                        <label class="field-label">Langue préférée</label>
                        <select name="preferred_language" class="field-input field-select">
                            <option value="fr" {{ old('preferred_language', 'fr') === 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ old('preferred_language') === 'en' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Form actions --}}
            <div class="d-flex flex-column gap-10">
                <button type="submit" class="form-submit-btn">
                    <i class="ph ph-plus-circle text-18"></i>
                    Créer l'utilisateur
                </button>
                <a href="{{ route('admin.users.index') }}" class="form-cancel-btn">
                    Annuler
                </a>
            </div>
        </div>

    </div>{{-- end row --}}
</form>

@endsection

@push('styles')
<style>
/* ── Layout helpers ──────────────────────────────────── */
.mb-20  { margin-bottom: 20px; }
.mb-28  { margin-bottom: 28px; }
.mb-16  { margin-bottom: 16px; }
.mt-8   { margin-top: 8px; }
.me-4   { margin-right: 4px; }
.gap-10 { gap: 10px; }
.gy-16  { --bs-gutter-y: 16px; }
.text-18 { font-size: 18px; }

/* ── Form Card ───────────────────────────────────────── */
.form-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #F0F1F3;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
.form-card__header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    border-bottom: 1px solid #F0F1F3;
    background: #FAFBFC;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
}
.form-card__body {
    padding: 20px;
}

/* ── Role cards ──────────────────────────────────────── */
.role-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px 12px;
    border: 2px solid #E5E7EB;
    border-radius: 10px;
    cursor: pointer;
    transition: border-color .2s, background .2s, box-shadow .2s;
    position: relative;
    text-align: center;
    background: #fff;
    user-select: none;
}
.role-card input[type="radio"] { display: none; }
.role-card__icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    background: #F3F4F6;
    font-size: 22px;
    color: #6B7280;
    transition: background .2s, color .2s;
}
.role-card__label {
    font-size: 13px;
    font-weight: 600;
    color: #6B7280;
    transition: color .2s;
}
.role-card__check {
    position: absolute;
    top: 8px; right: 8px;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: #E5E7EB;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
    color: transparent;
    transition: background .2s, color .2s;
}
.role-card--active {
    border-color: var(--role-color);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--role-color) 15%, transparent);
}
.role-card--active .role-card__icon {
    background: var(--role-bg);
    color: var(--role-color);
}
.role-card--active .role-card__label { color: var(--role-color); }
.role-card--active .role-card__check {
    background: var(--role-color);
    color: #fff;
}
.role-card:hover:not(.role-card--active) {
    border-color: #CBD5E1;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}

/* ── Field groups ────────────────────────────────────── */
.field-group { display: flex; flex-direction: column; gap: 6px; }
.field-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}
.field-input {
    width: 100%;
    padding: 9px 14px;
    border: 1px solid #E5E7EB;
    border-radius: 8px;
    font-size: 14px;
    color: #111827;
    background: #fff;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    font-family: inherit;
}
.field-input::placeholder { color: #9CA3AF; }
.field-input:focus {
    border-color: #066AC9;
    box-shadow: 0 0 0 3px rgba(6,106,201,.12);
}
.field-group--error .field-input {
    border-color: #DC2626;
    box-shadow: 0 0 0 3px rgba(220,38,38,.08);
}
.field-select { cursor: pointer; appearance: auto; }
.field-textarea { resize: vertical; min-height: 80px; }

/* Icon inputs */
.field-input-icon {
    position: relative;
    display: flex; align-items: center;
}
.field-input-icon > i:first-child {
    position: absolute; left: 12px;
    font-size: 16px; color: #9CA3AF;
    pointer-events: none; z-index: 1;
}
.field-input-icon .field-input { padding-left: 36px; }
.field-input-icon--toggle .field-input { padding-right: 40px; }
.pwd-toggle {
    position: absolute; right: 10px;
    background: none; border: none; cursor: pointer;
    color: #9CA3AF; font-size: 16px; padding: 4px;
    line-height: 1; transition: color .15s;
}
.pwd-toggle:hover { color: #066AC9; }

/* Field error */
.field-error {
    font-size: 12px;
    color: #DC2626;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* ── Toggle switch ───────────────────────────────────── */
.toggle-switch { display: flex; align-items: center; gap: 10px; cursor: pointer; }
.toggle-switch input[type="checkbox"] { display: none; }
.toggle-switch__track {
    width: 42px; height: 24px;
    border-radius: 12px;
    background: #D1D5DB;
    position: relative;
    transition: background .2s;
    flex-shrink: 0;
}
.toggle-switch__track::after {
    content: '';
    position: absolute;
    top: 3px; left: 3px;
    width: 18px; height: 18px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
    transition: left .2s;
}
.toggle-switch input:checked + .toggle-switch__track { background: #066AC9; }
.toggle-switch input:checked + .toggle-switch__track::after { left: 21px; }
.toggle-switch__labels { font-size: 13px; font-weight: 500; color: #374151; }
.toggle-switch input:checked ~ .toggle-switch__labels .off-label,
.toggle-switch__labels .on-label { display: none; }
.toggle-switch input:checked ~ .toggle-switch__labels .on-label { display: inline; }

/* ── Submit / Cancel buttons ─────────────────────────── */
.form-submit-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%;
    padding: 12px 20px;
    background: #066AC9;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, box-shadow .2s, transform .1s;
    font-family: inherit;
}
.form-submit-btn:hover {
    background: #0558A8;
    box-shadow: 0 4px 14px rgba(6,106,201,.3);
    transform: translateY(-1px);
}
.form-cancel-btn {
    display: flex; align-items: center; justify-content: center;
    width: 100%;
    padding: 11px 20px;
    background: #fff;
    color: #6B7280;
    border: 1px solid #E5E7EB;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: background .15s, color .15s, border-color .15s;
}
.form-cancel-btn:hover { background: #F3F4F6; color: #374151; border-color: #D1D5DB; }
</style>
@endpush

@push('scripts')
<script>
// ── Role card toggle ─────────────────────────────────────────────────────────
document.querySelectorAll('.role-card').forEach(card => {
    card.addEventListener('click', function () {
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
        switchRole(radio.value);
    });
});

function switchRole(role) {
    // Update card states
    document.querySelectorAll('.role-card').forEach(card => {
        const isActive = card.dataset.role === role;
        card.classList.toggle('role-card--active', isActive);
    });
    // Show/hide role-specific sections
    document.querySelectorAll('.role-fields').forEach(section => {
        section.style.display = section.id === 'fields-' + role ? 'block' : 'none';
    });
}

// ── Password visibility toggle ───────────────────────────────────────────────
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.querySelector('i').className = isText ? 'ph ph-eye' : 'ph ph-eye-slash';
}

// ── Init ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="role"]:checked');
    if (checked) switchRole(checked.value);
});
</script>
@endpush