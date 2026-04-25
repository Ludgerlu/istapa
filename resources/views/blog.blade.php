@extends('layouts.app')

@section('title', 'ISTAPA - Blog')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Blog</h1>
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
                            <span class="text-main-two-600">Blog</span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ================================ Blog Page Section Start =================================== -->
<div class="blog-page-section py-120">
    <div class="container">
        <div class="flex-between gap-16 flex-wrap mb-40">
            <div class="flex-align gap-16">
                <div class="flex-align gap-8">
                    <span class="text-neutral-500 flex-shrink-0">Trier par :</span>
                    <select class="form-select ps-20 pe-28 py-8 fw-medium rounded-pill bg-main-25 border border-neutral-30 text-neutral-700">
                        <option value="1">Les plus récents</option>
                        <option value="1">Tendances</option>
                        <option value="1">Populaires</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            @foreach($blogs as $blog)
            <div class="col-lg-4 col-sm-6">
                <div class="scale-hover-item bg-main-25 rounded-16 p-12 h-100 border border-neutral-30">
                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                        <a href="{{ route('blog.details', $blog['id']) }}" class="w-100 h-100">
                            <img src="{{ asset($blog['cover_image']) }}" alt="Course Image" class="scale-hover-item__img rounded-12 cover-img transition-2">
                        </a>
                        <div class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-three-600 text-white fw-medium">
                            <h3 class="mb-0 text-white fw-medium">{{ $blog['created_at'] }}</h3>
                            {{ $blog['month'] }}
                        </div>
                    </div>
                    <div class="pt-32 pb-24 px-16 position-relative">
                        <h4 class="mb-28">
                            <a href="{{ route('blog.details', $blog['id']) }}" class="link text-line-2">{{ $blog['title_fr'] }}</a>
                        </h4>
                        <div class="flex-align gap-14 flex-wrap my-20">
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-user-circle"></i></span>
                                <span class="text-neutral-500 text-lg">Par Admin</span>
                            </div>
                            <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph-bold ph-eye"></i></span>
                                <span class="text-neutral-500 text-lg">{{ $blog['view_count'] }}</span>
                            </div>
                            <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-chat-dots"></i></span>
                                <span class="text-neutral-500 text-lg">{{ $blog['comments']->count() }}</span>
                            </div>
                        </div>
                        <div class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                            <a href="{{ route('blog.details', $blog['id']) }}" class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold">
                                Lire la Suite
                                <i class="ph ph-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>                            
            </div>
            @endforeach
        </div>

        <ul class="pagination mt-40 flex-align gap-12 flex-wrap justify-content-center">
            {{ $blogs->links() }}
            <li class="page-item"><a class="page-link text-neutral-700 fw-semibold w-40 h-40 bg-main-25 rounded-circle hover-bg-main-600 border-neutral-30 hover-border-main-600 hover-text-white flex-center p-0" href="#"><i class="ph-bold ph-caret-left"></i></a></li>
            <li class="page-item"><a class="page-link text-neutral-700 fw-semibold w-40 h-40 bg-main-25 rounded-circle hover-bg-main-600 border-neutral-30 hover-border-main-600 hover-text-white flex-center p-0" href="#">1</a></li>
            <li class="page-item"><a class="page-link text-neutral-700 fw-semibold w-40 h-40 bg-main-25 rounded-circle hover-bg-main-600 border-neutral-30 hover-border-main-600 hover-text-white flex-center p-0" href="#">2</a></li>
            <li class="page-item"><a class="page-link text-neutral-700 fw-semibold w-40 h-40 bg-main-25 rounded-circle hover-bg-main-600 border-neutral-30 hover-border-main-600 hover-text-white flex-center p-0" href="#">3</a></li>
            <li class="page-item"><a class="page-link text-neutral-700 fw-semibold w-40 h-40 bg-main-25 rounded-circle hover-bg-main-600 border-neutral-30 hover-border-main-600 hover-text-white flex-center p-0" href="#"><i class="ph-bold ph-caret-right"></i></a></li>
        </ul>
    </div>
</div>
<!-- ================================ Blog Page Section End =================================== -->
@endsection