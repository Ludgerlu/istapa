@extends('layouts.app')
@section('title', $album->title_fr)
@section('content')

<div class="gallery-album-header">
    <h1>{{ $album->title_fr }}</h1>
    @if($album->description_fr)
        <p class="album-description">{{ $album->description_fr }}</p>
    @endif
</div>

@if($album->images->count() > 0)
    <div class="public-photos-grid">
        @foreach($album->images as $index => $image)
            <div class="public-photo-item" onclick="showImage({{ $index }})">
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption }}" loading="lazy">
            </div>
        @endforeach
    </div>
@else
    <p class="text-muted">Aucune photo dans cet album pour le moment.</p>
@endif

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <span class="lightbox-prev" onclick="event.stopPropagation(); changeImage(-1)">&#10094;</span>
    <img id="lightbox-img" class="lightbox-content" src="" alt="">
    <span class="lightbox-next" onclick="event.stopPropagation(); changeImage(1)">&#10095;</span>
    <div id="lightbox-caption" class="lightbox-caption"></div>
</div>

<style>
.public-photos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
}
.public-photo-item {
    cursor: pointer;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.public-photo-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    transition: transform 0.25s ease;
}
.public-photo-item:hover img {
    transform: scale(1.05);
}
.lightbox {
    display: none;
    position: fixed;
    z-index: 1000;
    inset: 0;
    background: rgba(0,0,0,0.92);
    text-align: center;
}
.lightbox.active { display: flex; align-items: center; justify-content: center; flex-direction: column; }
.lightbox-content {
    max-width: 90%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 4px;
}
.lightbox-close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    cursor: pointer;
}
.lightbox-prev, .lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: #fff;
    font-size: 30px;
    cursor: pointer;
    padding: 10px 16px;
    user-select: none;
}
.lightbox-prev { left: 10px; }
.lightbox-next { right: 10px; }
.lightbox-caption {
    color: #ddd;
    margin-top: 12px;
    font-size: 14px;
}
</style>

<script>
const galleryImages = @json($album->images->map(function ($img) {
    return [
        'src' => asset('storage/' . $img->image_path),
        'caption' => $img->caption,
    ];
}));
let currentImageIndex = 0;

function showImage(index) {
    currentImageIndex = index;
    const lightbox = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    const caption = document.getElementById('lightbox-caption');

    img.src = galleryImages[index].src;
    caption.textContent = galleryImages[index].caption || '';
    lightbox.classList.add('active');
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
}

function changeImage(direction) {
    currentImageIndex = (currentImageIndex + direction + galleryImages.length) % galleryImages.length;
    showImage(currentImageIndex);
}

document.addEventListener('keydown', (e) => {
    if (!document.getElementById('lightbox').classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') changeImage(-1);
    if (e.key === 'ArrowRight') changeImage(1);
});
</script>

@endsection