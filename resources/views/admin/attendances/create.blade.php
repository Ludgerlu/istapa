@extends('layouts.admin')

@section('title', 'Prendre la présence')

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Nouvelle session de présence</h4>
</div>

<form method="POST" action="{{ route('admin.attendances.store') }}" id="attendanceForm">
    @csrf
    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-3">
            <div class="col-md-4">
                <label>Classe *</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Matière *</label>
                <select name="subject_id" id="subject_id" class="form-select" required disabled>
                    <option value="">D'abord choisir la classe</option>
                </select>
            </div>
            <div class="col-md-2">
                <label>Date *</label>
                <input type="date" name="session_date" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-2">
                <label>Heure début</label>
                <input type="time" name="start_time" class="form-control">
            </div>
            <div class="col-md-2">
                <label>Heure fin</label>
                <input type="time" name="end_time" class="form-control">
            </div>
            <div class="col-md-12">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-10 p-24" id="studentsContainer" style="display: none;">
        <div class="d-flex justify-content-between align-items-center mb-16">
            <h5 class="mb-0">Liste des élèves</h5>
            <button type="button" class="btn btn-outline-main rounded-pill" data-bs-toggle="modal" data-bs-target="#qrScannerModal">
                <i class="ph ph-qr-code"></i> Scanner QR code
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="studentsTable">
                <thead class="bg-main-25">
                    <tr><th>Élève</th><th>Statut</th><th>Commentaire</th></tr>
                </thead>
                <tbody id="studentsBody"></tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end gap-12 mt-24">
            <button type="submit" class="btn btn-main rounded-pill px-30">Enregistrer la présence</button>
        </div>
    </div>
</form>

{{-- QR Code Scanner Modal --}}
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-main-25">
                <h5 class="modal-title">Scanner un QR code élève</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="qr-reader" style="width: 100%;"></div>
                <div id="qr-reader-results" class="mt-16">
                    <div class="alert alert-info">En attente de scan...</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #qr-reader {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    #qr-reader video {
        width: 100%;
        height: auto;
    }
    .scanned-highlight {
        background-color: #d1fae5 !important;
        transition: background-color 0.3s;
    }
</style>
@endpush

@push('scripts')
<!-- Include html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrCode;
    let studentsMap = {}; // Store student IDs by matri or id for quick matching

    const classSelect = document.getElementById('class_id');
    const subjectSelect = document.getElementById('subject_id');
    const studentsContainer = document.getElementById('studentsContainer');
    const studentsBody = document.getElementById('studentsBody');

    // Handle class change: load subjects & students, rebuild map
    classSelect.addEventListener('change', function() {
        const classId = this.value;
        if (!classId) {
            subjectSelect.disabled = true;
            subjectSelect.innerHTML = '<option value="">D\'abord choisir la classe</option>';
            studentsContainer.style.display = 'none';
            if (html5QrCode) html5QrCode.stop();
            return;
        }

        // Load subjects
        fetch(`/admin/attendances/get-subjects/${classId}`)
            .then(res => res.json())
            .then(data => {
                subjectSelect.disabled = false;
                subjectSelect.innerHTML = '<option value="">-- Choisir une matière --</option>';
                data.forEach(subj => {
                    subjectSelect.innerHTML += `<option value="${subj.id}">${subj.name}</option>`;
                });
            });

        // Load students
        fetch(`/admin/attendances/get-students/${classId}`)
            .then(res => res.json())
            .then(students => {
                studentsContainer.style.display = 'block';
                studentsBody.innerHTML = '';
                studentsMap = {};

                students.forEach(student => {
                    // Add row
                    const rowId = `student-${student.id}`;
                    const row = document.createElement('tr');
                    row.id = rowId;
                    row.innerHTML = `
                        <td>
                            ${student.name}
                            <br><small class="text-muted">${student.matricule}</small>
                            <input type="hidden" name="students[${student.id}][id]" value="${student.id}">
                         </td>
                         <td>
                            <select name="students[${student.id}][status]" class="form-select student-status" data-student-id="${student.id}" required>
                                <option value="present">Présent</option>
                                <option value="absent" selected>Absent</option>
                                <option value="late">En retard</option>
                                <option value="excused">Excusé</option>
                            </select>
                         </td>
                         <td>
                            <input type="text" name="students[${student.id}][comment]" class="form-control" placeholder="Optionnel">
                         </td>
                    `;
                    studentsBody.appendChild(row);

                    // Store in map for QR matching (by both ID and matricule)
                    studentsMap[student.id] = { rowId, studentId: student.id };
                    if (student.matricule) {
                        studentsMap[student.matricule] = { rowId, studentId: student.id };
                    }
                });
            });
    });

    // Function to mark student as present
    function markStudentPresent(identifier) {
        const match = studentsMap[identifier];
        if (!match) {
            showScanResult(`Élève non trouvé : "${identifier}"`, 'danger');
            return false;
        }

        const row = document.getElementById(match.rowId);
        if (!row) return false;

        const statusSelect = row.querySelector('.student-status');
        if (statusSelect) {
            statusSelect.value = 'present';
            // Highlight row briefly
            row.classList.add('scanned-highlight');
            setTimeout(() => row.classList.remove('scanned-highlight'), 1000);
            showScanResult(`✓ ${identifier} marqué(e) présent(e)`, 'success');
            return true;
        }
        return false;
    }

    function showScanResult(message, type = 'info') {
        const resultDiv = document.getElementById('qr-reader-results');
        resultDiv.innerHTML = `<div class="alert alert-${type === 'success' ? 'success' : (type === 'danger' ? 'danger' : 'info')} mb-0">${message}</div>`;
        setTimeout(() => {
            if (resultDiv.firstChild) resultDiv.firstChild.remove();
            resultDiv.innerHTML = '<div class="alert alert-info">En attente de scan...</div>';
        }, 2000);
    }

    // Initialize QR scanner when modal is opened
    const modal = document.getElementById('qrScannerModal');
    modal.addEventListener('shown.bs.modal', async () => {
        if (html5QrCode) {
            try {
                await html5QrCode.start({ facingMode: "environment" }, {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                }, (decodedText) => {
                    // Success callback
                    markStudentPresent(decodedText.trim());
                }, (error) => {
                    // Ignore scanning errors (will keep trying)
                    console.warn(error);
                });
            } catch (err) {
                console.error("Unable to start scanning", err);
                showScanResult("Impossible d'accéder à la caméra. Vérifiez les permissions.", 'danger');
            }
        } else {
            html5QrCode = new Html5Qrcode("qr-reader");
            try {
                await html5QrCode.start({ facingMode: "environment" }, {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                }, (decodedText) => {
                    markStudentPresent(decodedText.trim());
                }, (error) => {
                    console.warn(error);
                });
            } catch (err) {
                console.error(err);
                showScanResult("Erreur caméra : " + err, 'danger');
            }
        }
    });

    modal.addEventListener('hidden.bs.modal', async () => {
        if (html5QrCode && html5QrCode.isScanning) {
            await html5QrCode.stop();
        }
    });
</script>
@endpush