@extends('layouts.app')

@section('title', $event->title . ' - ISTAPA')

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
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Event Details</h1>
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
                            <a href="{{ route('events') }}" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">Events</a>
                        </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <span class="text-main-two-600">{{ $event->title }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ============================== Event Details Start ============================== -->
<section class="course-list-view py-120 bg-white">
    <div class="container container--lg">
        <!-- Main cover image -->
        @if($event->cover_image)
            <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title_fr }}" class="rounded-12 w-100">
        @else
            <img src="{{ asset('assets/images/thumbs/event-details-img.png') }}" alt="Event image" class="rounded-12 w-100">
        @endif

        <div class="container">
            <div class="mt-60">
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <h1 class="display-4 mb-24 fw-semibold">{{ $event->title_fr }}</h1>
                        <!-- Short description or full content? Using content as main text -->
                        <div class="text-neutral-700">
                            {!! nl2br(e($event->content_fr)) !!} <!-- Use content field; ensure XSS safety with e() then nl2br -->
                        </div>

                        <!-- If there are additional images in EventImage model -->
                        @if($event->images->count())
                            <span class="d-block border-bottom border-top-0 border-dashed border-main-100 my-32"></span>
                            <h3 class="mb-16">Event Gallery</h3>
                            <div class="row gy-4 mb-32">
                                @foreach($event->images as $image)
                                    <div class="col-md-6">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Event image" class="rounded-16 w-100">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="bg-white box-shadow-md rounded-12 p-12 d-flex flex-column gap-12 border border-neutral-30 mt--200px">
                            @if($event->video_url)
                                <div class="rounded-12 overflow-hidden position-relative">
                                    <img src="{{ $event->cover_image ? asset('storage/' . $event->cover_image) : asset('assets/images/thumbs/event-detail-img4.png') }}" class="rounded-12 cover-img w-100" alt="">
                                    <a href="{{ $event->video_url }}" class="play-button position-absolute start-50 top-50 translate-middle z-1 w-72 h-72 flex-center bg-main-600 text-white rounded-circle text-2xl">
                                        <i class="ph-fill ph-play"></i>
                                    </a>
                                    <!-- Price badge (optional) -->
                                    <h3 class="text-white bg-main-two-600 mb-0 px-32 py-16 rounded-top-start-8px position-absolute inset-inline-end-0 inset-block-end-0 fw-medium">Free</h3>
                                </div>
                            @endif
                            <div class="rounded-12 bg-main-25 p-24 ">
                                <div class=" flex-between flex-wrap gap-16 border-bottom border-dashed border-top-0 border-end-0 border-start-0 border-neutral-40 pb-16 mb-16">
                                    <div class="flex-align gap-12">
                                        <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-calendar-dot"></i></span>
                                        <span class="text-neutral-700 text-lg fw-normal">Start Date</span>
                                    </div>
                                    <span class="text-lg fw-medium text-neutral-700">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</span>
                                </div>
                                <div class=" flex-between flex-wrap gap-16 border-bottom border-dashed border-top-0 border-end-0 border-start-0 border-neutral-40 pb-16 mb-16">
                                    <div class="flex-align gap-12">
                                        <span class="text-neutral-700 text-2xl d-flex"> <i class="ph-bold ph-clock"></i></span>
                                        <span class="text-neutral-700 text-lg fw-normal">Start Time</span>
                                    </div>
                                    <span class="text-lg fw-medium text-neutral-700">{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span>
                                </div>
                                <div class=" flex-between flex-wrap gap-16 border-bottom border-dashed border-top-0 border-end-0 border-start-0 border-neutral-40 pb-16 mb-16">
                                    <div class="flex-align gap-12">
                                        <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-calendar-dot"></i></span>
                                        <span class="text-neutral-700 text-lg fw-normal">End Time</span>
                                    </div>
                                    <span class="text-lg fw-medium text-neutral-700">{{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</span>
                                </div>
                                <div class=" flex-between flex-wrap gap-16 border-bottom border-dashed border-top-0 border-end-0 border-start-0 border-neutral-40 pb-16 mb-16">
                                    <div class="flex-align gap-12">
                                        <span class="text-neutral-700 text-2xl d-flex"> <i class="ph-bold ph-clock"></i></span>
                                        <span class="text-neutral-700 text-lg fw-normal">End Date</span>
                                    </div>
                                    <span class="text-lg fw-medium text-neutral-700">{{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}</span>
                                </div>
                                <div class=" flex-between flex-wrap gap-16 border-bottom border-dashed border-top-0 border-end-0 border-start-0 border-neutral-40 pb-16 mb-16">
                                    <div class="flex-align gap-12">
                                        <span class="text-neutral-700 text-2xl d-flex"><i class="ph-bold ph-users-three"></i></span>
                                        <span class="text-neutral-700 text-lg fw-normal">Ongoing</span>
                                    </div>
                                    <span class="text-lg fw-medium text-neutral-700">100</span>
                                </div>
                                <div class=" flex-between flex-wrap gap-16">
                                    <div class="flex-align gap-12">
                                        <span class="text-neutral-700 text-2xl d-flex"> <i class="ph-bold ph-map-pin-line"></i> </span>
                                        <span class="text-neutral-700 text-lg fw-normal">Location</span>
                                    </div>
                                    <span class="text-lg fw-medium text-neutral-700">{{ $event->location ?: 'Online' }}</span>
                                </div>
                            </div>
                            <span class="d-block border-bottom border-top-0 border-dashed border-main-100 my-32"></span>
                            <a href="{{ route('contact') }}" class="btn btn-main rounded-pill flex-center gap-8">
                                Join Now
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </a>
                            <ul class="social-list flex-center gap-8 mt-24">
                                <li class="social-list__item">
                                    <a href="https://www.facebook.com/" class="text-main-600 text-xl hover-text-white w-44 h-44 rounded-circle bg-main-50 hover-bg-main-600 hover-border-main-600 hover-text-white flex-center"><i class="ph-bold ph-facebook-logo"></i></a>
                                </li>
                                <li class="social-list__item">
                                    <a href="https://www.twitter.com/" class="text-main-600 text-xl hover-text-white w-44 h-44 rounded-circle bg-main-50 hover-bg-main-600 hover-border-main-600 hover-text-white flex-center"> <i class="ph-bold ph-twitter-logo"></i></a>
                                </li>
                                <li class="social-list__item">
                                    <a href="https://www.linkedin.com/" class="text-main-600 text-xl hover-text-white w-44 h-44 rounded-circle bg-main-50 hover-bg-main-600 hover-border-main-600 hover-text-white flex-center"><i class="ph-bold ph-instagram-logo"></i></a>
                                </li>
                                <li class="social-list__item">
                                    <a href="https://www.pinterest.com/" class="text-main-600 text-xl hover-text-white w-44 h-44 rounded-circle bg-main-50 hover-bg-main-600 hover-border-main-600 hover-text-white flex-center"><i class="ph-bold ph-pinterest-logo"></i></a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ============================== Event Details End ============================== -->

<!-- Optional Certificate Section (keep as is if needed) -->
@endsection