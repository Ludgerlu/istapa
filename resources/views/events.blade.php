@extends('layouts.app')

@section('title', 'ISTAPA - Events')

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
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Events</h1>
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
                            <span class="text-main-two-600">Events</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ============================== Events Section Start ============================== -->
<section class="course-list-view py-120 bg-white">
    <div class="container">
        <div class="flex-between gap-16 flex-wrap mb-40">
            <span class="text-neutral-500">Showing {{ $events->firstItem() }}–{{ $events->lastItem() }} of {{ $events->total() }} Results</span>
            <!-- Optional sorting (implement if needed) -->
        </div>

        @if($events->count())
            <div class="row gy-4">
                @foreach($events as $event)
                    <div class="col-xl-4 col-sm-6">
                        <div class="scale-hover-item bg-main-25 rounded-16 p-12 h-100 border border-neutral-30">
                            <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                                <a href="{{ route('event.details', $event->id) }}" class="w-100 h-100">
                                    <img src="{{ $event->cover_image ? asset('storage/' . $event->cover_image) : asset('assets/images/thumbs/event-placeholder.png') }}"
                                         alt="{{ $event->title }}"
                                         class="scale-hover-item__img rounded-12 cover-img transition-2">
                                </a>
                                <!-- Date box (day + month) -->
                                <div class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-two-600 text-white fw-medium text-center">
                                    <h3 class="mb-0 text-white fw-medium">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</h3>
                                    <span class="text-sm">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</span>
                                </div>
                                <!-- Start time badge -->
                                <div class="bg-success-600 rounded-8 px-24 py-12 text-white position-absolute inset-block-start-0 inset-inline-start-0 mt-20 ms-20 z-1">
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                </div>
                            </div>
                            <div class="pt-32 pb-24 px-16 position-relative">
                                <h4 class="mb-28">
                                    <a href="{{ route('event.details', $event->id) }}" class="link text-line-2">
                                        {{ $event->title }}
                                    </a>
                                </h4>
                                <div class="flex-align gap-8">
                                    <span class="text-neutral-500 text-2xl d-flex"><i class="ph-bold ph-map-pin-line"></i></span>
                                    <p class="text-neutral-500 text-lg">{{ $event->location ?: 'Online Event' }}</p>
                                </div>
                                <div class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28">
                                    <!-- Price: if not available, set a default or hide -->
                                    <h4 class="text-main-two-600 mb-0">Free</h4>
                                    <a href="{{ route('event.details', $event->id) }}" class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold">
                                        Join Now
                                        <i class="ph ph-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-40">
                {{ $events->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <p class="text-neutral-500">No upcoming events found.</p>
            </div>
        @endif
    </div>
</section>
<!-- ============================== Events Section End ============================== -->

<!-- Optional Certificate Section (keep as is or remove) -->
@endsection