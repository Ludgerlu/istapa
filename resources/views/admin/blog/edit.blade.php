{{-- resources/views/admin/blog/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Modifier — ' . $blog->title)

@section('content')
<div class="d-flex align-items-center gap-12 mb-24">
    <a href="{{ route('admin.blogs') }}" class="text-neutral-400 hover-text-main-600 transition-03">
        <i class="ph ph-arrow-left text-20"></i>
    </a>
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Modifier l'article</h4>
    <span class="ms-auto">
        @if($blog->status === 'published')
            <a href="{{ route('blog.details', $blog->id) }}" target="_blank"
               class="text-12 text-main-600 d-flex align-items-center gap-4 hover-underline">
                <i class="ph ph-arrow-square-out"></i> Voir sur le site
            </a>
        @endif
    </span>
</div>

<form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row gy-4">

        {{-- ─── Main content ──────────────────────────────────── --}}
        <div class="col-xl-8">

            {{-- Title --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">
                    Titre <span class="text-danger">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $blog->title) }}"
                       class="form-control border-neutral-40 text-14 py-12 @error('title') is-invalid @enderror"
                       required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Slug --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">Slug (URL)</label>
                <div class="input-group">
                    <span class="input-group-text bg-main-25 border-neutral-40 text-14 text-neutral-400">/blog/</span>
                    <input type="text" name="slug" value="{{ old('slug', $blog->slug) }}"
                           class="form-control border-neutral-40 text-14 py-12 @error('slug') is-invalid @enderror">
                </div>
                @error('slug') <div class="text-danger text-13 mt-4">{{ $message }}</div> @enderror
            </div>

            {{-- Excerpt --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">Résumé</label>
                <textarea name="excerpt" rows="3"
                          class="form-control border-neutral-40 text-14 @error('excerpt') is-invalid @enderror">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>

            {{-- Content --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">
                    Contenu <span class="text-danger">*</span>
                </label>
                <textarea name="content" id="contentEditor" rows="16"
                          class="form-control border-neutral-40 text-14 @error('content') is-invalid @enderror">{{ old('content', $blog->content) }}</textarea>
                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ─── Sidebar ─────────────────────────────────────────── --}}
        <div class="col-xl-4">

            {{-- Publish box --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <h6 class="fw-medium text-16 text-neutral-500 mb-16">Publication</h6>

                <div class="mb-12 d-flex align-items-center justify-content-between text-14 text-neutral-500">
                    <span>Créé le :</span>
                    <span>{{ $blog->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="mb-16 d-flex align-items-center justify-content-between text-14 text-neutral-500">
                    <span>Modifié le :</span>
                    <span>{{ $blog->updated_at->format('d/m/Y à H:i') }}</span>
                </div>

                <div class="mb-16">
                    <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">Statut</label>
                    <select name="status" class="form-select border-neutral-40 text-14">
                        <option value="draft"     {{ old('status', $blog->status) === 'draft'     ? 'selected' : '' }}>Brouillon</option>
                        <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Publié</option>
                        <option value="archived"  {{ old('status', $blog->status) === 'archived'  ? 'selected' : '' }}>Archivé</option>
                    </select>
                </div>

                <div class="mb-16">
                    <label class="fw-medium text-14 text-neutral-500 mb-8 d-block">Auteur</label>
                    <select name="author_id" class="form-select border-neutral-40 text-14">
                        @foreach($authors as $author)
                        <option value="{{ $author->id }}"
                            {{ old('author_id', $blog->author_id) == $author->id ? 'selected' : '' }}>
                            {{ $author->display_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-8 mt-20">
                    <a href="{{ route('admin.blogs') }}"
                       class="btn border border-neutral-40 text-14 text-neutral-500 hover-bg-neutral-20 rounded-pill px-20 py-9 flex-grow-1 text-center">
                        Annuler
                    </a>
                    <button type="submit"
                            class="btn bg-main-600 text-white rounded-pill text-14 px-20 py-9 flex-grow-1">
                        Enregistrer
                    </button>
                </div>
            </div>

            {{-- Cover image --}}
            <div class="bg-white rounded-10 px-24 py-24 mb-4">
                <h6 class="fw-medium text-16 text-neutral-500 mb-16">Image de couverture</h6>

                @if($blog->cover_image)
                <div class="mb-12" id="coverPreviewWrap">
                    <img id="coverPreview"
                         src="{{ asset('storage/' . $blog->cover_image) }}"
                         alt="" class="rounded-10 w-100" style="max-height:200px;object-fit:cover">
                    <div class="d-flex align-items-center gap-8 mt-8">
                        <input type="checkbox" name="remove_cover" id="removeCover" value="1" class="form-check-input">
                        <label for="removeCover" class="text-13 text-danger">Supprimer l'image</label>
                    </div>
                </div>
                @else
                <div id="coverPreviewWrap" class="mb-12 d-none">
                    <img id="coverPreview" src="" alt="" class="rounded-10 w-100" style="max-height:200px;object-fit:cover">
                </div>
                @endif

                <label for="coverImageInput"
                       class="d-flex flex-column align-items-center justify-content-center border border-dashed border-neutral-40 rounded-10 py-20 px-16 cursor-pointer hover-border-main-600 transition-03">
                    <i class="ph ph-upload-simple text-30 text-neutral-300 mb-8"></i>
                    <span class="text-14 text-neutral-400">
                        {{ $blog->cover_image ? 'Remplacer l'image' : 'Choisir une image' }}
                    </span>
                    <input type="file" id="coverImageInput" name="cover_image" accept="image/*" class="d-none">
                </label>
                @error('cover_image')
                    <div class="text-danger text-13 mt-4">{{ $message }}</div>
                @enderror
            </div>

            {{-- Danger zone --}}
            <div class="bg-white rounded-10 px-24 py-24 border border-danger-200">
                <h6 class="fw-medium text-16 text-danger mb-16">Zone de danger</h6>
                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                      onsubmit="return confirm('Supprimer définitivement cet article ?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="btn border border-danger text-danger hover-bg-danger hover-text-white rounded-pill text-14 w-100 py-9">
                        <i class="ph ph-trash me-4"></i> Supprimer cet article
                    </button>
                </form>
            </div>

        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
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