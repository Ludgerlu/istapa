@extends('layouts.admin')

@section('title', $blog->title)

@section('content')
<div class="mb-24">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-12">
        <h4 class="fw-semibold text-neutral-500 text-20 mb-0">{{ $blog->title }}</h4>
        <div class="d-flex gap-8">
            <a href="{{ route('manager.blogs.edit', $blog) }}" class="btn btn-sm bg-main-600 text-white rounded-pill px-20">
                <i class="ph ph-pencil"></i> Modifier
            </a>
            <form action="{{ route('manager.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm bg-danger-600 text-white rounded-pill px-20">
                    <i class="ph ph-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Blog Post Card --}}
<div class="bg-white rounded-10 p-24 mb-32">
    <div class="row">
        @if($blog->cover_image)
            <div class="col-md-4 mb-3 mb-md-0">
                <img src="{{ asset('storage/' . $blog->cover_image) }}" class="img-fluid rounded-10" alt="">
            </div>
            <div class="col-md-8">
        @else
            <div class="col-12">
        @endif
                <div class="d-flex gap-12 flex-wrap align-items-center mb-16">
                    <span class="badge {{ $blog->status === 'published' ? 'bg-success-100 text-success-600' : ($blog->status === 'draft' ? 'bg-warning-100 text-warning-600' : 'bg-neutral-100 text-neutral-500') }}">
                        {{ ucfirst($blog->status) }}
                    </span>
                    <span class="text-13 text-neutral-400">{{ $blog->published_at?->format('d/m/Y H:i') ?? 'Non publié' }}</span>
                    <span class="text-13 text-neutral-400">Auteur : {{ $blog->author->name ?? 'Inconnu' }}</span>
                </div>
                <div class="content text-neutral-600">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </div>
    </div>
</div>

{{-- Comments Section --}}
<div class="bg-white rounded-10 p-24">
    <div class="d-flex align-items-center justify-content-between mb-20">
        <h5 class="fw-semibold text-16 mb-0">Commentaires ({{ $blog->comments()->count() }})</h5>
        <span class="text-12 text-neutral-400">Modération : seuls les commentaires approuvés sont visibles en front</span>
    </div>

    @if($comments->isEmpty())
        <div class="text-center py-40 text-neutral-400">
            <i class="ph ph-chats text-40 d-block mb-8"></i>
            Aucun commentaire pour cet article.
        </div>
    @else
        <div class="comments-list">
            @foreach($comments as $comment)
                @include('manager.blog.partials.comment-item', ['comment' => $comment, 'depth' => 0])
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.comment-reply {
    margin-left: 48px;
    border-left: 2px solid #e2e8f0;
    padding-left: 20px;
}
@media (max-width: 768px) {
    .comment-reply { margin-left: 20px; padding-left: 12px; }
}
</style>
@endpush