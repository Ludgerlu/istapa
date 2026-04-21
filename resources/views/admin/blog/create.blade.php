{{-- resources/views/admin/blog/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Nouvel article')

@section('content')
<div class="d-flex align-items-center gap-12 mb-24">
    <a href="{{ route('admin.blogs') }}" class="text-neutral-400 hover-text-main-600 transition-03">
        <i class="ph ph-arrow-left text-20"></i>
    </a>
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Nouvel article</h4>
</div>

<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row gy-4">

        {{-- ─── Main content ──────────────────────────────────── --}}
        <div class="col-xl-8">

            {{-- Title --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">
                    Titre de l'article <span class="text-danger">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="form-control border-neutral-40 text-14 py-12 @error('title') is-invalid @enderror"
                       placeholder="Entrez le titre…" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">Slug (URL)</label>
                <div class="input-group">
                    <span class="input-group-text bg-main-25 border-neutral-40 text-14 text-neutral-400">/blog/</span>
                    <input type="text" name="slug" id="slugInput" value="{{ old('slug') }}"
                           class="form-control border-neutral-40 text-14 py-12 @error('slug') is-invalid @enderror"
                           placeholder="généré-automatiquement">
                </div>
                @error('slug')
                    <div class="text-danger text-13 mt-4">{{ $message }}</div>
                @enderror
            </div>

            {{-- Excerpt --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">Résumé</label>
                <textarea name="excerpt" rows="3"
                          class="form-control border-neutral-40 text-14 @error('excerpt') is-invalid @enderror"
                          placeholder="Courte description affichée dans la liste…">{{ old('excerpt') }}</textarea>
                <span class="text-12 text-neutral-400 mt-4 d-block">Laissez vide pour générer automatiquement depuis le contenu.</span>
            </div>

            {{-- Content --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">
                    Contenu <span class="text-danger">*</span>
                </label>
                <textarea name="content" id="contentEditor" rows="16"
                          class="form-control border-neutral-40 text-14 @error('content') is-invalid @enderror"
                          placeholder="Rédigez votre article ici…">{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        {{-- ─── Sidebar options ───────────────────────────────── --}}
        <div class="col-xl-4">

            {{-- Publish box --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <h6 class="fw-medium text-16 text-neutral-500 mb-16">Publication</h6>

                <div class="mb-16">
                    <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">Statut</label>
                    <select name="status" class="form-select border-neutral-40 text-14">
                        <option value="draft"     {{ old('status','draft') === 'draft'     ? 'selected' : '' }}>Brouillon</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publié</option>
                        <option value="archived"  {{ old('status') === 'archived'  ? 'selected' : '' }}>Archivé</option>
                    </select>
                </div>

                <div class="mb-16">
                    <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">Auteur</label>
                    <select name="author_id" class="form-select border-neutral-40 text-14">
                        @foreach($authors as $author)
                        <option value="{{ $author->id }}"
                            {{ old('author_id', auth()->id()) == $author->id ? 'selected' : '' }}>
                            {{ $author->display_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-8 mt-20">
                    <button type="submit" name="status" value="draft"
                            class="btn border border-neutral-40 text-14 text-neutral-500 hover-bg-main-600 hover-text-white rounded-pill px-20 py-9 flex-grow-1">
                        Brouillon
                    </button>
                    <button type="submit" name="status" value="published"
                            class="btn bg-main-600 text-white rounded-pill text-14 px-20 py-9 flex-grow-1">
                        Publier
                    </button>
                </div>
            </div>

            {{-- Cover image --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <h6 class="fw-medium text-16 text-neutral-500 mb-16">Image de couverture</h6>
                <div id="coverPreviewWrap" class="mb-12 d-none">
                    <img id="coverPreview" src="" alt="" class="rounded-10 w-100" style="max-height:200px;object-fit:cover">
                </div>
                <label for="coverImageInput"
                       class="d-flex flex-column align-items-center justify-content-center border border-dashed border-neutral-40 rounded-10 py-24 px-16 cursor-pointer hover-border-main-600 transition-03"
                       style="border-style:dashed!important">
                    <i class="ph ph-image text-40 text-neutral-300 mb-8"></i>
                    <span class="text-14 text-neutral-400">Cliquez pour choisir une image</span>
                    <span class="text-12 text-neutral-300 mt-4">PNG, JPG, WebP — max 2 Mo</span>
                    <input type="file" id="coverImageInput" name="cover_image" accept="image/*" class="d-none">
                </label>
                @error('cover_image')
                    <div class="text-danger text-13 mt-4">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </div>

</form>
@endsection

@push('scripts')
<script>
// Auto-generate slug from title
const titleInput = document.querySelector('[name="title"]');
const slugInput  = document.getElementById('slugInput');
let slugEdited   = false;

titleInput.addEventListener('input', () => {
    if (slugEdited) return;
    slugInput.value = titleInput.value
        .toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-|-$/g, '');
});
slugInput.addEventListener('input', () => { slugEdited = true; });

// Image preview
document.getElementById('coverImageInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('coverPreview').src = e.target.result;
        document.getElementById('coverPreviewWrap').classList.remove('d-none');
    };
    reader.readAsDataURL(file);
});
</script>
@endpush