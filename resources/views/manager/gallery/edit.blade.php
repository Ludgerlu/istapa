@extends('layouts.admin')

@section('title', 'Modifier l\'album')

@section('content')
<div class="content-header">
    <div class="content-title">
        <i class="fas fa-edit"></i>
        Modifier l'album : {{ $album->title_fr }}
    </div>
    <div class="header-actions">
        <a href="{{ route('manager.gallery.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<div class="content-body">
    <!-- Formulaire d'édition -->
    <div class="form-card">
        <h3 class="section-title">Informations de l'album</h3>
        
        <form action="{{ route('manager.gallery.update', $album->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Onglets pour les langues -->
            <ul class="nav-tabs">
                <li class="nav-item">
                    <button type="button" class="nav-link active" data-lang="fr">
                        <i class="fas fa-flag"></i> Français
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" data-lang="en">
                        <i class="fas fa-flag"></i> English
                    </button>
                </li>
            </ul>

            <div class="lang-content" id="lang-fr">
                <div class="form-group">
                    <label for="title_fr">Titre de l'album (Français) <span class="required">*</span></label>
                    <input type="text" id="title_fr" name="title_fr" class="form-control" 
                           value="{{ old('title_fr', $album->title_fr) }}" required>
                </div>
                <div class="form-group">
                    <label for="description_fr">Description (Français)</label>
                    <textarea id="description_fr" name="description_fr" class="form-control" 
                              rows="4">{{ old('description_fr', $album->description_fr) }}</textarea>
                </div>
            </div>

            <div class="lang-content" id="lang-en" style="display: none;">
                <div class="form-group">
                    <label for="title_en">Album Title (English) <span class="required">*</span></label>
                    <input type="text" id="title_en" name="title_en" class="form-control" 
                           value="{{ old('title_en', $album->title_en) }}" required>
                </div>
                <div class="form-group">
                    <label for="description_en">Description (English)</label>
                    <textarea id="description_en" name="description_en" class="form-control" 
                              rows="4">{{ old('description_en', $album->description_en) }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-main rounded-pill">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

</div>

<style>
.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.content-title {
    font-size: 24px;
    font-weight: 600;
    color: var(--afisa-blue);
}

.content-title i {
    margin-right: 10px;
    color: var(--afisa-green);
}

.btn-primary {
    background: var(--afisa-green);
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary:hover {
    background: #00b347;
    color: white;
}

.btn-secondary {
    background: #e0e6ed;
    color: var(--afisa-blue);
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #d0d6dd;
    color: var(--afisa-blue);
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.form-card, .upload-card, .photos-section {
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--afisa-blue);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e0e6ed;
}

.nav-tabs {
    display: flex;
    gap: 5px;
    margin-bottom: 25px;
    border-bottom: 2px solid #e0e6ed;
    padding-bottom: 10px;
}

.nav-link {
    padding: 8px 20px;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    color: var(--afisa-blue);
    border-radius: 6px;
    transition: all 0.3s ease;
}

.nav-link.active {
    background: var(--afisa-green);
    color: white;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--afisa-blue);
}

.required {
    color: #e74c3c;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 2px solid #e0e6ed;
    border-radius: 6px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: var(--afisa-green);
}

textarea.form-control {
    resize: vertical;
}

.dropzone {
    border: 2px dashed #cbd5e0;
    border-radius: 12px;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8fafc;
}

.dropzone.dragover {
    border-color: var(--afisa-green);
    background: rgba(0, 147, 68, 0.05);
}

.dropzone-message i {
    font-size: 48px;
    color: var(--afisa-green);
    margin-bottom: 15px;
}

.dropzone-message p {
    margin-bottom: 5px;
    color: #666;
}

.file-info {
    font-size: 12px;
    color: #999;
}

.upload-progress {
    margin-top: 20px;
}

.progress-bar {
    height: 8px;
    background: #e0e6ed;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: var(--afisa-green);
    width: 0%;
    transition: width 0.3s ease;
}

.progress-text {
    margin-top: 10px;
    font-size: 13px;
    color: #666;
    text-align: center;
}

.photos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.photo-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    cursor: move;
    transition: transform 0.2s ease;
}

.photo-item:hover {
    transform: scale(1.02);
}

.photo-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.photo-item:hover .photo-overlay {
    opacity: 1;
}

.btn-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    color: #333;
}

.btn-icon:hover {
    background: var(--afisa-green);
    color: white;
    transform: scale(1.1);
}

.cover-badge {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: gold;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.drag-hint {
    margin-top: 15px;
    font-size: 12px;
    color: #999;
    text-align: center;
}

.empty-state {
    text-align: center;
    padding: 40px;
}

.empty-state i {
    font-size: 48px;
    color: #ccc;
    margin-bottom: 15px;
}

.empty-state p {
    color: #999;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="{{ asset('assets/js/image-compression.js') }}"></script>
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;


// Onglets de langue
document.querySelectorAll('.nav-link').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        document.querySelectorAll('.lang-content').forEach(content => content.style.display = 'none');
        const lang = button.getAttribute('data-lang');
        document.getElementById(`lang-${lang}`).style.display = 'block';
    });
});

</script>
@endsection