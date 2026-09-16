@extends('layouts.app')

@section('title', 'ISTAPA - Gallery')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <img src="assets/images/shapes/shape1.png" alt="" class="shape one animation-rotation d-md-block d-none">
    <img src="assets/images/shapes/shape2.png" alt="" class="shape two animation-scalation d-md-block d-none">
    <img src="assets/images/shapes/shape3.png" alt="" class="shape eight animation-walking d-md-block d-none">
    <img src="assets/images/shapes/shape5.png" alt="" class="shape six animation-walking d-md-block d-none">
    <img src="assets/images/shapes/shape4.png" alt="" class="shape four animation-scalation">
    <img src="assets/images/shapes/shape4.png" alt="" class="shape nine animation-scalation">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Gallery</h1>
                    <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                        <li class="breadcrumb__item">
                            <a href="{{ url('/') }}" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                <i class="text-lg d-inline-flex ph-bold ph-house"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <span class="text-main-two-600">Gallery</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- =============================== Gallery Section Start ================================== -->
<section class="gallery py-120">
    <div class="container">
        <div class="section-heading text-center">
            <div class="flex-align d-inline-flex gap-8 mb-16">
                <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                <h5 class="text-main-600 mb-0">Gallery</h5>
            </div>
            <h2 class="mb-24">Explore Our Gallery</h2>
            <p class="">Browse through our collection of memories and events</p>
        </div>

        @if($albums->count())
            <div class="text-center">
                <div class="nav-tab-wrapper bg-white border border-neutral-40 p-16 mb-40 d-inline-block" data-aos="zoom-out">
                    <ul class="nav nav-pills common-tab gap-16" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8 active"
                                    id="pills-all-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-all"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-all"
                                    aria-selected="true">
                                <i class="text-xl d-flex text-main-600 ph-bold ph-squares-four"></i>
                                Tout
                            </button>
                        </li>
                        @foreach($albums as $index => $album)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill bg-main-25 text-md fw-medium text-neutral-500 flex-center w-100 gap-8"
                                        id="pills-{{ $album->slug }}-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#pills-{{ $album->slug }}"
                                        type="button"
                                        role="tab"
                                        aria-controls="pills-{{ $album->slug }}"
                                        aria-selected="false">
                                    <i class="text-xl d-flex text-main-600 ph-bold ph-squares-four"></i>
                                    {{ app()->getLocale() == 'fr' ? ($album->title_fr ?: $album->title_en) : $album->title_en }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="pills-tabContent">
                {{-- Panel for "All" – shows every image from every album --}}
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab" tabindex="0">
                    @if($albums->flatMap->images->count())
                        <div class="masonry">
                            @foreach($albums as $album)
                                @foreach($album->images as $image)
                                    <div class="masonry__item position-relative rounded-12 overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="{{ $image->caption ?? 'Gallery image' }}"
                                            class="cover-img">
                                        <a href="{{ asset('storage/' . $image->image_path) }}"
                                            class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0"
                                            data-fancybox="gallery-all">
                                            <i class="ph ph-magnifying-glass-plus"></i>
                                        </a>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-neutral-500">No images available.</p>
                        </div>
                    @endif
                </div>

                {{-- Panels for each album --}}
                @foreach($albums as $index => $album)
                    <div class="tab-pane fade"
                        id="pills-{{ $album->slug }}"
                        role="tabpanel"
                        aria-labelledby="pills-{{ $album->slug }}-tab"
                        tabindex="0">
                        @if($album->images->count())
                            <div class="masonry">
                                @foreach($album->images as $image)
                                    <div class="masonry__item position-relative rounded-12 overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="{{ $image->caption ?? 'Gallery image' }}"
                                            class="cover-img">
                                        <a href="{{ asset('storage/' . $image->image_path) }}"
                                        class="masonry__image position-absolute start-50 top-50 translate-middle z-1 text-white w-100 h-100 d-flex justify-content-center align-items-center rounded-12 hidden opacity-0"
                                        data-fancybox="gallery-{{ $album->slug }}">
                                            <i class="ph ph-magnifying-glass-plus"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <p class="text-neutral-500">No images available in this album.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <p class="text-neutral-500">No gallery albums found.</p>
            </div>
        @endif
    </div>
</section>
<!-- =============================== Gallery Section End ================================== -->
@endsection