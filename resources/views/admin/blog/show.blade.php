{{-- resources/views/blog/show.blade.php  (public blog detail page) --}}
@extends('layouts.admin')

@section('title', $blog->title . ' — Blog ISTAP')

@section('content')

{{-- ─── Hero ──────────────────────────────────────────────────────────── --}}
<section class="py-56 bg-main-25 border-bottom border-neutral-40">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                {{-- Category breadcrumb --}}
                <nav class="mb-16" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-main-600 text-14">Accueil</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('blog') }}" class="text-main-600 text-14">Blog</a>
                        </li>
                        <li class="breadcrumb-item active text-14 text-neutral-400">{{ Str::limit($blog->title, 40) }}</li>
                    </ol>
                </nav>

                <h1 class="fw-bold text-neutral-700 text-36 lh-sm mb-20">{{ $blog->title }}</h1>

                <div class="d-flex align-items-center gap-20 flex-wrap">
                    {{-- Author --}}
                    <div class="d-flex align-items-center gap-10">
                        <div class="w-36 h-36 bg-main-600 rounded-circle d-flex align-items-center justify-content-center text-white text-12 fw-bold flex-shrink-0">
                            {{ strtoupper(substr($blog->author->display_name ?? 'A', 0, 2)) }}
                        </div>
                        <span class="text-14 fw-medium text-neutral-500">
                            {{ $blog->author->display_name ?? 'Auteur inconnu' }}
                        </span>
                    </div>

                    <span class="w-1 h-20 bg-neutral-40"></span>

                    {{-- Date --}}
                    <span class="text-14 text-neutral-400 d-flex align-items-center gap-6">
                        <i class="ph ph-calendar-blank"></i>
                        {{ $blog->created_at }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Content area ──────────────────────────────────────────────────────── --}}
<section class="py-56">
    <div class="container">
        <div class="row justify-content-center gy-40">

            {{-- Main article --}}
            <div class="col-xl-8">

                {{-- Cover image --}}
                @if($blog->cover_image)
                <div class="mb-40 rounded-16 overflow-hidden">
                    <img src="{{ asset('storage/public/app/' . $blog->cover_image) }}"
                         alt="{{ $blog->title }}"
                         class="w-100" style="max-height:480px;object-fit:cover">
                </div>
                @endif

                {{-- Article body --}}
                <div class="blog-content text-neutral-600 fw-normal text-16 lh-lg">
                    {!! nl2br(e($blog->content)) !!}
                </div>

                {{-- Author box --}}
                <div class="border border-neutral-40 rounded-16 px-24 py-24 mt-48 d-flex gap-20 align-items-start">
                    <div class="w-64 h-64 bg-main-600 rounded-circle d-flex align-items-center justify-content-center text-white text-20 fw-bold flex-shrink-0">
                        {{ strtoupper(substr($blog->author->display_name ?? 'A', 0, 2)) }}
                    </div>
                    <div>
                        <h6 class="fw-semibold text-neutral-600 mb-4">
                            {{ $blog->author->display_name ?? 'Auteur inconnu' }}
                        </h6>
                        <span class="text-13 text-main-600 mb-8 d-block">{{ ucfirst($blog->author->type ?? '') }}</span>
                        @php $bio = $blog->author?->getMeta('description'); @endphp
                        @if($bio)
                            <p class="text-14 text-neutral-500 mb-0">{{ $bio }}</p>
                        @endif
                    </div>
                </div>

                {{-- Navigation between posts --}}
                <div class="row mt-48">
                    <div class="col-6">
                        @if($previous)
                        <a href="{{ route('blog.details', $previous->id) }}"
                           class="d-flex align-items-center gap-12 hover-text-main-600 transition-03">
                            <i class="ph ph-arrow-left text-20"></i>
                            <div>
                                <span class="text-12 text-neutral-400 d-block mb-4">Article précédent</span>
                                <span class="text-14 fw-medium text-neutral-500">{{ Str::limit($previous->title, 45) }}</span>
                            </div>
                        </a>
                        @endif
                    </div>
                    <div class="col-6 text-end">
                        @if($next)
                        <a href="{{ route('blog.details', $next->id) }}"
                           class="d-flex align-items-center gap-12 justify-content-end hover-text-main-600 transition-03">
                            <div>
                                <span class="text-12 text-neutral-400 d-block mb-4">Article suivant</span>
                                <span class="text-14 fw-medium text-neutral-500">{{ Str::limit($next->title, 45) }}</span>
                            </div>
                            <i class="ph ph-arrow-right text-20"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-xl-4">

                {{-- Recent posts --}}
                <div class="bg-main-25 rounded-16 px-24 py-24 mb-24">
                    <h6 class="fw-semibold text-16 text-neutral-600 mb-20">Articles récents</h6>
                    <div class="d-flex flex-column gap-16">
                        @foreach($recentPosts as $post)
                        <a href="{{ route('blog.details', $post->id) }}"
                           class="d-flex align-items-start gap-12 hover-text-main-600 transition-03">
                            @if($post->cover_image)
                            <img src="{{ asset('storage/' . $post->cover_image) }}" alt=""
                                 class="rounded-8 flex-shrink-0" style="width:64px;height:48px;object-fit:cover">
                            @else
                            <div class="rounded-8 bg-neutral-40 flex-shrink-0 d-flex align-items-center justify-content-center"
                                 style="width:64px;height:48px">
                                <i class="ph ph-article text-neutral-400 text-20"></i>
                            </div>
                            @endif
                            <div>
                                <span class="text-14 fw-medium text-neutral-600 d-block lh-sm mb-4">
                                    {{ Str::limit($post->title, 50) }}
                                </span>
                                <span class="text-12 text-neutral-400">
                                    {{ $post->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Upcoming events --}}
                <div class="bg-main-25 rounded-16 px-24 py-24">
                    <h6 class="fw-semibold text-16 text-neutral-600 mb-20">Prochains événements</h6>
                    <div class="d-flex flex-column gap-16">
                        @forelse($upcomingEvents as $event)
                        <a href="{{ route('event.details', $event->event_id) }}"
                           class="d-flex align-items-start gap-12 hover-text-main-600 transition-03">
                            <div class="rounded-10 bg-main-600 text-white text-center px-12 py-8 flex-shrink-0" style="min-width:50px">
                                <span class="text-20 fw-bold d-block lh-1">
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d') }}
                                </span>
                                <span class="text-11">
                                    {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('M') }}
                                </span>
                            </div>
                            <div>
                                <span class="text-14 fw-medium text-neutral-600 d-block">
                                    {{ Str::limit($event->event_title, 45) }}
                                </span>
                                <span class="text-12 text-neutral-400">
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                </span>
                            </div>
                        </a>
                        @empty
                        <p class="text-14 text-neutral-400 mb-0">Aucun événement à venir.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection