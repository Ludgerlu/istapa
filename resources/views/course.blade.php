@extends('layouts.app')

@section('title', $title = app()->getLocale() === 'fr' ? 'Nos Programmes - ISTAPA' : 'Our Programs - ISTAPA')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <img src="{{ asset('assets/images/shapes/shape1.png') }}" alt="" class="shape one animation-rotation d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape two animation-scalation d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape3.png') }}" alt="" class="shape eight animation-walking d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape5.png') }}" alt="" class="shape six animation-walking d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape4.png') }}" alt="" class="shape four animation-scalation">
    <img src="{{ asset('assets/images/shapes/shape4.png') }}" alt="" class="shape nine animation-scalation">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">
                        {{ app()->getLocale() === 'fr' ? 'Nos Programmes de Formation' : 'Our Training Programs' }}
                    </h1>
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
                            <span class="text-main-two-600">
                                {{ app()->getLocale() === 'fr' ? 'Programmes' : 'Programs' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ==================== Programs Section Start Here ==================== -->
<section class="programs py-120">
    <div class="container">
        <div class="text-center mb-60" data-aos="fade-up">
            <h2 class="display-4 fw-semibold mb-16">
                {{ app()->getLocale() === 'fr' ? 'Découvrez Nos Formations' : 'Discover Our Programs' }}
            </h2>
            <p class="text-neutral-500 max-w-600 mx-auto">
                {{ app()->getLocale() === 'fr' 
                    ? 'Des formations de qualité pour répondre aux besoins du secteur agricole et environnemental' 
                    : 'Quality training programs to meet the needs of the agricultural and environmental sector' }}
            </p>
        </div>

        <div class="row gy-4">
            @forelse($programs as $program)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="program-card bg-main-25 rounded-16 p-20 border border-neutral-30 hover-border-main-600 transition-2 h-100">
                        <div class="program-card__thumb position-relative mb-24">
                            @if($program->cover_image)
                                <img src="{{ asset('storage/' . $program->cover_image) }}" alt="{{ $program->title }}" class="w-100 rounded-12 object-fit-cover" style="height: 220px;">
                            @else
                                <div class="bc-cover-placeholder">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                    <!-- <span>Image à venir</span> -->
                                </div>
                            @endif
                            <div class="program-badge position-absolute top-0 start-0 mt-16 ms-16 bg-main-600 text-white px-16 py-8 rounded-pill">
                                <span class="text-sm fw-medium">
                                    {{ $program->duration_months ?? 24 }} {{ app()->getLocale() === 'fr' ? 'mois' : 'months' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="program-card__content">
                            <h3 class="mb-16">
                                <a href="{{ route('course.details', $program->id) }}" class="link hover-text-main-600">
                                    {{ $program->title }}
                                </a>
                            </h3>
                            <p class="text-neutral-500 mb-24 text-line-3">
                                {{ $program->excerpt }}
                            </p>
                            
                            <div class="flex-between gap-16 flex-wrap mb-24">
                                <div class="flex-align gap-8">
                                    <i class="ph-bold ph-graduation-cap text-main-600 text-xl"></i>
                                    <span class="text-neutral-600">
                                        {{ $program->classes->count() }} 
                                        {{ app()->getLocale() === 'fr' ? 'classes' : 'classes' }}
                                    </span>
                                </div>
                                <div class="flex-align gap-8">
                                    <i class="ph-bold ph-users text-main-600 text-xl"></i>
                                    <span class="text-neutral-600">
                                        {{ $program->admissionRequests->where('status', 'accepted')->count() }}
                                        {{ app()->getLocale() === 'fr' ? 'étudiants' : 'students' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="border-top border-neutral-30 pt-24">
                                <a href="{{ route('course.details', $program->id) }}" class="btn bg-main-600 rounded-pill w-100 py-12 hover-bg-main-600 hover-text-white transition-2 text-center d-inline-block">
                                    {{ app()->getLocale() === 'fr' ? 'En savoir plus' : 'Learn more' }}
                                    <i class="ph-bold ph-arrow-right ms-8"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-60">
                        <i class="ph-bold ph-graduation-cap text-neutral-400" style="font-size: 64px;"></i>
                        <h4 class="mt-24 text-neutral-500">
                            {{ app()->getLocale() === 'fr' ? 'Aucun programme disponible pour le moment.' : 'No programs available at the moment.' }}
                        </h4>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- ==================== Programs Section End Here ==================== -->


<!-- ==================== Why Choose Us Section Start Here ==================== -->
<section class="why-choose-us py-120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="why-choose-us__thumb position-relative">
                    <img src="{{ asset('assets/images/thumbs/why-choose-us.jpg') }}" alt="Why Choose ISTAPA" class="rounded-16 w-100">
                    <div class="experience-card bg-main-600 text-white rounded-16 p-24 position-absolute bottom-0 end-0 mb-32 me-32 text-center">
                        <span class="display-4 fw-bold">+10</span>
                        <span class="d-block">{{ app()->getLocale() === 'fr' ? 'Années d\'excellence' : 'Years of excellence' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="why-choose-us__content">
                    <h5 class="text-main-600 mb-16">{{ app()->getLocale() === 'fr' ? 'Pourquoi nous choisir ?' : 'Why choose us?' }}</h5>
                    <h2 class="display-5 fw-semibold mb-24">
                        {{ app()->getLocale() === 'fr' ? 'Une formation d\'excellence pour votre avenir' : 'Excellent training for your future' }}
                    </h2>
                    <p class="text-neutral-500 mb-32">
                        {{ app()->getLocale() === 'fr' 
                            ? 'ISTAPA combine théorie et pratique pour former des techniciens supérieurs compétents, capables de répondre aux défis du secteur agricole et environnemental.' 
                            : 'ISTAPA combines theory and practice to train competent higher technicians capable of meeting the challenges of the agricultural and environmental sector.' }}
                    </p>
                    
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="feature-item flex-align gap-16">
                                <div class="feature-icon w-60 h-60 bg-main-25 rounded-circle flex-center">
                                    <i class="ph-bold ph-chalkboard-teacher text-main-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="mb-4">{{ app()->getLocale() === 'fr' ? 'Experts pédagogues' : 'Expert educators' }}</h5>
                                    <span class="text-neutral-500 text-sm">{{ app()->getLocale() === 'fr' ? 'Enseignants qualifiés' : 'Qualified teachers' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-item flex-align gap-16">
                                <div class="feature-icon w-60 h-60 bg-main-25 rounded-circle flex-center">
                                    <i class="ph-bold ph-flask text-main-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="mb-4">{{ app()->getLocale() === 'fr' ? 'Approche pratique' : 'Practical approach' }}</h5>
                                    <span class="text-neutral-500 text-sm">{{ app()->getLocale() === 'fr' ? 'Stages et travaux terrain' : 'Internships and fieldwork' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-item flex-align gap-16">
                                <div class="feature-icon w-60 h-60 bg-main-25 rounded-circle flex-center">
                                    <i class="ph-bold ph-briefcase text-main-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="mb-4">{{ app()->getLocale() === 'fr' ? 'Insertion professionnelle' : 'Career placement' }}</h5>
                                    <span class="text-neutral-500 text-sm">{{ app()->getLocale() === 'fr' ? 'Taux d\'insertion élevé' : 'High employment rate' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-item flex-align gap-16">
                                <div class="feature-icon w-60 h-60 bg-main-25 rounded-circle flex-center">
                                    <i class="ph-bold ph-handshake text-main-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h5 class="mb-4">{{ app()->getLocale() === 'fr' ? 'Partenariats solides' : 'Strong partnerships' }}</h5>
                                    <span class="text-neutral-500 text-sm">{{ app()->getLocale() === 'fr' ? 'Avec le secteur privé' : 'With the private sector' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Why Choose Us Section End Here ==================== -->

<!-- ==================== Call to Action Start Here ==================== -->
<section class="cta py-80 bg-main-600 mt-80">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8" data-aos="zoom-in">
                <h2 class="text-white mb-16">
                    {{ app()->getLocale() === 'fr' ? 'Prêt à rejoindre l\'ISTAPA ?' : 'Ready to join ISTAPA?' }}
                </h2>
                <p class="text-white opacity-75 mb-32">
                    {{ app()->getLocale() === 'fr' 
                        ? 'Inscrivez-vous dès maintenant et commencez votre parcours vers une carrière réussie dans l\'agriculture et l\'environnement.' 
                        : 'Register now and start your journey towards a successful career in agriculture and environment.' }}
                </p>
                <div class="flex-center gap-16 flex-wrap">
                    <a href="{{ route('admission') }}" class="btn btn-white rounded-pill px-40 py-14 fw-semibold">
                        {{ app()->getLocale() === 'fr' ? 'Postuler maintenant' : 'Apply now' }}
                        <i class="ph-bold ph-arrow-right ms-8"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-white rounded-pill px-40 py-14 fw-semibold">
                        {{ app()->getLocale() === 'fr' ? 'Nous contacter' : 'Contact us' }}
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
    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .text-line-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endpush