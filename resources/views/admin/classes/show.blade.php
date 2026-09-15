@extends('layouts.admin')

@section('title', $class->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $class->name }} @if($class->section) ({{ $class->section }}) @endif</h4>
    <div>
        <a href="{{ route('admin.classes.index') }}" class="btn bg-danger-600 rounded-pill">Retour</a>
        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-main rounded-pill"><i class="ph ph-pencil"></i> Modifier</a>
    </div>
</div>

{{-- Basic Info Card --}}
<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row">
        <div class="col-md-3"><strong>Programme :</strong><br>{{ $class->program->slug ?? '—' }}</div>
        <div class="col-md-3"><strong>Année scolaire :</strong><br>{{ $class->academicYear->label ?? '—' }}</div>
        <div class="col-md-3"><strong>Capacité :</strong><br>{{ $class->capacity ?? 'Illimitée' }}</div>
        <div class="col-md-3"><strong>Professeur principal :</strong><br>{{ $class->headTeacher->user->full_name ?? 'Non assigné' }}</div>
    </div>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-24" id="classTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#subjects" type="button">Matières</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#exams" type="button">Examens</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#students" type="button">Élèves</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#attendances" type="button">Présences</button>
    </li>
</ul>

<div class="tab-content">
    {{-- Subjects Tab --}}
    <div class="tab-pane fade show active" id="subjects">
        <div class="bg-white rounded-10 p-24">
            <div class="d-flex justify-content-between mb-16">
                <h5>Matières enseignées ({{ $subjects->count() }})</h5>
                <button type="button" class="btn btn-sm btn-outline-main rounded-pill" data-bs-toggle="modal" data-bs-target="#subjectModal" id="addSubjectBtn">
                    <i class="ph ph-plus"></i> Ajouter
                </button>
            </div>
            @if($subjects->count())
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-main-25">
                        <tr><th>Code</th><th>Nom</th><th>Coefficient</th><th>Heures/semaine</th><th>Enseignant</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                        <tr data-subject-id="{{ $subject->id }}">
                            <td>{{ $subject->code ?? '—' }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->coefficient }}</td>
                            <td>{{ $subject->hours_per_week ?? '—' }}</td>
                            <td>{{ $subject->teacher->user->first_name ?? 'Non assigné' }} {{ $subject->teacher->user->last_name ?? '' }}</td>
                            <td class="d-flex gap-8">
                                <button type="button" class="btn btn-sm bg-warning-600 edit-subject-btn"
                                        data-subject-id="{{ $subject->id }}"
                                        data-name="{{ $subject->name }}"
                                        data-code="{{ $subject->code }}"
                                        data-teacher-id=""
                                        data-coefficient="{{ $subject->coefficient }}"
                                        data-hours="{{ $subject->hours_per_week }}">
                                    <i class="ph ph-pencil"></i>
                                </button>
                                <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm bg-danger-600"><i class="ph ph-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">Aucune matière associée.</p>
            @endif
        </div>
    </div>

    {{-- Exams Tab --}}
    <div class="tab-pane fade" id="exams">
        <div class="bg-white rounded-10 p-24">
            
            <div class="d-flex justify-content-between mb-16">
                <h5>Examens planifiés ({{ $exams->count() }})</h5>
                <a href="{{ route('admin.exams.create', ['class_id' => $class->id]) }}" class="btn btn-sm btn-outline-main rounded-pill"><i class="ph ph-plus"></i> Ajouter</a>
            </div>
            @if($exams->count())
            @foreach($exams as $exam)
            <div class="card mb-20 border">
                <div class="card-header bg-main-25">
                    <strong>
                        {{ $exam->name }} 
                        <small>
                            Du {{ $exam->start_date ? $exam->start_date->format('d/m/Y') : '—' }}
                            au {{ $exam->end_date ? $exam->end_date->format('d/m/Y') : '—' }}
                        </small> 
                    </strong>
                    <a href="{{ route('admin.exams.show', $exam->id) }}" class="btn btn-sm bg-main-600">
                        <i class="ph ph-eye"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr><th>Matière</th><th>Date</th><th>Horaire</th><th>Total</th><th>Notes saisies</th></tr>
                            </thead>
                            <tbody>
                                @foreach($exam->examSubjects as $examSubject)
                                @php $marksCount = $examSubject->marks->count(); @endphp
                                <tr>
                                    <td>{{ $examSubject->subject->name ?? '—' }}</td>
                                    <td>{{ $examSubject->exam_date ? $examSubject->exam_date->format('d/m/Y') : '—' }}</td>
                                    <td>{{ $examSubject->start_time ? \Carbon\Carbon::parse($examSubject->start_time)->format('H:i') : '—' }} - {{ $examSubject->end_time ? \Carbon\Carbon::parse($examSubject->end_time)->format('H:i') : '—' }}</td>
                                    <td>{{ $examSubject->total_mark ?? '—' }}</td>
                                    <td>
                                        @if($marksCount > 0)
                                            <span class="badge bg-success-600">{{ $marksCount }} notes</span>
                                        @else
                                            <span class="badge bg-neutral-400">Aucune</span>
                                        @endif
                                     </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p class="text-muted">Aucun examen planifié.</p>
            @endif
        </div>
    </div>

    {{-- Students Tab --}}
    <div class="tab-pane fade" id="students">
        <div class="bg-white rounded-10 p-24">
            <h5>Élèves inscrits ({{ $students->count() }})</h5>
            @if($students->count())
            <div class="table-responsive">
                <table class="table table-bordered" id="studentsTable">
                    <thead class="bg-main-25">
                        <tr>
                            <th>Matricule</th>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date inscription</th>
                            <th>Solde</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $enrollment)
                        @php
                            $student = $enrollment->student;
                            $studentId = $student->user_id;
                            // Find matching data from $studentsData
                            $sData = collect($studentsData)->firstWhere('id', $studentId);
                            $balance = $sData['balance'] ?? 0;
                            $status = $sData['status'] ?? 'unpaid';
                            $badgeClass = $status === 'paid' ? 'bg-success-600' : ($status === 'partial' ? 'bg-warning-600' : 'bg-danger-600');
                            $badgeText = $status === 'paid' ? 'Soldé' : ($status === 'partial' ? 'Partiel' : 'Impayé');
                        @endphp
                        <tr data-student-id="{{ $studentId }}">
                            <td>{{ $student->matricule ?? '—' }}</td>
                            <td>{{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? '' }}</td>
                            <td>{{ $student->user->email ?? '—' }}</td>
                            <td>{{ $student->user->phone ?? '—' }}</td>
                            <td>{{ $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d/m/Y') : '—' }}</td>
                            <td>
                                <span class="badge {{ $badgeClass }} balance-badge">{{ number_format($balance, 0, ',', ' ') }} FCFA</span>
                                <br>
                                <span class="badge {{ $badgeClass }} status-badge">{{ $badgeText }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-main payment-btn" data-student-id="{{ $studentId }}">
                                    <i class="ph ph-currency-circle-dollar"></i> Paiements
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted">Aucun élève inscrit.</p>
            @endif
        </div>
    </div>

    

    {{-- Attendance Sessions Tab --}}
    <div class="tab-pane fade" id="attendances">
        <div class="bg-white rounded-10 p-24">
            <div class="d-flex justify-content-between align-items-center mb-16">
                <h5 class="mb-0">
                    Présences aujourd'hui
                    <span class="text-muted fs-6 fw-normal">({{ $todaySessions->count() }} session(s))</span>
                </h5>
                <!-- <button type="button" class="btn btn-sm btn-outline-main rounded-pill" data-bs-toggle="modal" data-bs-target="#attendanceFilterModal">
                    <i class="ph ph-plus-circle"></i> Voir toutes les sessions
                </button> -->

                <a href="{{ route('admin.classes.attendances', $class) }}" class="btn btn-sm btn-outline-main rounded-pill">
                    <i class="ph ph-eye"></i> Voir toutes les sessions
                </a>
            </div>

            @if($todaySessions->count())
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-main-25">
                        <tr><th>Matière</th><th>Date</th><th>Horaire</th><th>Enseignant</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach($todaySessions as $session)
                        <tr>
                            <td>{{ $session->subject->name ?? '—' }}</td>
                            <td>{{ $session->session_date->format('d/m/Y') }}</td>
                            <td>{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '—' }} - {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '—' }}</td>
                            <td>{{ $session->takenBy->first_name ?? '' }} {{ $session->takenBy->last_name ?? '' }}</td>
                            <td>
                                <a href="{{ route('admin.attendances.show', $session) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="ph ph-eye"></i> Détails
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted mb-0">Aucune session de présence enregistrée aujourd'hui.</p>
            @endif
        </div>
    </div>

    {{-- Subject Modal --}}
    <div class="modal fade" id="subjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subjectModalLabel">Nouvelle matière</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="subjectForm" method="POST" action="{{ route('admin.subjects.store') }}">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="subject_id" id="subjectId">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Nom *</label>
                                <input type="text" name="name" id="subjectName" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Code</label>
                                <input type="text" name="code" id="subjectCode" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Classe *</label>
                                <select name="class_id" id="subjectClassId" class="form-select" required disabled>
                                    <option value="{{ $class->id }}" selected>{{ $class->name }}</option>
                                </select>
                                <input type="hidden" name="class_id" value="{{ $class->id }}">
                            </div>
                            <div class="col-md-4">
                                <label>Enseignant</label>
                                <select name="teacher_id" id="subjectTeacherId" class="form-select">
                                    <option value="">-- Aucun --</option>
                                    @foreach($teachers ?? [] as $t)
                                        <option value="{{ $t->user_id }}">{{ $t->user->first_name }} {{ $t->user->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Coefficient</label>
                                <input type="number" step="0.5" name="coefficient" id="subjectCoefficient" class="form-control" value="1">
                            </div>
                            <div class="col-md-2">
                                <label>Heures/semaine</label>
                                <input type="number" step="0.5" name="hours_per_week" id="subjectHours" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea name="description" id="subjectDescription" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-danger-600 rounded-pill" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-main rounded-pill" id="subjectSubmitBtn">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Payment Modal --}}
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">
                        Paiements – <span id="modalStudentName"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Student summary --}}
                    <div class="row mb-20">
                        <div class="col-md-4">
                            <div class="card p-16 border">
                                <small class="text-muted">Total dû</small>
                                <h6 id="modalTotalDue" class="mb-0">0 FCFA</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-16 border">
                                <small class="text-muted">Déjà payé</small>
                                <h6 id="modalTotalPaid" class="mb-0">0 FCFA</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-16 border">
                                <small class="text-muted">Solde</small>
                                <h6 id="modalBalance" class="mb-0">0 FCFA</h6>
                            </div>
                        </div>
                    </div>

                    {{-- Payment history --}}
                    <h6 class="mb-12">Historique des versements</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="paymentHistoryTable">
                            <thead class="bg-main-25">
                                <tr>
                                    <th>Date</th>
                                    <th>Catégorie</th>
                                    <th>Montant</th>
                                    <th>Mode</th>
                                    <th>Référence</th>
                                    <th>Enregistré par</th>
                                </tr>
                            </thead>
                            <tbody id="paymentHistoryBody">
                                <tr><td colspan="6" class="text-center text-muted">Aucun paiement</td></tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- New payment form --}}
                    <h6 class="mt-24 mb-12">Enregistrer un nouveau versement</h6>
                    <form id="paymentForm">
                        @csrf
                        <input type="hidden" name="student_id" id="paymentStudentId">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>Montant (FCFA) *</label>
                                <input type="number" name="amount" id="paymentAmount" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label>Date *</label>
                                <input type="date" name="paid_on" id="paymentDate" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Mode de paiement *</label>
                                <select name="payment_method" id="paymentMethod" class="form-select" required>
                                    <option value="cash">Espèces</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="bank_transfer">Virement bancaire</option>
                                    <option value="cheque">Chèque</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Catégorie de frais *</label>
                                <select name="fee_id" id="paymentFeeId" class="form-select" required>
                                @foreach($fees as $fee)
                                    <option value="{{ $fee->id }}">{{ $fee->category->name ?? 'Sans catégorie' }} ({{ number_format($fee->amount, 0, ',', ' ') }} FCFA)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Référence (optionnel)</label>
                            <input type="text" name="transaction_ref" id="paymentRef" class="form-control" placeholder="N° de reçu, ID transaction...">
                        </div>
                        <div class="col-md-12">
                            <label>Notes</label>
                            <textarea name="notes" id="paymentNotes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-12 mt-20">
                        <button type="button" class="btn bg-danger-600 rounded-pill" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-main rounded-pill" id="paymentSubmitBtn">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Attendance Filter Modal --}}
    <div class="modal fade" id="attendanceFilterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-main-25">
                    <h5 class="modal-title">Toutes les sessions de présence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Filters --}}
                    <form id="attendanceFilterForm" class="row g-3 mb-20">
                        <div class="col-md-3">
                            <label>Date début</label>
                            <input type="date" name="date_from" class="form-control" id="filterDateFrom">
                        </div>
                        <div class="col-md-3">
                            <label>Date fin</label>
                            <input type="date" name="date_to" class="form-control" id="filterDateTo">
                        </div>
                        <div class="col-md-3">
                            <label>Matière</label>
                            <select name="subject_id" id="filterSubject" class="form-select">
                                <option value="">Toutes</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-main w-100">Filtrer</button>
                            <button type="button" class="btn btn-outline-secondary w-100 ms-2" id="resetFilters">Réinitialiser</button>
                        </div>
                    </form>

                    {{-- Results Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered" id="attendanceFilterTable">
                            <thead class="bg-main-25">
                                <tr>
                                    <th>Matière</th>
                                    <th>Date</th>
                                    <th>Horaire</th>
                                    <th>Enseignant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceFilterBody">
                                <tr><td colspan="5" class="text-center text-muted">Aucune session trouvée.</td></tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div id="attendanceFilterPagination" class="d-flex justify-content-end mt-16">
                        <!-- dynamically inserted -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-600 rounded-pill" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection



@push('scripts')
<script>
$(document).ready(function() {

    // --- Ensure modal backdrop is removed on hide ---
    $('#subjectModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    // --- Open modal for new subject ---
    $('#addSubjectBtn').on('click', function() {
        resetForm();
        $('#subjectForm').attr('action', '{{ route('admin.subjects.store') }}');
        $('input[name="_method"]').val('POST');
        $('#subjectModalLabel').text('Nouvelle matière');
        $('#subjectSubmitBtn').text('Créer');
        $('#subjectId').val('');
    });

    // --- Open modal for editing ---
    $('.edit-subject-btn').on('click', function() {
        resetForm();
        const btn = $(this);
        const id = btn.data('subject-id');
        const name = btn.data('name');
        const code = btn.data('code') || '';
        const teacherId = btn.data('teacher-id') || '';
        const coefficient = btn.data('coefficient') || 1;
        const hours = btn.data('hours') || '';
        const description = btn.data('description') || '';

        $('#subjectId').val(id);
        $('#subjectName').val(name);
        $('#subjectCode').val(code);
        $('#subjectTeacherId').val(teacherId);
        $('#subjectCoefficient').val(coefficient);
        $('#subjectHours').val(hours);
        $('#subjectDescription').val(description);

        const updateUrl = '{{ route('admin.subjects.update', ':id') }}'.replace(':id', id);
        $('#subjectForm').attr('action', updateUrl);
        $('input[name="_method"]').val('PUT');
        $('#subjectModalLabel').text('Modifier la matière');
        $('#subjectSubmitBtn').text('Mettre à jour');

        $('#subjectModal').modal('show');
    });

    // --- Reset form fields ---
    function resetForm() {
        $('#subjectForm')[0].reset();
        $('#subjectId').val('');
        $('#subjectName').val('');
        $('#subjectCode').val('');
        $('#subjectTeacherId').val('');
        $('#subjectCoefficient').val(1);
        $('#subjectHours').val('');
        $('#subjectDescription').val('');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        $('#subjectModalLabel').text('Nouvelle matière');
        $('#subjectSubmitBtn').text('Créer');
        $('#subjectForm').attr('action', '{{ route('admin.subjects.store') }}');
        $('input[name="_method"]').val('POST');
    }

    // --- AJAX form submission ---
    $('#subjectForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const url = form.attr('action');
        const method = $('input[name="_method"]').val() || 'POST';
        const formData = new FormData(this);

        $('#subjectSubmitBtn').prop('disabled', true).text('Envoi...');

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Hide modal and clean up backdrop
                $('#subjectModal').modal('hide');
                // Force cleanup in case hide didn't remove backdrop
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Erreur', response.message || 'Une erreur est survenue', 'error');
                }
            },
            error: function(xhr) {
                // Handle validation errors (modal stays open)
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    $.each(errors, function(field, messages) {
                        const input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + messages.join(', ') + '</div>');
                    });
                } else {
                    Swal.fire('Erreur', 'Une erreur est survenue. Veuillez réessayer.', 'error');
                }
            },
            complete: function() {
                $('#subjectSubmitBtn').prop('disabled', false).text(
                    $('input[name="_method"]').val() === 'PUT' ? 'Mettre à jour' : 'Créer'
                );
            }
        });
    });
});
</script>

<script>
    // --- Payment modal logic ---
    const studentData = @json($studentsData);

    // Function to populate modal with student data
    function populatePaymentModal(studentId) {
        const data = studentData.find(s => s.id == studentId);
        if (!data) return;

        // Update header
        $('#modalStudentName').text(data.name + ' (' + data.matricule + ')');

        // Update summary
        $('#modalTotalDue').text(new Intl.NumberFormat('fr-FR').format(data.total_fees) + ' FCFA');
        $('#modalTotalPaid').text(new Intl.NumberFormat('fr-FR').format(data.total_paid) + ' FCFA');
        $('#modalBalance').text(new Intl.NumberFormat('fr-FR').format(data.balance) + ' FCFA');

        // Update history table
        const tbody = $('#paymentHistoryBody');
        tbody.empty();
        if (data.payments.length === 0) {
            tbody.html('<tr><td colspan="6" class="text-center text-muted">Aucun paiement</td></tr>');
        } else {
            data.payments.forEach(p => {
                tbody.append(`
                    <tr>
                        <td>${p.date}</td>
                        <td>${p.category}</td>
                        <td>${new Intl.NumberFormat('fr-FR').format(p.amount)} FCFA</td>
                        <td>${p.method}</td>
                        <td>${p.reference || '—'}</td>
                        <td>${p.received_by}</td>
                    </tr>
                `);
            });
        }

        // Set hidden student id
        $('#paymentStudentId').val(studentId);

        // Set today's date as default
        $('#paymentDate').val(new Date().toISOString().split('T')[0]);

        // Reset form fields (except date)
        $('#paymentAmount').val('');
        $('#paymentMethod').val('cash');
        $('#paymentFeeId').val($('#paymentFeeId option:first').val());
        $('#paymentRef').val('');
        $('#paymentNotes').val('');
    }

    // Open modal on payment button click
    $(document).on('click', '.payment-btn', function() {
        const studentId = $(this).data('student-id');
        populatePaymentModal(studentId);
        $('#paymentModal').modal('show');
    });

    // Handle payment form submission
    $('#paymentForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const studentId = $('#paymentStudentId').val();
        const url = '{{ route("admin.fees.students.payments.store", ":id") }}'.replace(':id', studentId);
        const formData = new FormData(this);

        $('#paymentSubmitBtn').prop('disabled', true).text('Envoi...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update modal with new data
                    const newPayment = response.payment;
                    const totals = response.totals;

                    // Update summary
                    $('#modalTotalPaid').text(new Intl.NumberFormat('fr-FR').format(totals.total_paid) + ' FCFA');
                    $('#modalBalance').text(new Intl.NumberFormat('fr-FR').format(totals.balance) + ' FCFA');

                    // Append new payment to history
                    const tbody = $('#paymentHistoryBody');
                    // Remove "no payments" row if exists
                    if (tbody.find('tr').length === 1 && tbody.find('tr td').attr('colspan')) {
                        tbody.empty();
                    }
                    tbody.prepend(`
                        <tr>
                            <td>${newPayment.date}</td>
                            <td>${newPayment.category}</td>
                            <td>${new Intl.NumberFormat('fr-FR').format(newPayment.amount)} FCFA</td>
                            <td>${newPayment.method}</td>
                            <td>${newPayment.reference || '—'}</td>
                            <td>${newPayment.received_by}</td>
                        </tr>
                    `);

                    // Update the corresponding table row (balance badge)
                    const row = $(`#studentsTable tbody tr[data-student-id="${studentId}"]`);
                    const balanceBadge = row.find('.balance-badge');
                    const statusBadge = row.find('.status-badge');
                    const newBalance = totals.balance;
                    const newStatus = totals.status;
                    balanceBadge.text(new Intl.NumberFormat('fr-FR').format(newBalance) + ' FCFA');
                    const badgeClass = newStatus === 'paid' ? 'bg-success-600' : (newStatus === 'partial' ? 'bg-warning-600' : 'bg-danger-600');
                    const badgeText = newStatus === 'paid' ? 'Soldé' : (newStatus === 'partial' ? 'Partiel' : 'Impayé');
                    balanceBadge.removeClass('bg-success-600 bg-warning-600 bg-danger-600').addClass(badgeClass);
                    statusBadge.text(badgeText).removeClass('bg-success-600 bg-warning-600 bg-danger-600').addClass(badgeClass);

                    // Reset form (keep date)
                    $('#paymentAmount').val('');
                    $('#paymentMethod').val('cash');
                    $('#paymentFeeId').val($('#paymentFeeId option:first').val());
                    $('#paymentRef').val('');
                    $('#paymentNotes').val('');

                    // Show success toast
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Erreur', response.message || 'Une erreur est survenue.', 'error');
                }
            },
            error: function(xhr) {
                let msg = 'Une erreur est survenue.';
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    const firstError = Object.values(errors)[0]?.[0] || msg;
                    msg = firstError;
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Erreur', msg, 'error');
            },
            complete: function() {
                $('#paymentSubmitBtn').prop('disabled', false).text('Enregistrer');
            }
        });
    });
</script>
<script>
    // --- Attendance filter modal ---
    const attendanceModal = $('#attendanceFilterModal');
    const filterForm = $('#attendanceFilterForm');
    const filterBody = $('#attendanceFilterBody');
    const filterPagination = $('#attendanceFilterPagination');
    let currentPage = 1;

    function loadAttendanceSessions(page = 1) {
        const formData = filterForm.serialize();
        const classId = {{ $class->id }};

        $.ajax({
            url: '{{ route("admin.classes.attendance-sessions", $class) }}',
            type: 'GET',
            data: formData + '&page=' + page,
            beforeSend: function() {
                filterBody.html('<tr><td colspan="5" class="text-center"><div class="spinner-border text-main-600" role="status"></div></td></tr>');
            },
            success: function(response) {
                const sessions = response.sessions;
                filterBody.empty();
                if (sessions.length === 0) {
                    filterBody.html('<tr><td colspan="5" class="text-center text-muted">Aucune session trouvée.</td></tr>');
                    filterPagination.empty();
                    return;
                }

                sessions.forEach(function(s) {
                    const row = `
                        <tr>
                            <td>${s.subject}</td>
                            <td>${s.date}</td>
                            <td>${s.start_time} - ${s.end_time}</td>
                            <td>${s.taken_by}</td>
                            <td>
                                <a href="${s.details_url}" class="btn btn-sm btn-outline-secondary">
                                    <i class="ph ph-eye"></i> Détails
                                </a>
                            </td>
                        </tr>
                    `;
                    filterBody.append(row);
                });

                // Render pagination
                const pag = response.pagination;
                let pagHtml = '';
                if (pag.last_page > 1) {
                    pagHtml += '<ul class="pagination">';
                    if (pag.prev_page_url) {
                        pagHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${pag.current_page - 1}">Précédent</a></li>`;
                    }
                    for (let i = 1; i <= pag.last_page; i++) {
                        pagHtml += `<li class="page-item ${i === pag.current_page ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                    }
                    if (pag.next_page_url) {
                        pagHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${pag.current_page + 1}">Suivant</a></li>`;
                    }
                    pagHtml += '</ul>';
                }
                filterPagination.html(pagHtml);
            },
            error: function() {
                filterBody.html('<tr><td colspan="5" class="text-center text-danger">Erreur de chargement.</td></tr>');
            }
        });
    }

    // Open modal → load first page
    attendanceModal.on('show.bs.modal', function() {
        // Reset filters to empty
        filterForm.find('input[type="date"]').val('');
        filterForm.find('select').val('');
        currentPage = 1;
        loadAttendanceSessions(1);
    });

    // Handle filter submit
    filterForm.on('submit', function(e) {
        e.preventDefault();
        currentPage = 1;
        loadAttendanceSessions(1);
    });

    // Reset filters
    $('#resetFilters').on('click', function() {
        filterForm.find('input[type="date"]').val('');
        filterForm.find('select').val('');
        currentPage = 1;
        loadAttendanceSessions(1);
    });

    // Pagination click (delegated)
    filterPagination.on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            currentPage = page;
            loadAttendanceSessions(page);
        }
    });
</script>
@endpush