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
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

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
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

    <!-- Zone d'upload -->
    <div class="upload-card">
        <h3 class="section-title">
            <i class="fas fa-cloud-upload-alt"></i>
            Ajouter des photos
        </h3>
        
        <div id="dropzone" class="dropzone">
            <div class="dropzone-message">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Glissez-déposez vos photos ici ou cliquez pour parcourir</p>
                <span class="file-info">JPG, PNG, GIF, WEBP • Max 5MB par photo</span>
            </div>
            <input type="file" id="fileInput" multiple accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" style="display: none;">
        </div>

        <div id="uploadProgress" class="upload-progress" style="display: none;">
            <div class="progress-bar">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
            <p class="progress-text">Upload en cours...</p>
        </div>
    </div>

    <!-- Galerie des photos existantes -->
    <div class="photos-section">
        <h3 class="section-title">
            <i class="fas fa-images"></i>
            Photos de l'album ({{ $album->images->count() }})
        </h3>

        @if($album->images->count() > 0)
            <div class="photos-grid" id="photosGrid">
                @foreach($album->images->sortBy('sort_order') as $image)
                    <div class="photo-item" data-photo-id="{{ $image->id }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption }}">
                        <div class="photo-overlay">
                            @if($album->cover_image != $image->image_path)
                                <button class="btn-icon btn-cover" onclick="setCover({{ $album->id }}, {{ $image->id }})" title="Définir comme couverture">
                                    <i class="fas fa-star"></i>
                                </button>
                            @else
                                <span class="cover-badge" title="Photo de couverture">
                                    <i class="fas fa-star"></i>
                                </span>
                            @endif
                            <button class="btn-icon btn-delete" onclick="deletePhoto({{ $image->id }})" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <p class="drag-hint"><i class="fas fa-arrows-alt"></i> Glissez-déposez les photos pour les réorganiser</p>
        @else
            <div class="empty-state">
                <i class="fas fa-images"></i>
                <p>Aucune photo dans cet album</p>
                <p class="text-muted">Utilisez la zone d'upload ci-dessus pour ajouter des photos</p>
            </div>
        @endif
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
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const albumId = {{ $album->id }};

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

// Drag & Drop upload
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('fileInput');
const uploadProgress = document.getElementById('uploadProgress');
const progressFill = document.querySelector('.progress-fill');
const progressText = document.querySelector('.progress-text');

dropzone.addEventListener('click', () => fileInput.click());
dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('dragover'); });
dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
});
fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

function handleFiles(files) {
    const validFiles = Array.from(files).filter(file => {
        if (!file.type.match(/^image\/(jpeg|jpg|png|gif|webp)$/)) {
            alert(`${file.name} n'est pas un format d'image valide`);
            return false;
        }
        if (file.size > 5 * 1024 * 1024) {
            alert(`${file.name} dépasse la taille maximale de 5MB`);
            return false;
        }
        return true;
    });
    if (validFiles.length > 0) uploadFiles(validFiles);
}

function uploadFiles(files) {
    const formData = new FormData();
    files.forEach(file => formData.append('images[]', file));
    uploadProgress.style.display = 'block';
    progressFill.style.width = '0%';
    progressText.textContent = `Upload de ${files.length} photo(s) en cours...`;
    
    fetch(`{{ route('manager.gallery.upload', $album->id) }}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            progressFill.style.width = '100%';
            progressText.textContent = data.message;
            setTimeout(() => location.reload(), 1000);
        } else {
            throw new Error(data.message || 'Erreur');
        }
    })
    .catch(error => {
        console.error('Upload error:', error);
        alert('Erreur : ' + error.message);
        uploadProgress.style.display = 'none';
    });
}

function deletePhoto(photoId) {
    if (!confirm('Supprimer cette photo ?')) return;
    fetch(`{{ url('admin/gallery/image') }}/${photoId}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) location.reload();
        else alert('Erreur lors de la suppression');
    })
    .catch(error => alert('Erreur : ' + error.message));
}

function setCover(albumId, photoId) {
    fetch(`{{ url('admin/gallery') }}/${albumId}/cover/${photoId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) location.reload();
        else alert('Erreur lors de la mise à jour');
    });
}

// Sortable reorder
const photosGrid = document.getElementById('photosGrid');
if (photosGrid) {
    new Sortable(photosGrid, {
        animation: 200,
        onEnd: function() {
            let order = [];
            document.querySelectorAll('.photo-item').forEach(item => order.push(item.dataset.photoId));
            fetch(`{{ route('manager.gallery.reorder', $album->id) }}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
                body: JSON.stringify({ order: order })
            });
        }
    });
}
</script>
@endsection