@extends('layouts.admin')

@section('title', 'Créer un programme')

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

            {{-- Short descriptions (plain) --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Brève description (EN)</label>
                <textarea name="short_description_en" rows="3" class="form-control">{{ old('short_description_en') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Brève description (FR)</label>
                <textarea name="short_description_fr" rows="3" class="form-control">{{ old('short_description_fr') }}</textarea>
            </div>

            {{-- Full content with Summernote --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Contenu (EN) <span class="text-danger">*</span></label>
                <textarea name="content_en" id="content_en" class="form-control summernote" required>{{ old('content_en') }}</textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Contenu (FR) <span class="text-danger">*</span></label>
                <textarea name="content_fr" id="content_fr" class="form-control summernote" required>{{ old('content_fr') }}</textarea>
            </div>

            {{-- Duration & sort order --}}
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Durée (en mois)</label>
                <input type="number" name="duration_months" class="form-control" value="{{ old('duration_months') }}" min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label text-14 fw-medium">Ordre d'affichage</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>

            {{-- Cover image --}}
            <div class="col-md-12">
                <label class="form-label text-14 fw-medium">Image de couverture</label>
                <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/*">
                <small class="text-neutral-400 text-12">L'image sera compressée automatiquement (max 1600px, qualité 0.82).</small>
            </div>

            {{-- Published status --}}
            <div class="col-md-12">
                <div class="form-check">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" {{ old('is_published') ? 'checked' : '' }}>
                    <label class="form-check-label text-14" for="is_published">Publié (visible sur le site)</label>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-12 justify-content-end">
        <a href="{{ route('manager.programs.index') }}" class="btn btn-outline-secondary rounded-pill px-24">Annuler</a>
        <button type="submit" id="submitBtn" class="btn bg-main-600 text-white rounded-pill px-24">Créer</button>
    </div>
</form>

{{-- Summernote assets --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Summernote on both content fields
    $('.summernote').summernote({
        height: 250,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            // Ensure that when the form is submitted, the textarea gets the updated HTML
            onBlur: function() {
                // Summernote already syncs on blur, but we can force sync if needed
            }
        }
    });

    // ---- Image compression and form submission (same as before) ----
    const form = document.getElementById('programForm');
    const submitBtn = document.getElementById('submitBtn');
    const fileInput = document.getElementById('cover_image');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Sync Summernote content to textareas
        $('.summernote').each(function() {
            $(this).summernote('code');
        });

        if (!fileInput.files || fileInput.files.length === 0) {
            form.submit();
            return;
        }

        const file = fileInput.files[0];
        if (!file.type.match(/^image\/(jpeg|jpg|png|gif|webp)$/)) {
            showToast('Format d\'image non supporté.', 'error');
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
                const errorMsg = data.message || 'Une erreur est survenue.';
                showToast(errorMsg, 'error');
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
@endsection