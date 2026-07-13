@extends('layouts.app')

@section('title', $program->title . ' - ISTAPA')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <img src="{{ asset('assets/images/shapes/shape1.png') }}" alt="" class="shape one animation-rotation d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape two animation-scalation d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape3.png') }}" alt="" class="shape eight animation-walking d-md-block d-none">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper text-center">
                    <h1 class="breadcrumb__title display-4 fw-semibold">{{ $program->title }}</h1>
                    <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                        <li class="breadcrumb__item">
                            <a href="{{ route('home') }}" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium"> 
                                <i class="text-lg d-inline-flex ph-bold ph-house"></i> 
                                {{ app()->getLocale() === 'fr' ? 'Accueil' : 'Home' }}
                            </a>
                        </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <a href="{{ route('courses') }}" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium">
                                {{ app()->getLocale() === 'fr' ? 'Programmes' : 'Programs' }}
                            </a>
                        </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <span class="text-main-two-600">{{ $program->title }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ==================== Program Details Start Here ==================== -->
<section class="program-details py-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-right">
                <!-- Program Cover Image -->
                @if($program->cover_image)
                <div class="program-cover mb-40">
                    <img src="{{ asset('storage/' . $program->cover_image) }}" alt="{{ $program->title }}" class="w-100 rounded-16">
                </div>
                @endif
                
                <!-- Program Content -->
                <div class="program-content">
                    {!! $program->content !!}
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="program-sidebar">
                    <!-- Quick Info Card -->
                    <div class="sidebar-card bg-main-25 rounded-16 p-24 mb-32">
                        <h4 class="mb-24 pb-16 border-bottom border-neutral-30">
                            {{ app()->getLocale() === 'fr' ? 'Informations clés' : 'Key information' }}
                        </h4>
                        <div class="info-list">
                            <div class="info-item flex-between mb-20">
                                <span class="text-neutral-500">{{ app()->getLocale() === 'fr' ? 'Durée' : 'Duration' }}</span>
                                <span class="fw-semibold">{{ $program->duration_months ?? 24 }} {{ app()->getLocale() === 'fr' ? 'mois' : 'months' }}</span>
                            </div>
                            <div class="info-item flex-between mb-20">
                                <span class="text-neutral-500">{{ app()->getLocale() === 'fr' ? 'Diplôme' : 'Degree' }}</span>
                                <span class="fw-semibold">BTS / HND</span>
                            </div>
                            <div class="info-item flex-between mb-20">
                                <span class="text-neutral-500">{{ app()->getLocale() === 'fr' ? 'Rythme' : 'Pace' }}</span>
                                <span class="fw-semibold">{{ app()->getLocale() === 'fr' ? 'Temps plein' : 'Full-time' }}</span>
                            </div>
                            <div class="info-item flex-between mb-20">
                                <span class="text-neutral-500">{{ app()->getLocale() === 'fr' ? 'Langue' : 'Language' }}</span>
                                <span class="fw-semibold">{{ app()->getLocale() === 'fr' ? 'Français / Anglais' : 'French / English' }}</span>
                            </div>
                            <div class="info-item flex-between">
                                <span class="text-neutral-500">{{ app()->getLocale() === 'fr' ? 'Étudiants actifs' : 'Active students' }}</span>
                                <span class="fw-semibold">{{ $activeStudentsCount ?? 0 }}+</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Apply Button -->
                    <div class="sidebar-card bg-main-600 rounded-16 p-32 text-center mb-32">
                        <i class="ph-bold ph-hand-peace text-white display-6 d-block mb-16"></i>
                        <h4 class="text-white mb-16">{{ app()->getLocale() === 'fr' ? 'Prêt à postuler ?' : 'Ready to apply?' }}</h4>
                        <p class="text-white opacity-75 mb-24">
                            {{ app()->getLocale() === 'fr' 
                                ? 'Rejoignez notre prochaine promotion et préparez votre avenir.' 
                                : 'Join our next intake and prepare your future.' }}
                        </p>
                        <a href="{{ route('admission') }}" class="btn btn-white rounded-pill w-100 py-12 fw-semibold">
                            {{ app()->getLocale() === 'fr' ? 'Postuler maintenant' : 'Apply now' }}
                            <i class="ph-bold ph-arrow-right ms-8"></i>
                        </a>
                    </div>
            
                    
                    <!-- Contact Card -->
                    <div class="sidebar-card bg-main-25 rounded-16 p-24">
                        <h4 class="mb-24 pb-16 border-bottom border-neutral-30">
                            {{ app()->getLocale() === 'fr' ? 'Besoin d\'aide ?' : 'Need help?' }}
                        </h4>
                        <div class="contact-info">
                            <div class="flex-align gap-12 mb-16">
                                <i class="ph-bold ph-phone text-main-600 text-xl"></i>
                                <a href="tel:+237699001122" class="text-neutral-600 hover-text-main-600">+237 699 001 122</a>
                            </div>
                            <div class="flex-align gap-12 mb-16">
                                <i class="ph-bold ph-envelope text-main-600 text-xl"></i>
                                <a href="mailto:contact@istapa.site" class="text-neutral-600 hover-text-main-600">contact@istapa.site</a>
                            </div>
                            <div class="flex-align gap-12">
                                <i class="ph-bold ph-map-pin text-main-600 text-xl"></i>
                                <span class="text-neutral-600">{{ app()->getLocale() === 'fr' ? 'Yaoundé, Cameroun' : 'Yaoundé, Cameroon' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Program Details End Here ==================== -->

<!-- ==================== Testimonials Section Start Here ==================== -->
@if($testimonials->count() > 0)
<section class="testimonials py-120 bg-main-25">
    <div class="container">
        <div class="text-center mb-60" data-aos="fade-up">
            <h2 class="display-4 fw-semibold mb-16">
                {{ app()->getLocale() === 'fr' ? 'Ce que disent nos étudiants' : 'What our students say' }}
            </h2>
            <p class="text-neutral-500 max-w-600 mx-auto">
                {{ app()->getLocale() === 'fr' 
                    ? 'Découvrez les témoignages de nos étudiants et diplômés' 
                    : 'Discover testimonials from our students and graduates' }}
            </p>
        </div>
        
        <div class="row gy-4">
            @foreach($testimonials as $testimonial)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="testimonial-card bg-white rounded-16 p-24 h-100">
                    <div class="d-flex align-items-center gap-16 mb-16">
                         
                        @if($testimonial->author_photo)
                            <img src="{{ asset('storage/' . $testimonial->author_photo) }}" alt="{{ $testimonial->author_name }}" class="cover-img rounded-circle" />
                        @else
                            <div class="cover-img rounded-circle bg-main-600 flex-center text-white" style="font-size: 32px; font-weight: 600;">
                                {{ strtoupper(substr($testimonial->author_name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h5 class="mb-4">{{ $testimonial->author_name }}</h5>
                        <span class="text-neutral-500 text-sm">{{ $testimonial->author_role }}</span>
                    </div>
                    <p class="text-neutral-600">"{{ $testimonial->content }}"</p>
                    <div class="flex-align gap-4 mt-16">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="ph-fill ph-star {{ $i <= ($testimonial->rating ?? 5) ? 'text-warning' : 'text-neutral-300' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- ==================== Testimonials Section End Here ==================== -->

<!-- ==================== Related Programs Start Here ==================== -->
@php
    $relatedPrograms = \App\Models\Program::published()
        ->where('id', '!=', $program->id)
        ->take(3)
        ->get();
@endphp

@if($relatedPrograms->count() > 0)
<section class="related-programs py-120">
    <div class="container">
        <div class="text-center mb-60" data-aos="fade-up">
            <h2 class="display-4 fw-semibold mb-16">
                {{ app()->getLocale() === 'fr' ? 'Autres programmes qui pourraient vous intéresser' : 'Other programs you might be interested in' }}
            </h2>
        </div>
        
        <div class="row gy-4">
            @foreach($relatedPrograms as $relatedProgram)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="300">
                <div class="program-card bg-main-25 rounded-16 p-20 border border-neutral-30 h-100">
                    <h4 class="mb-16">
                        <a href="{{ route('course.details', $relatedProgram->slug) }}" class="link hover-text-main-600">
                            {{ $relatedProgram->title }}
                        </a>
                    </h4>
                    <p class="text-neutral-500 mb-24 text-line-2">
                        {{ $relatedProgram->excerpt }}
                    </p>
                    <a href="{{ route('course.details', $relatedProgram->slug) }}" class="flex-align gap-8 text-main-600 hover-text-decoration-underline">
                        {{ app()->getLocale() === 'fr' ? 'Découvrir' : 'Discover' }}
                        <i class="ph-bold ph-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- ==================== Related Programs End Here ==================== -->

<!-- ==================== Call to Action Start Here ==================== -->
<section class="cta py-80 bg-main-600 mt-80">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8" data-aos="zoom-in">
                <h2 class="text-white mb-16">
                    {{ app()->getLocale() === 'fr' ? 'Commencez votre parcours aujourd\'hui' : 'Start your journey today' }}
                </h2>
                <p class="text-white opacity-75 mb-32">
                    {{ app()->getLocale() === 'fr' 
                        ? 'Inscrivez-vous à notre programme et bénéficiez d\'une formation de qualité.' 
                        : 'Enroll in our program and benefit from quality training.' }}
                </p>
                <div class="flex-center gap-16 flex-wrap">
                    <a href="{{ route('admission') }}" class="btn btn-white rounded-pill px-40 py-14 fw-semibold">
                        {{ app()->getLocale() === 'fr' ? 'Formulaire d\'admission' : 'Admission form' }}
                        <i class="ph-bold ph-arrow-right ms-8"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-white rounded-pill px-40 py-14 fw-semibold">
                        {{ app()->getLocale() === 'fr' ? 'Contactez-nous' : 'Contact us' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Call to Action End Here ==================== -->
@endsection

@push('styles')
<style>
    .program-content h2 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-size: 1.75rem;
    }
    .program-content h3 {
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        font-size: 1.5rem;
    }
    .program-content ul, .program-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }
    .program-content li {
        margin-bottom: 0.5rem;
    }
    .program-content p {
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    .accordion-button:not(.collapsed) {
        background-color: var(--main-600);
        color: white;
    }
    .accordion-button:not(.collapsed) i {
        color: white;
    }
    .text-line-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endpush