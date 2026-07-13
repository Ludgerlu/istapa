@extends('layouts.app')

@section('title', $post->title_fr . ' - ISTAPA')

@section('content')
<!-- Breadcrumb same as before, but dynamic title -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">{{ $post->title_fr }}</h1>
                    <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                        <li class="breadcrumb__item">
                            <a href="{{ route('home') }}" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium"> 
                                <i class="text-lg d-inline-flex ph-bold ph-house"></i> Accueil
                            </a>
                        </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item"> 
                            <span class="text-main-two-600">{{ $post->title_fr }}</span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Details Section -->
<div class="blog-page-section py-120">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="bg-main-25 rounded-16 p-12 border border-neutral-30">
                    <div class="rounded-12 overflow-hidden position-relative">
                        @if($post->cover_image)
                            <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title_fr }}" class="rounded-12 cover-img transition-2">
                        @else
                            <div class="article-cover-placeholder">
                                <i class="fas fa-image fa-3x"></i>
                            </div>
                        @endif
                        
                        <div class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-two-600 text-white fw-medium">
                            <h3 class="mb-0 text-white fw-medium">{{ $post->published_at ? $post->published_at->format('d') : '' }}</h3>
                            {{ $post->published_at ? strtoupper($post->published_at->format('M')) : '' }}
                        </div>
                    </div>
                    <div class="pt-32 pb-24 px-16 position-relative">
                        <div class="flex-align gap-14 flex-wrap mb-20">
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-user-circle"></i></span>
                                <span class="text-neutral-500 text-lg">Par {{ $post->author->full_name ?? $post->author->email }}</span>
                            </div>
                            <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph-bold ph-eye"></i></span>
                                <span class="text-neutral-500 text-lg">{{ $post->view_count }}</span>
                            </div>
                            <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-chat-dots"></i></span>
                                <span class="text-neutral-500 text-lg">{{ $post->comments->where('is_approved', true)->count() }}</span>
                            </div>
                        </div>
                        <h2 class="mb-24">{{ $post->title_fr }}</h2>
                        <div class="text-neutral-500 mb-32">
                            {!! nl2br(e($post->content_fr)) !!}
                        </div>
                        <!-- Any additional fields like excerpt can be shown -->
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="col-lg-12">
                <div class="border border-neutral-30 rounded-12 bg-main-25 p-32 mt-24">
                    <h5 class="mb-0">Commentaires ({{ $comments->count() }})</h5>
                    <span class="d-block border border-neutral-30 my-32 border-dashed"></span>
                     <div class="row">
                         @forelse($comments as $comment)
                            <div class="col-md-6">
                                <div class="border border-neutral-30 rounded-12 bg-white p-32 mb-24 me-3">
                                    <div class="w-90 h-90 rounded-circle position-relative mb-4">
                                        <!-- <img src="{{ $comment->user->avatar ?? asset('assets/images/thumbs/default-avatar.png') }}" alt="" class="w-60 h-60 rounded-circle cover-img"> -->
                                        @if($comment->user->avatar)
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="{{ $comment->user->last_name }}" class="cover-img rounded-circle" />
                                        @else
                                            <div class="cover-img rounded-circle bg-main-300 flex-center text-white" style="font-size: 32px; font-weight: 600;">
                                                {{ strtoupper(substr($comment->user->last_name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <h6 class="text-xl mb-8 fw-medium">{{ $comment->user->full_name ?? $comment->user->email }}</h6>
                                    <span class="text-neutral-700 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                                    <p class="text-neutral-700">{{ $comment->content }}</p>
                                    <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                                </div>
                            </div>
                         @empty
                             <p class="text-neutral-500">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
                         @endforelse
                     </div>

                    @auth
                    <!-- Comment Form -->
                    <div class="mt-40">
                        <form action="{{ route('blog.comment.store', $post->id) }}" method="POST" id="commentForm">
                            @csrf
                            <h5 class="mb-0">Laisser un commentaire</h5>
                            <span class="d-block border border-neutral-30 my-32 border-dashed"></span>
                            <div class="mb-24">
                                <label for="content" class="text-neutral-700 text-lg fw-medium mb-12">Votre commentaire</label>
                                <textarea id="content" name="content" class="common-input rounded-24" placeholder="Écrivez votre commentaire..." rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-main rounded-pill flex-center gap-8">
                                Publier le commentaire
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="mt-40 text-center">
                        <p class="text-neutral-500">Vous devez être <a href="{{ route('login') }}">connecté</a> pour commenter.</p>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Related Posts -->
            <div class="col-lg-12">
                <div class="border border-neutral-30 rounded-12 bg-main-25 p-32 bg-main-25">
                    <h4 class="mb-16">Articles similaires</h4> 
                    <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                    
                    @forelse($relatedPosts as $related)
                    <div class="flex-align gap-16 mb-24">
                        <a href="{{ route('blog.details', $related->id) }}" class="flex-shrink-0">
                            <div class="bg-main-600 rounded-circle flex-center text-white" style="width: 80px; height: 80px; font-size: 24px; font-weight: 600;">
                                 <!-- {{ strtoupper(substr($related->title, 0, 2)) }} -->
                                 <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                 <!-- <span>Image à venir</span> -->
                             </div>
                        </a>
                        <div class="flex-grow-1">
                            <h6 class="text-xl mb-10">
                                <a href="{{ route('blog.details', $related->id) }}" class="hover-text-main-600 text-line-2">{{ $related->title }}</a>
                            </h6>
                            <span class="text-neutral-500">{{ $related->published_at ? $related->published_at->format('d/m/Y') : '' }}</span>
                        </div>
                    </div>
                    <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                    @empty
                    <p>Aucun article similaire trouvé.</p>
                    @endforelse
                    
                    <a href="{{ route('blog') }}" class="h6 mb-0 text-main-600 fw-semibold hover-text-decoration-underline">
                        Voir tous les articles
                        <i class="ph-bold ph-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

<style>
    .article-cover-placeholder {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, var(--main-100) 0%, var(--neutral-800));
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(8, 2, 2, 0.3);
        font-size: 1.2rem;
    }
    
    .article-cover-placeholder > i {
        color: black ;
    }
</style>
@endpush