{{-- resources/views/manager/programs/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Créer un programme')

@push('styles')
<style>
    /* Fix Summernote toolbar buttons AND dropdowns */
    .note-toolbar {
        position: relative;
        z-index: 1050;
    }
    .note-toolbar .note-btn {
        background-color: #f8f9fa !important;
        color: #212529 !important;
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
        padding: 4px 8px !important;
    }
    .note-toolbar .note-btn:hover {
        background-color: #e9ecef !important;
        border-color: #b6b8ba !important;
    }
    .note-toolbar .note-btn-group .note-btn {
        background-color: #f8f9fa !important;
        color: #212529 !important;
        border-color: #ced4da !important;
    }
    .note-toolbar .note-btn-group .note-btn.active,
    .note-toolbar .note-btn-group .note-btn:active {
        background-color: #e2e6ea !important;
        border-color: #a8aeb3 !important;
    }

    /* Fix dropdowns inside Summernote toolbar */
    .note-toolbar .dropdown-menu {
        display: none;
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        z-index: 9999 !important;
        min-width: 160px !important;
        padding: 5px 0 !important;
        margin: 2px 0 0 !important;
        background-color: #fff !important;
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
        box-shadow: 0 6px 12px rgba(0,0,0,0.175) !important;
        background-clip: padding-box !important;
    }
    .note-toolbar .dropdown-menu.show {
        display: block !important;
    }
    .note-toolbar .dropdown-menu .dropdown-item {
        display: block !important;
        padding: 3px 20px !important;
        clear: both !important;
        font-weight: 400 !important;
        line-height: 1.42857143 !important;
        color: #333 !important;
        white-space: nowrap !important;
        background-color: transparent !important;
    }
    .note-toolbar .dropdown-menu .dropdown-item:hover {
        background-color: #f8f9fa !important;
        color: #262626 !important;
    }
    .note-toolbar .note-color-btn {
        border: 1px solid #ced4da !important;
    }

    /* Fix editor container */
    .note-editor {
        position: relative;
        overflow: visible !important;
    }
    .note-editor .note-editing-area {
        overflow: visible !important;
    }
    .note-editor .note-toolbar {
        overflow: visible !important;
    }
    .note-editor .note-toolbar .note-btn-group {
        position: relative !important;
        overflow: visible !important;
    }

    /* Fix dropdown toggle icons */
    .note-toolbar .note-btn .note-icon-caret {
        font-size: 10px !important;
        margin-left: 4px !important;
    }
</style>
@endpush

@section('content')
<div class="mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Nouveau programme</h4>
</div>

<form id="programForm" action="{{ route('manager.programs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="bg-white rounded-10 p-24 mb-24">
        <div class="row g-4">
            {{-- Titles --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Titre (EN) <span class="text-danger">*</span></label>
                <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Titre (FR) <span class="text-danger">*</span></label>
                <input type="text" name="title_fr" class="form-control" value="{{ old('title_fr') }}" required>
            </div>

            {{-- Short descriptions --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Brève description (EN)</label>
                <textarea name="short_description_en" rows="3" class="form-control">{{ old('short_description_en') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Brève description (FR)</label>
                <textarea name="short_description_fr" rows="3" class="form-control">{{ old('short_description_fr') }}</textarea>
            </div>

            {{-- Full content --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Contenu (EN) <span class="text-danger">*</span></label>
                <textarea name="content_en" id="content_en" class="form-control summernote" required>{{ old('content_en') }}</textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Contenu (FR) <span class="text-danger">*</span></label>
                <textarea name="content_fr" id="content_fr" class="form-control summernote" required>{{ old('content_fr') }}</textarea>
            </div>

            {{-- Duration & order --}}
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Durée (mois)</label>
                <input type="number" name="duration_months" class="form-control" value="{{ old('duration_months') }}" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Ordre d'affichage</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Statut</label>
                <div class="form-check mt-2">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" {{ old('is_published') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">Publié</label>
                </div>
            </div>

            {{-- Cover image --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Image de couverture</label>
                <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/*">
                <small class="text-neutral-400 text-12">Compression automatique (max 1600px, qualité 0.82).</small>
            </div>

            {{-- Degree fields --}}
            <div class="col-md-12">
                <hr>
                <h5 class="text-16 fw-semibold mb-16">Diplôme délivré</h5>
            </div>
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Code diplôme</label>
                <input type="text" name="degree_code" class="form-control" value="{{ old('degree_code') }}" placeholder="BTS_HND, LICENCE_MASTER...">
            </div>
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Nom (EN)</label>
                <input type="text" name="degree_name_en" class="form-control" value="{{ old('degree_name_en') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label text-14 fw-medium">Nom (FR)</label>
                <input type="text" name="degree_name_fr" class="form-control" value="{{ old('degree_name_fr') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Description (EN)</label>
                <textarea name="degree_description_en" rows="3" class="form-control summernote">{{ old('degree_description_en') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Description (FR)</label>
                <textarea name="degree_description_fr" rows="3" class="form-control summernote">{{ old('degree_description_fr') }}</textarea>
            </div>

            {{-- Certificates (admission requirements) --}}
            <div class="col-md-12">
                <hr>
                <h5 class="text-16 fw-semibold mb-16">Certificats requis pour l'admission</h5>
                <div class="row">
                    @foreach(\App\Models\Certificate::all() as $cert)
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="certificates[]" value="{{ $cert->id }}" id="cert_{{ $cert->id }}" {{ in_array($cert->id, old('certificates', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cert_{{ $cert->id }}">{{ $cert->name }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-12 justify-content-end">
        <a href="{{ route('manager.programs.index') }}" class="btn btn-outline-secondary rounded-pill px-24">Annuler</a>
        <button type="submit" id="submitBtn" class="btn bg-main-600 text-white rounded-pill px-24">Créer</button>
    </div>
</form>


@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

{{-- With these (Bootstrap 5 compatible) --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.8/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.8/dist/summernote-lite.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Summernote initialization (same as before)
    $('.summernote').summernote({
        height: 300,
        minHeight: 200,
        maxHeight: 500,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            ['help', ['help']]
        ],
        callbacks: {
            onInit: function() {
                // Force dropdowns to work with Bootstrap 5
                $('.note-toolbar .dropdown-toggle').on('click', function(e) {
                    e.stopPropagation();
                    var $menu = $(this).next('.dropdown-menu');
                    if ($menu.hasClass('show')) {
                        $menu.removeClass('show');
                    } else {
                        $('.note-toolbar .dropdown-menu').removeClass('show');
                        $menu.addClass('show');
                    }
                });
                // Close dropdowns when clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.note-toolbar .dropdown').length) {
                        $('.note-toolbar .dropdown-menu').removeClass('show');
                    }
                });
            }
        }
    });

    // Image compression logic (same as your existing)
    const form = document.getElementById('programForm');
    const submitBtn = document.getElementById('submitBtn');
    const fileInput = document.getElementById('cover_image');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        $('.summernote').each(function() {
            $(this).summernote('code');
        });

        if (!fileInput.files || fileInput.files.length === 0) {
            form.submit();
            return;
        }

        const file = fileInput.files[0];
        if (!file.type.match(/^image\/(jpeg|jpg|png|gif|webp)$/)) {
            showToast('Format non supporté.', 'error');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Compression...';

        try {
            let compressedBlob;
            if (file.type === 'image/gif') {
                compressedBlob = file;
            } else {
                compressedBlob = await compressImage(file, 1600, 1600, 0.82);
                const fileName = file.name.replace(/\.[^.]+$/, '') + '.jpg';
                compressedBlob = new File([compressedBlob], fileName, { type: 'image/jpeg' });
            }

            const formData = new FormData(form);
            formData.set('cover_image', compressedBlob);

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message || 'Programme créé avec succès !', 'success');
                setTimeout(() => window.location.href = data.redirect || '{{ route('manager.programs.index') }}', 1500);
            } else {
                showToast(data.message || 'Erreur.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Créer';
            }
        } catch (error) {
            console.error(error);
            showToast('Erreur lors du traitement de l\'image.', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Créer';
        }
    });
});
</script>
@endpush