@extends('layouts.app')

@section('title', 'ISTAPA - Accueil')

@section('content')
<!-- ================================== Banner Three Start =============================== -->
<section class="banner-three position-relative responsive-arrow overflow-hidden">
    <button type="button" id="banner-three-prev" class="slick-arrow-prev slick-arrow flex-center rounded-circle bg-white text-main-600 hover-border-main-600 text-2xl hover-bg-main-600 hover-text-white transition-1 w-56 h-56 position-absolute ms-16 inset-inline-start-0 top-50 translate-middle-y z-3">
        <i class="ph-bold ph-arrow-left"></i>
    </button>
    <button type="button" id="banner-three-next" class="slick-arrow-next slick-arrow flex-center rounded-circle bg-white text-main-600 hover-border-main-600 text-2xl hover-bg-main-600 hover-text-white transition-1 w-56 h-56 position-absolute me-16 inset-inline-end-0 top-50 translate-middle-y z-3">
        <i class="ph-bold ph-arrow-right"></i>
    </button>

    <div class="banner-three__slider">
        <div class="banner-three__item background-img bg-img linear-overlay position-relative" data-background-image="{{ asset('assets/images/thumbs/slide6.png') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 col-xl-8 col-lg-10 z-1">
                        <div class="banner-content pe-md-4">
                            <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                <span class="text-yellow-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                                <h5 class="text-yellow-600 mb-0 fw-medium">ISTAPA</h5>
                            </div>
                            <h1 class="display2 mb-24 text-white fw-medium wow bounceInLeft">
                                Formation<span class="text-white wow bounceInRight" data-wow-duration="2s" data-wow-delay=".5s">Professionnelle</span> et Académique
                            </h1>
                            <p class="text-white text-line-2 wow bounceInDown">
                                Nous proposons des filières de formation adaptées aux réalités du monde rural et aux exigences du marché du travail. Nos programmes allient rigueur scientifique, formation pratique sur le terrain et accompagnement entrepreneurial.
                            </p>
                        </div>
                        <div class="buttons-wrapper flex-align flex-wrap gap-24 mt-40">
                            <a href="{{ route('signin') }}" class="btn btn-main rounded-pill flex-align gap-8 wow bounceInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                Postuler Maintenant
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-three__item background-img bg-img linear-overlay position-relative" data-background-image="{{ asset('assets/images/thumbs/slide5.png') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 col-xl-8 col-lg-10 z-1">
                        <div class="banner-content pe-md-4">
                            <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                <span class="text-yellow-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                                <h5 class="text-yellow-600 mb-0 fw-medium">ISTAPA</h5>
                            </div>
                            <h1 class="display2 mb-24 text-white fw-medium wow bounceInLeft">
                                Recherche
                                <span class="wow bounceInRight" data-wow-duration="2s" data-wow-delay=".5s">Appliquée</span> et Innovation
                            </h1>
                            <p class="text-white text-line-2 wow bounceInDown">
                                Nos enseignants-chercheurs mènent des projets visant à améliorer les pratiques agricoles, l'élevage, la transformation agroalimentaire, et la gestion des ressources naturelles. La recherche est un pilier de notre engagement pour un avenir durable.
                            </p>
                        </div>
                        <div class="buttons-wrapper flex-align flex-wrap gap-24 mt-40">
                            <a href="{{ route('signin') }}" class="btn btn-main rounded-pill flex-align gap-8 wow bounceInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                Postuler Maintenant
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-three__item background-img bg-img linear-overlay position-relative" data-background-image="{{ asset('assets/images/thumbs/slide1.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 col-xl-8 col-lg-10 z-1">
                        <div class="banner-content pe-md-4">
                            <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                <span class="text-yellow-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                                <h5 class="text-yellow-600 mb-0 fw-medium">ISTAPA</h5>
                            </div>
                            <h1 class="display2 mb-24 text-white fw-medium wow bounceInLeft">
                                Développement
                                <span class="wow bounceInRight" data-wow-duration="2s" data-wow-delay=".5s">Communautaire</span>
                            </h1>
                            <p class="text-white text-line-2 wow bounceInDown">
                                Nous organisons régulièrement des missions de vulgarisation agricole, des formations pour agriculteurs locaux, et des projets de développement rural avec l'objectif de faire de nos étudiants de véritables acteurs du changement sur le terrain.
                            </p>
                        </div>
                        <div class="buttons-wrapper flex-align flex-wrap gap-24 mt-40">
                            <a href="{{ route('signin') }}" class="btn btn-main rounded-pill flex-align gap-8 wow bounceInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                Postuler Maintenant
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================== Banner Three End =============================== -->


    <!-- ========================== Info Two Section Start =================================== -->
    <section class="info-two half-bg">
        <div class="container">
            <div class="bg-white box-shadow-md rounded-16 p-16">
                <div class="row gy-4 justify-content-center">
                    <div class="col-xl-4 col-sm-6" data-aos="fade-up" data-aos-duration="400">
                        <div class="info-two-item flex-align animation-item h-100 gap-28 border border-neutral-30 rounded-12 bg-main-25">
                            <span class="flex-shrink-0">
                                <img src="assets/images/icons/info-two-icon1.png" class="animate__heartBeat" alt="">
                            </span>
                            <div>
                                <h4 class="mb-16">Bourses d'études</h4>
                                <p class="text-neutral-700">Ces équipements offrent aux étudiants un cadre inspirant et propice à la réussite</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                        <div class="info-two-item flex-align animation-item h-100 gap-28 border border-neutral-30 rounded-12 bg-main-two-25">
                            <span class="flex-shrink-0">
                                <img src="assets/images/icons/info-two-icon2.png" class="animate__heartBeat" alt="">
                            </span>
                            <div>
                                <h4 class="mb-16">Corps professoral d'exception</h4>
                                <p class="text-neutral-700">Notre université s'appuie sur une équipe de professeurs renommés</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                        <div class="info-two-item flex-align animation-item h-100 gap-28 border border-neutral-30 rounded-12 bg-main-three-25">
                            <span class="flex-shrink-0">
                                <img src="assets/images/icons/info-two-icon3.png" class="animate__heartBeat" alt="">
                            </span>
                            <div>
                                <h4 class="mb-16">Programmes diversifiés</h4>
                                <p class="text-neutral-700">Des licences aux programmes de recherche postuniversitaires</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================== Info Two Section End =================================== -->
<!-- ================================ About Section Start ==================================== -->
<section class="about py-120 position-relative z-1 mash-bg-main mash-bg-main-two">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape one animation-scalation" />
    <img src="{{ asset('assets/images/shapes/shape6.png') }}" alt="" class="shape four animation-scalation" />

    <div class="position-relative">
        <div class="container">
            <div class="row gy-xl-0 gy-5 flex-wrap align-items-center">
                   
                <div class="col-xl-6">
                    <div class="about-thumbs position-relative pe-lg-5">
                        <img src="{{ asset('assets/images/shapes/shape7.png') }}" alt="" class="shape seven animation-scalation" />
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <img src="{{ asset('assets/images/thumbs/about-1.jpg') }}" alt="" class="rounded-12 w-100" data-tilt data-tilt-max="15" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening />
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-24">
                                    <div class="bg-main-600 rounded-12 text-center py-24 px-2 min-w-max" data-aos="fade-right">
                                        <h1 class="mb-0 text-white counter">16+</h1>
                                        <span class="text-white">Années d'expérience</span>
                                    </div>
                                </div>
                                <img src="{{ asset('assets/images/thumbs/about-2.jpg') }}" alt="" class="rounded-12 w-100" data-tilt data-tilt-max="20" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-content">
                        <div class="mb-40">
                            <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                                <h5 class="text-main-600 mb-0">À PROPOS DE NOUS</h5>
                            </div>
                            <p class="text-neutral-500 text-line-2 wow bounceInUp">
                                L'Institut Supérieur des Techniques Agro-Pastorales (ISTAPA) est une institution académique de référence dédiée à la formation, à la recherche et à l'innovation dans les domaines de l'agriculture, de l'élevage et de la transformation agroalimentaire.
                            </p>
                        </div>

                        <div class="flex-align align-items-start gap-28 mb-32" data-aos="fade-left" data-aos-duration="200">
                            <span class="w-80 h-80 bg-main-25 border border-neutral-30 flex-center rounded-circle flex-shrink-0">
                                <img src="{{ asset('assets/images/icons/about-img1.png') }}" alt="" />
                            </span>
                            <div class="flex-grow-1">
                                <h4 class="text-neutral-500 mb-12">NOTRE MISSION</h4>
                                <p class="text-neutral-500">
                                    Former des professionnels compétents, capables de relever les défis de la sécurité alimentaire, de la productivité agricole et du développement rural, tout en favorisant l'innovation et la durabilité.
                                </p>
                            </div>
                        </div>
                        <div class="flex-align align-items-start gap-28 mb-0" data-aos="fade-left" data-aos-duration="400">
                            <span class="w-80 h-80 bg-main-25 border border-neutral-30 flex-center rounded-circle flex-shrink-0">
                                <img src="{{ asset('assets/images/icons/about-img2.png') }}" alt="" />
                            </span>
                            <div class="flex-grow-1">
                                <h4 class="text-neutral-500 mb-12">NOTRE ÉQUIPE</h4>
                                <p class="text-neutral-500">
                                    Notre corps enseignant est composé de professeurs qualifiés, de chercheurs chevronnés, et de professionnels du terrain qui partagent leur expertise avec passion et engagement.
                                </p>
                            </div>
                        </div>
                        <div class="flex-align align-items-start gap-28 mb-0" data-aos="fade-left" data-aos-duration="400">
                            <span class="w-80 h-80 bg-main-25 border border-neutral-30 flex-center rounded-circle flex-shrink-0">
                                <img src="{{ asset('assets/images/icons/about-img2.png') }}" alt="" />
                            </span>
                            <div class="flex-grow-1">
                                <h4 class="text-neutral-500 mb-12">NOTRE VISION</h4>
                                <p class="text-neutral-500">
                                    Être un pôle d'excellence agro-pastoral en Afrique centrale, au service de la formation de la jeunesse, de la modernisation du secteur agricole, et du développement des territoires.
                                </p>
                            </div>
                        </div>

                        <div class="flex-align flex-wrap gap-32 pt-40 border-top border-neutral-50 mt-40 border-dashed border-0" data-aos="fade-left" data-aos-duration="600">
                            <a href="{{ route('courses') }}" class="btn btn-main rounded-pill flex-align gap-8">
                                En Savoir Plus
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>             
            </div>
        </div>
    </div>
</section>
<!-- ================================ About Section End ==================================== -->



<!-- ================================== Free Trail Section Start ================================ -->
<section class="free-trails py-120 position-relative z-1 bg-main-25 overflow-hidden">
    <div class="position-relative">
        <div class="container">
            <div class="row gy-xl-0 gy-5 flex-wrap-reverse align-items-center">
                
                <div class="col-lg-6">
                    <div class="mb-40">
                        <div class="flex-align d-inline-flex gap-8 mb-16 wow bounceInDown">
                            <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                            <h5 class="text-main-600 mb-0">Prochaine Rentrée</h5>
                        </div>
                        <h2 class="mb-24 wow bounceInRight">Rentrée prévue pour le 12 octobre 2026</h2>
                        <p class="text-neutral-500 text-line-2 wow bounceInUp">
                            Préparez-vous à vivre une expérience d'apprentissage personnalisée ! Les inscriptions sont ouvertes pour notre prochaine rentrée. Réservez dès aujourd'hui votre <strong>cours d'essai GRATUIT</strong> et découvrez comment nos tuteurs experts peuvent vous accompagner vers la réussite.
                        </p>
                    </div>

                    <ul class="grid-cols-2">
                        <li class="flex-align gap-8" data-aos="fade-left" data-aos-duration="200">
                            <img src="{{ asset('assets/images/icons/check2.png') }}" alt="" />
                            <span class="text-neutral-500 text-md fw-medium">Remplir le Formulaire</span>
                        </li>
                        <li class="flex-align gap-8" data-aos="fade-left" data-aos-duration="400">
                            <img src="{{ asset('assets/images/icons/check2.png') }}" alt="" />
                            <span class="text-neutral-500 text-md fw-medium">Planifier Votre Cours</span>
                        </li>
                        <li class="flex-align gap-8" data-aos="fade-left" data-aos-duration="600">
                            <img src="{{ asset('assets/images/icons/check2.png') }}" alt="" />
                            <span class="text-neutral-500 text-md fw-medium">Rencontrer Votre Tuteur</span>
                        </li>
                        <li class="flex-align gap-8" data-aos="fade-left" data-aos-duration="800">
                            <img src="{{ asset('assets/images/icons/check2.png') }}" alt="" />
                            <span class="text-neutral-500 text-md fw-medium">Commencer le Cours</span>
                        </li>
                    </ul>

                    <div class="pt-40 border-top border-neutral-50 mt-40 border-dashed border-0">
                        <a href="{{ route('signup') }}" class="btn btn-main rounded-pill flex-align d-inline-flex gap-8">
                            Réserver Ma Place
                            <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                        </a>
                        <small class="d-block mt-12 text-neutral-500">
                            <i class="ph-bold ph-shield-check text-main-600 me-4"></i>
                            Inscription sans engagement · Annulation gratuite
                        </small>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative wow bounceIn">
                        <img src="{{ asset('assets/images/thumbs/rentree.jpg') }}" alt="" data-tilt data-tilt-max="8" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-transition="1s" data-tilt-full-page-listening />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================== Free Trail Section End ================================ -->

<!-- ===================================== Testimonials Section Three Start ================================= -->
<section class="testimonials-three py-120 bg-main-25 position-relative z-1 overflow-hidden">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape two animation-scalation" />
    <img src="{{ asset('assets/images/shapes/shape6.png') }}" alt="" class="shape four animation-scalation" />
    <img src="{{ asset('assets/images/shapes/shape4.png') }}" alt="" class="shape one animation-scalation" />

    <div class="container">
        <div class="row gy-4 align-items-center flex-wrap-reverse">
            <div class="col-xl-7">
                <div class="testimonials-three-slider">
                    @forelse($testimonials as $testimonial)
                        <div class="testimonials-three-item bg-white p-24 rounded-12 box-shadow-md">
                            <div class="w-90 h-90 rounded-circle position-relative mb-4">
                                @if($testimonial->author_photo)
                                    <img src="{{ asset('storage/' . $testimonial->author_photo) }}" alt="{{ $testimonial->author_name }}" class="cover-img rounded-circle" />
                                @else
                                    <div class="cover-img rounded-circle bg-main-600 flex-center text-white" style="font-size: 32px; font-weight: 600;">
                                        {{ strtoupper(substr($testimonial->author_name, 0, 2)) }}
                                    </div>
                                @endif
                                <span class="w-40 h-40 bg-main-600 flex-center border border-white border-2 rounded-circle position-absolute inset-block-end-0 inset-inline-end-0 mt--5 me--5">
                                    <img src="{{ asset('assets/images/icons/quote-two-icon.png') }}" alt="" />
                                </span>
                            </div>
                            <p class="text-neutral-500 my-24">{{ $testimonial->content }}</p>
                            <ul class="flex-align gap-8 mb-16">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                                    @elseif($i == round($testimonial->rating) && $testimonial->rating - floor($testimonial->rating) >= 0.5)
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                                    @else
                                        <li class="text-warning-600 text-xl d-flex"><i class="ph ph-star"></i></li>
                                    @endif
                                @endfor
                            </ul>
                            <h4 class="mb-16 text-lg">{{ $testimonial->author_name }}</h4>
                            <span class="text-neutral-500">{{ $testimonial->author_role ?? 'Étudiant' }}</span>
                        </div>
                    @empty
                        <div class="testimonials-three-item bg-white p-24 rounded-12 box-shadow-md text-center">
                            <p>Aucun témoignage pour le moment.</p>
                        </div>
                    @endforelse
                    <div class="testimonials-three-item bg-white p-24 rounded-12 box-shadow-md">
                        <div class="w-90 h-90 rounded-circle position-relative mb-4">
                            <img src="assets/images/thumbs/testimonials-three-img2.png" alt="" class="cover-img rounded-circle">
                            <span class="w-40 h-40 bg-main-600 flex-center border border-white border-2 rounded-circle position-absolute inset-block-end-0 inset-inline-end-0 mt--5 me--5">
                                <img src="assets/images/icons/quote-two-icon.png" alt="">
                            </span>
                        </div>
                        <p class="text-neutral-500 my-24">Attending [University Name] was one of the best decisions I've made. The </p>
                        <ul class="flex-align gap-8 mb-16">
                            <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                            <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                            <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                            <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star"></i></li>
                            <li class="text-warning-600 text-xl d-flex"><i class="ph-fill ph-star-half"></i></li>
                        </ul>
                        <h4 class="mb-16 text-lg">Ronald Richards</h4>
                        <span class="text-neutral-500">Student</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 ps-xl-5">
                <div class="flex-align d-inline-flex gap-8 mb-16 wow bounceInDown">
                    <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                    <h5 class="text-main-600 mb-0">Témoignages</h5>
                </div>
                <h2 class="mb-24 wow bounceInRight">Ce que Dit Notre Communauté</h2>
                <p class="text-neutral-500 text-line-4 wow bounceInUp">
                    Bienvenue dans notre section témoignages, où les membres de notre communauté universitaire partagent leurs expériences et points de vue sur la vie à ISTAPA. Nous vous invitons à nous rejoindre et à faire partie de notre parcours inspirant d'apprentissage, de croissance et d'accomplissement.
                </p>
                <div class="flex-align gap-16 mt-40">
                    <button type="button" id="testimonials-three-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                        <i class="ph ph-caret-left"></i>
                    </button>
                    <button type="button" id="testimonials-three-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                        <i class="ph ph-caret-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ===================================== Testimonials Section Three End ================================= -->

<!-- ===================================== Event Section Start ================================= -->
<section class="event py-120 overflow-hidden">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-12 pe-lg-5">
                <div class="section-heading style-left">
                    <div class="flex-align d-inline-flex gap-8 mb-16 wow bounceInDown">
                        <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                        <h5 class="text-main-600 mb-0">Événements à Venir</h5>
                    </div>
                    <h2 class="mb-24 wow bounceInRight">Participez à Nos Prochains Événements</h2>
                    <p class="text-neutral-500 text-line-4 wow bounceInUp">
                        Rejoignez-nous pour une variété d'événements passionnants qui répondent à vos intérêts et besoins d'apprentissage. Nos événements sont conçus pour inspirer et éduquer.
                    </p>
                </div>

                <div class="event-item-wrapper overflow-x-auto scroll-sm scroll-sm-horizontal pb-4">
                    @forelse($upcomingEvents as $event)
                        <div class="event-item bg-main-25 rounded-12 p-24 d-flex align-items-center border flex-wrap  border-neutral-20 hover-bg-main-600 hover-border-main-600 hover-text-white transition-1 mb-24" data-aos="fade-up-left" data-aos-duration="200">
                            <div class="">
                                <h3 class="mb-8 text-main-600">{{ $event->start_date->format('d') }}</h3>
                                <span class="text-neutral-500">{{ $event->start_date->translatedFormat('M, Y') }}</span>
                            </div>
                            <span class="border border-neutral-40 border-dashed h-72"></span>
                            <div class="">
                                <div class="flex-between gap-16 flex-wrap mb-16">
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-700 text-lg d-flex"><i class="ph-bold ph-clock"></i></span>
                                        <span class="text-neutral-700 text-lg fw-normal">
                                            {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '00:00' }} à {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '23:59' }}
                                        </span>
                                    </div>
                                    <div class="flex-align gap-8">
                                        <span class="text-neutral-700 text-lg d-flex"><i class="ph-bold ph-map-trifold"></i></span>
                                        <span class="text-neutral-700 text-lg fw-normal">{{ $event->location ?? 'Ebogo 1 - Yaoundé, Cameroun' }}</span>
                                    </div>
                                </div>
                                <h4 class="mt-12 mb-0">{{ $event->title }}</h4>
                            </div>
                            <span class="border border-neutral-40 border-dashed h-72 d-none d-md-inline"></span>
                            <div class="flex-shrink-0">
                                <a href="{{ route('event.details', $event->id) }}" class="btn btn-outline-main rounded-pill flex-align d-inline-flex gap-8">
                                    Rejoindre
                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p>Aucun événement à venir pour le moment.</p>
                    @endforelse
                </div>

                <a href="{{ route('events') }}" class="btn btn-outline-main rounded-pill flex-align d-inline-flex gap-8 mt-40">
                    Voir Tous les Événements
                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- ===================================== Event Section End ================================= -->

<!-- =========================== Blog Two SEction Start ============================= -->
<section class="blog-two py-120 bg-main-25">
    <div class="container">
        <div class="section-heading text-center">
            <div class="flex-align d-inline-flex gap-8 mb-16 wow bounceInDown">
                <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                <h5 class="text-main-600 mb-0">Dernières Nouvelles</h5>
            </div>
            <h2 class="mb-24 wow bounceIn">Restez Informés, Restez Inspirés</h2>
            <p class="wow bounceInUp">
                Bienvenue sur notre blog, où nous partageons des idées, des histoires et des mises à jour sur des sujets allant de l'éducation
            </p>
        </div>
        <div class="blog-two-slider">
            @foreach($latestBlogs as $blog)
                <div class="scale-hover-item bg-white rounded-16 p-12 h-100" data-aos="fade-up" data-aos-duration="{{ $loop->iteration * 200 }}">
                    <div class="course-item__thumb rounded-12 overflow-hidden position-relative">
                        <a href="{{ route('blog.details', $blog->id) }}" class="w-100 h-100">
                            @if($blog->cover_image)
                                <img src="{{ asset('storage/' . $blog->cover_image) }}" alt="{{ $blog->title }}" class="scale-hover-item__img rounded-12 cover-img transition-2" />
                            @else
                               <div class="bc-cover-placeholder">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                    <!-- <span>Image à venir</span> -->
                                </div>
                            @endif
                        
                        </a>
                        <div class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-three-600 text-white fw-medium">
                            <h3 class="mb-0 text-white fw-medium">{{ $blog->published_at ? $blog->published_at->format('d') : '' }}</h3>
                            {{ $blog->published_at ? strtoupper($blog->published_at->translatedFormat('M')) : '' }}
                        </div>
                    </div>
                    <div class="pt-32 pb-24 px-16 position-relative">
                        <h4 class="mb-28">
                            <a href="{{ route('blog.details', $blog->id) }}" class="link text-line-2">{{ $blog->title }}</a>
                        </h4>
                        <div class="flex-align gap-14 flex-wrap my-20">
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph-bold ph-eye"></i></span>
                                <span class="text-neutral-500 text-lg">{{ $blog->view_count }}</span>
                            </div>
                            <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-chat-dots"></i></span>
                                <span class="text-neutral-500 text-lg">{{ $blog->comments->where('is_approved', true)->count() }}</span>
                            </div>
                        </div>
                        <div class="flex-between gap-8 pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                            <a href="{{ route('blog.details', $blog->id) }}" class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold">
                                Lire la Suite
                                <i class="ph ph-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex-align gap-16 mt-40 justify-content-center">
            <button type="button" id="blog-two-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                <i class="ph ph-caret-left"></i>
            </button>
            <button type="button" id="blog-two-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                <i class="ph ph-caret-right"></i>
            </button>
        </div>
    </div>
</section>
<!-- =========================== Blog Two SEction End ============================= -->

<!-- ================================ Join Community Section Start ============================= -->
<section class="join-community">
    <div class="container">
        <div class="rounded-20 py-120 px-8">
            <div class="container">
                <div class="row gy-4 align-items-center flex-wrap-reverse">
                    <div class="col-lg-6">
                        <div class="join-community__content">
                            <div class="mb-40">
                                <h2 class="mb-24 wow bounceIn">Rejoignez la Communauté ISTAPA : Commencez Maintenant</h2>
                                <p class="text-neutral-500 text-line-2 wow bounceInUp">
                                    Prêt à découvrir nos cours par vous-même ? Inscrivez-vous pour une leçon d'essai gratuite dès aujourd'hui et obtenez un aperçu de l'expérience d'apprentissage engageante.
                                </p>
                            </div>

                            <form action="#">
                                <div class="mb-24 position-relative" data-aos="fade-up-left" data-aos-duration="400">
                                    <input type="text" class="bg-white text-black border border-transparent focus-border-main-600 h-48 rounded-pill px-16 ps-60 outline-0 w-100" placeholder="Entrez votre nom..." />
                                    <span class="bg-main-600 text-white text-2xl flex-center w-48 h-48 rounded-circle border border-main-25 border-4 position-absolute inset-inline-start-0 top-50 translate-middle-y">
                                        <i class="ph-bold ph-user-circle"></i>
                                    </span>
                                </div>
                                <div class="mb-24 position-relative" data-aos="fade-up-left" data-aos-duration="600">
                                    <input type="email" class="bg-white text-black border border-transparent focus-border-main-600 h-48 rounded-pill px-16 ps-60 outline-0 w-100" placeholder="Entrez votre email" />
                                    <span class="bg-main-600 text-white text-2xl flex-center w-48 h-48 rounded-circle border border-main-25 border-4 position-absolute inset-inline-start-0 top-50 translate-middle-y">
                                        <i class="ph-bold ph-envelope-open"></i>
                                    </span>
                                </div>
                                <div class="mb-24 position-relative" data-aos="fade-up-left" data-aos-duration="800">
                                    <textarea id="desc" class="bg-white text-black border border-transparent focus-border-main-600 h-48 rounded-pill px-16 ps-60 outline-0 w-100 text-neutral-300" placeholder="Entrez votre message..."></textarea>
                                    <span class="bg-main-600 text-white text-2xl flex-center w-48 h-48 rounded-circle border border-main-25 border-4 position-absolute inset-inline-start-0 top-50 translate-middle-y">
                                        <i class="ph-bold ph-book"></i>
                                    </span>
                                </div>
                                <div class="mt-40 position-relative" data-aos="fade-up-left" data-aos-duration="1000">
                                    <button type="submit" class="btn btn-main rounded-pill flex-align d-inline-flex gap-8">
                                        Rejoindre
                                        <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="join-community__thumb text-end position-relative">
                            <img src="{{ asset('assets/images/thumbs/contact1.jpg') }}" alt="" class="wow bounceIn" data-tilt data-tilt-max="12" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ Join Community Section End ============================= -->

<!-- ========================== Brand Section Start =========================== -->
<div class="brand wow fadeInUpBig" data-wow-duration="1s" data-wow-delay=".5s">
    <div class="container container--lg">
        <div class="brand-box py-80 px-16">
            <h5 class="mb-40 text-center text-neutral-500">ILS NOUS FONT CONFIANCE</h5>
            <div class="container">
                <div class="brand-slider">
                    <div class="brand-slider__item px-24">
                        <img src="{{ asset('assets/images/thumbs/cefprepa.png') }}" alt="" />
                    </div>
                    <div class="brand-slider__item px-24">
                        <img src="{{ asset('assets/images/thumbs/Sharda-University-Logo-Vector.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========================== Brand Section End =========================== -->
@endsection

