@extends('layouts.admin')

@section('title', 'Modifier — ' . ($user->full_name ?? $user->first_name . ' ' . $user->last_name))

@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-28">
    <div>
        <h4 class="fw-semibold text-neutral-500 text-20 mb-4">Modifier l'utilisateur</h4>
        <p class="text-14 text-neutral-400 mb-0">
            <a href="{{ route('admin.users.index') }}" class="text-neutral-400 hover-text-main-600 transition-03 text-decoration-none">
                <i class="ph ph-arrow-left me-4"></i> Retour à la liste
            </a>
        </p>
    </div>
    <a href="{{ route('admin.users.show', $user) }}"
       class="d-flex align-items-center gap-8 px-16 py-9 bg-white text-neutral-500 border border-neutral-40 rounded-10 text-14 fw-medium hover-bg-neutral-20 transition-03 text-decoration-none">
        <i class="ph ph-eye text-16"></i>
        Voir le profil
    </a>
</div>

<form method="POST" action="{{ route('admin.users.update', $user) }}" id="editUserForm">
    @csrf @method('PUT')

    <div class="row gy-4">

        {{-- ══ LEFT COLUMN ══════════════════════════════════════════════════════ --}}
        <div class="col-xl-8">

            {{-- User identity card (role is fixed on edit) --}}
            <div class="form-card mb-20">
                <div class="form-card__header">
                    @php
                        $roleConf = match($user->role) {
                            'student' => ['icon' => 'ph-student',            'label' => 'Étudiant',       'color' => '#066AC9', 'bg' => 'rgba(6,106,201,.10)'],
                            'teacher' => ['icon' => 'ph-chalkboard-teacher', 'label' => 'Enseignant',     'color' => '#16A34A', 'bg' => 'rgba(22,163,74,.10)'],
                            default   => ['icon' => 'ph-shield-check',       'label' => 'Administrateur', 'color' => '#D97706', 'bg' => 'rgba(217,119,6,.10)'],
                        };
                        $initials = strtoupper(substr($user->first_name ?? '', 0, 1) . substr($user->last_name ?? '', 0, 1));
                    @endphp
                    <i class="ph {{ $roleConf['icon'] }} text-main-600 text-18"></i>
                    <span>Identité de l'utilisateur</span>
                </div>
                <div class="form-card__body">
                    <div class="d-flex align-items-center gap-16 p-16 rounded-10 mb-4"
                         style="background:{{ $roleConf['bg'] }};border:1px dashed {{ $roleConf['color'] }}33">
                        <div class="user-avatar-lg d-flex align-items-center justify-content-center rounded-circle fw-bold text-18 flex-shrink-0"
                             style="width:54px;height:54px;background:{{ $roleConf['bg'] }};color:{{ $roleConf['color'] }};border:2px solid {{ $roleConf['color'] }}33">
                            {{ $initials ?: '?' }}
                        </div>
                        <div>
                            <div class="fw-semibold text-16 text-neutral-600">
                                {{ $user->full_name ?? $user->first_name . ' ' . $user->last_name }}
                            </div>
                            <div class="d-flex align-items-center gap-8 mt-4">
                                <span class="role-badge px-10 py-4 rounded-pill text-12 fw-semibold"
                                      style="background:{{ $roleConf['bg'] }};color:{{ $roleConf['color'] }}">
                                    <i class="ph {{ $roleConf['icon'] }} me-4"></i>{{ $roleConf['label'] }}
                                </span>
                                <span class="text-13 text-neutral-400">ID #{{ $user->id }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-12 text-neutral-400 mb-0 mt-8">
                        <i class="ph ph-info me-4"></i>
                        Le rôle ne peut pas être modifié après la création du compte.
                    </p>
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
                                <input type="text" name="first_name"
                                       value="{{ old('first_name', $user->first_name) }}"
                                       class="field-input" placeholder="ex : Jean">
                                @error('first_name')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('last_name') ? 'field-group--error' : '' }}">
                                <label class="field-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="last_name"
                                       value="{{ old('last_name', $user->last_name) }}"
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
                                    <input type="email" name="email"
                                           value="{{ old('email', $user->email) }}"
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
                                    <input type="text" name="phone"
                                           value="{{ old('phone', $user->phone) }}"
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
                                    <option value="M"     {{ old('gender', $user->gender) === 'M'     ? 'selected' : '' }}>Masculin</option>
                                    <option value="F"     {{ old('gender', $user->gender) === 'F'     ? 'selected' : '' }}>Féminin</option>
                                    <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('gender')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('birth_date') ? 'field-group--error' : '' }}">
                                <label class="field-label">Date de naissance</label>
                                <input type="date" name="birth_date"
                                       value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                       class="field-input">
                                @error('birth_date')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Student-specific fields --}}
            @if($user->role === 'student')
            <div class="form-card mb-20">
                <div class="form-card__header">
                    <i class="ph ph-student text-main-600 text-18"></i>
                    <span>Détails étudiant</span>
                </div>
                <div class="form-card__body">
                    @php $sd = $user ?? null; @endphp
                    <div class="row gy-16">
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('class_id') ? 'field-group--error' : '' }}">
                                <label class="field-label">Classe <span class="text-danger">*</span></label>
                                <select name="class_id" class="field-input field-select">
                                    <option value="">— Sélectionner une classe —</option>
                                    @foreach(\App\Models\Classes::orderBy('name')->get() as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('class_id', $user->class_id ?? '') == $class->id ? 'selected' : '' }}>
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
                                <input type="text" name="matricule"
                                       value="{{ old('matricule', $sd->matricule ?? '') }}"
                                       class="field-input" placeholder="ex : IST-2024-001">
                                @error('matricule')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group">
                                <label class="field-label">Nom du tuteur</label>
                                <input type="text" name="guardian_name"
                                       value="{{ old('guardian_name', $sd->guardian_name ?? '') }}"
                                       class="field-input" placeholder="ex : Marie Dupont">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group">
                                <label class="field-label">Téléphone du tuteur</label>
                                <input type="text" name="guardian_phone"
                                       value="{{ old('guardian_phone', $sd->guardian_phone ?? '') }}"
                                       class="field-input" placeholder="+237 6XX XXX XXX">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Teacher-specific fields --}}
            @if($user->role === 'teacher')
            <div class="form-card mb-20">
                <div class="form-card__header">
                    <i class="ph ph-chalkboard-teacher text-main-600 text-18"></i>
                    <span>Détails enseignant</span>
                </div>
                <div class="form-card__body">
                    @php $td = $user ?? null; @endphp
                    <div class="row gy-16">
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('specialization') ? 'field-group--error' : '' }}">
                                <label class="field-label">Spécialisation <span class="text-danger">*</span></label>
                                <input type="text" name="specialization"
                                       value="{{ old('specialization', $td->specialization ?? '') }}"
                                       class="field-input" placeholder="ex : Mathématiques">
                                @error('specialization')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group {{ $errors->has('employee_number') ? 'field-group--error' : '' }}">
                                <label class="field-label">Numéro employé</label>
                                <input type="text" name="employee_number"
                                       value="{{ old('employee_number', $td->employee_number ?? '') }}"
                                       class="field-input" placeholder="ex : EMP-001">
                                @error('employee_number')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="field-group">
                                <label class="field-label">Date d'embauche</label>
                                <input type="date" name="hire_date"
                                       value="{{ old('hire_date', $td->hire_date?->format('Y-m-d') ?? '') }}"
                                       class="field-input">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="field-group">
                                <label class="field-label">Bio</label>
                                <textarea name="bio" class="field-input field-textarea" rows="3"
                                          placeholder="Brève description de l'enseignant…">{{ old('bio', $td->bio ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Admin-specific fields --}}
            @if($user->role === 'admin')
            <div class="form-card mb-20">
                <div class="form-card__header">
                    <i class="ph ph-shield-check text-main-600 text-18"></i>
                    <span>Détails administrateur</span>
                </div>
                <div class="form-card__body">
                    <div class="row gy-16">
                        <div class="col-sm-8">
                            <div class="field-group {{ $errors->has('title') ? 'field-group--error' : '' }}">
                                <label class="field-label">Titre / Fonction</label>
                                <input type="text" name="title"
                                       value="{{ old('title', $user->title ?? '') }}"
                                       class="field-input" placeholder="ex : Directeur pédagogique">
                                @error('title')
                                    <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

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
                    {{-- Nouveau mot de passe (optionnel en édition) --}}
                    <div class="field-group mb-16 {{ $errors->has('password') ? 'field-group--error' : '' }}">
                        <label class="field-label">
                            Nouveau mot de passe
                            <span class="text-neutral-400 fw-normal">(laisser vide pour conserver)</span>
                        </label>
                        <div class="field-input-icon field-input-icon--toggle">
                            <i class="ph ph-lock-simple"></i>
                            <input type="password" name="password" class="field-input"
                                   placeholder="••••••••" id="pwdInput" autocomplete="new-password">
                            <button type="button" class="pwd-toggle" onclick="togglePwd('pwdInput', this)">
                                <i class="ph ph-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error"><i class="ph ph-warning-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="field-group mb-20 {{ $errors->has('password_confirmation') ? 'field-group--error' : '' }}">
                        <label class="field-label">Confirmer le nouveau mot de passe</label>
                        <div class="field-input-icon field-input-icon--toggle">
                            <i class="ph ph-lock-simple"></i>
                            <input type="password" name="password_confirmation" class="field-input"
                                   placeholder="••••••••" id="pwdConfirm" autocomplete="new-password">
                            <button type="button" class="pwd-toggle" onclick="togglePwd('pwdConfirm', this)">
                                <i class="ph ph-eye"></i>
                            </button>
                        </div>
                    </div>

                    <hr class="border-neutral-40 mb-20">

                    <div class="field-group mb-16">
                        <label class="field-label">Statut du compte</label>
                        <label class="toggle-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <span class="toggle-switch__track"></span>
                            <span class="toggle-switch__labels">
                                <span class="on-label">Actif</span>
                                <span class="off-label">Inactif</span>
                            </span>
                        </label>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Langue préférée</label>
                        <select name="preferred_language" class="field-input field-select">
                            <option value="fr" {{ old('preferred_language', $user->preferred_language) === 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ old('preferred_language', $user->preferred_language) === 'en' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Meta info --}}
            <div class="form-card mb-20">
                <div class="form-card__header">
                    <i class="ph ph-clock text-main-600 text-18"></i>
                    <span>Informations système</span>
                </div>
                <div class="form-card__body">
                    <div class="meta-item">
                        <span class="meta-item__label">Créé le</span>
                        <span class="meta-item__value">{{ $user->created_at?->format('d/m/Y à H:i') ?? '—' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-item__label">Modifié le</span>
                        <span class="meta-item__value">{{ $user->updated_at?->format('d/m/Y à H:i') ?? '—' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-item__label">Dernière connexion</span>
                        <span class="meta-item__value">{{ $user->last_login_at?->format('d/m/Y à H:i') ?? 'Jamais' }}</span>
                    </div>
                    <div class="meta-item border-0 pb-0">
                        <span class="meta-item__label">Email vérifié</span>
                        <span class="meta-item__value">
                            @if($user->email_verified_at)
                                <span style="color:#16A34A"><i class="ph ph-check-circle me-4"></i>Oui</span>
                            @else
                                <span style="color:#D97706"><i class="ph ph-warning me-4"></i>Non</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Form actions --}}
            <div class="d-flex flex-column gap-10">
                <button type="submit" class="form-submit-btn">
                    <i class="ph ph-floppy-disk text-18"></i>
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.users.index') }}" class="form-cancel-btn">
                    Annuler
                </a>
            </div>

            {{-- Danger zone --}}
            <div class="form-card mt-20" style="border-color:#FEE2E2">
                <div class="form-card__header" style="background:#FFF5F5;border-bottom-color:#FEE2E2">
                    <i class="ph ph-warning text-18" style="color:#DC2626"></i>
                    <span style="color:#DC2626">Zone de danger</span>
                </div>
                <div class="form-card__body">
                    <p class="text-13 text-neutral-400 mb-12">
                        La suppression désactivera le compte de cet utilisateur. Cette action peut être annulée.
                    </p>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Désactiver le compte de {{ addslashes($user->first_name) }} ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="danger-btn w-100">
                            <i class="ph ph-trash"></i>
                            Désactiver ce compte
                        </button>
                    </form>
                </div>
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
.mb-12  { margin-bottom: 12px; }
.mb-4   { margin-bottom: 4px; }
.mt-8   { margin-top: 8px; }
.mt-20  { margin-top: 20px; }
.mt-4   { margin-top: 4px; }
.me-4   { margin-right: 4px; }
.gap-10 { gap: 10px; }
.gap-8  { gap: 8px; }
.gy-16  { --bs-gutter-y: 16px; }
.text-18 { font-size: 18px; }
.text-16 { font-size: 16px; }
.text-13 { font-size: 13px; }
.text-12 { font-size: 12px; }

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
.form-card__body { padding: 20px; }

/* ── Field groups ────────────────────────────────────── */
.field-group { display: flex; flex-direction: column; gap: 6px; }
.field-label { font-size: 13px; font-weight: 600; color: #374151; }
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
.field-error { font-size: 12px; color: #DC2626; display: flex; align-items: center; gap: 4px; }

/* ── Toggle switch ───────────────────────────────────── */
.toggle-switch { display: flex; align-items: center; gap: 10px; cursor: pointer; }
.toggle-switch input[type="checkbox"] { display: none; }
.toggle-switch__track {
    width: 42px; height: 24px;
    border-radius: 12px; background: #D1D5DB;
    position: relative; transition: background .2s; flex-shrink: 0;
}
.toggle-switch__track::after {
    content: ''; position: absolute;
    top: 3px; left: 3px;
    width: 18px; height: 18px;
    border-radius: 50%; background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
    transition: left .2s;
}
.toggle-switch input:checked + .toggle-switch__track { background: #066AC9; }
.toggle-switch input:checked + .toggle-switch__track::after { left: 21px; }
.toggle-switch__labels { font-size: 13px; font-weight: 500; color: #374151; }
.toggle-switch input:checked ~ .toggle-switch__labels .off-label,
.toggle-switch__labels .on-label { display: none; }
.toggle-switch input:checked ~ .toggle-switch__labels .on-label { display: inline; }

/* ── Meta info list ──────────────────────────────────── */
.meta-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #F3F4F6;
    gap: 8px;
}
.meta-item__label { font-size: 12px; color: #9CA3AF; font-weight: 500; }
.meta-item__value { font-size: 13px; color: #374151; font-weight: 500; text-align: right; }

/* ── Role badge ──────────────────────────────────────── */
.role-badge { letter-spacing: .3px; }

/* ── Submit / Cancel / Danger buttons ───────────────── */
.form-submit-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 12px 20px;
    background: #066AC9; color: #fff;
    border: none; border-radius: 10px;
    font-size: 14px; font-weight: 600;
    cursor: pointer; transition: background .2s, box-shadow .2s, transform .1s;
    font-family: inherit;
}
.form-submit-btn:hover {
    background: #0558A8;
    box-shadow: 0 4px 14px rgba(6,106,201,.3);
    transform: translateY(-1px);
}
.form-cancel-btn {
    display: flex; align-items: center; justify-content: center;
    width: 100%; padding: 11px 20px;
    background: #fff; color: #6B7280;
    border: 1px solid #E5E7EB; border-radius: 10px;
    font-size: 14px; font-weight: 500;
    text-decoration: none; transition: background .15s, color .15s, border-color .15s;
}
.form-cancel-btn:hover { background: #F3F4F6; color: #374151; border-color: #D1D5DB; }
.danger-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px 16px;
    background: #fff; color: #DC2626;
    border: 1px solid #FCA5A5; border-radius: 8px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; transition: background .15s, box-shadow .15s;
    font-family: inherit;
}
.danger-btn:hover { background: #FEF2F2; box-shadow: 0 2px 8px rgba(220,38,38,.12); }
</style>
@endpush

@push('scripts')
<script>
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.querySelector('i').className = isText ? 'ph ph-eye' : 'ph ph-eye-slash';
}
</script>
@endpush