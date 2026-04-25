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
        <div class="banner-three__item background-img bg-img linear-overlay position-relative" data-background-image="https://istapa.com/wp-content/uploads/2025/07/slide4.png">
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
        <div class="banner-three__item background-img bg-img linear-overlay position-relative" data-background-image="https://istapa.com/wp-content/uploads/2025/07/slide3.png">
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
        <div class="banner-three__item background-img bg-img linear-overlay position-relative" data-background-image="https://istapa.com/wp-content/uploads/2025/07/slide3.png">
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

<!-- ================================ About Section Start ==================================== -->
<section class="about py-120 position-relative z-1 mash-bg-main mash-bg-main-two">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape one animation-scalation" />
    <img src="{{ asset('assets/images/shapes/shape6.png') }}" alt="" class="shape four animation-scalation" />

    <div class="position-relative">
        <div class="container">
            <div class="row gy-xl-0 gy-5 flex-wrap-reverse align-items-center">
                <div class="col-xl-6">
                    <div class="about-thumbs position-relative pe-lg-5">
                        <img src="{{ asset('assets/images/shapes/shape7.png') }}" alt="" class="shape seven animation-scalation" />
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <img src="https://istapa.com/wp-content/uploads/2025/06/475105121_122156457968331499_8259807869563249512_n1-1-768x962.jpg" alt="" class="rounded-12 w-100" data-tilt data-tilt-max="15" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening />
                            </div>
                            <div class="col-sm-6">
                                <div class="flex-align gap-24 mb-24">
                                    <div class="bg-main-600 rounded-12 text-center py-24 px-2 w-50-percent" data-aos="fade-right">
                                        <h1 class="mb-0 text-white counter">16+</h1>
                                        <span class="text-white">Années d'expérience</span>
                                    </div>
                                    <div class="bg-neutral-700 rounded-12 text-center py-24 px-2 w-50-percent" data-aos="fade-left">
                                        <h1 class="mb-0 text-white counter">3.2k</h1>
                                        <span class="text-white">Étudiants diplômés</span>
                                    </div>
                                </div>
                                <img src="https://istapa.com/wp-content/uploads/2025/07/WhatsApp-Image-2025-07-01-at-16.29.59_248a4706-768x1024.jpg" alt="" class="rounded-12 w-100" data-tilt data-tilt-max="20" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening />
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

<!-- ============================ Category Section Start ==================================== -->
<section class="category py-120 position-relative z-1 mash-bg-main mash-bg-main-two mash-reverse">
    <div class="container">
        <div class="section-heading text-center">
            <div class="flex-align d-inline-flex gap-8 mb-16 wow bounceInDown">
                <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book"></i></span>
                <h5 class="text-main-600 mb-0">Catégories</h5>
            </div>
            <h2 class="mb-24 wow bounceIn">Élevez Votre Expérience d'Apprentissage</h2>
            <p class="wow bounceInUp">
                Notre plateforme est construite sur les principes d'innovation, de qualité et d'inclusivité, visant à offrir une expérience d'apprentissage fluide.
            </p>
        </div>
        <div class="category-item-slider">
            <div class="category-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-25 border border-neutral-30 hover-border-main-600 transition-2" data-aos="fade-up" data-aos-duration="200">
                <span class="w-96 h-96 flex-center d-inline-flex bg-white text-main-600 text-40 rounded-circle box-shadow-md mb-24">
                    <img src="{{ asset('assets/images/icons/category-icon1.png') }}" class="animate__flipInY" alt="" />
                </span>
                <h4 class="display-four mb-16 text-neutral-700">TROUVER UNE FORMATION</h4>
                <p class="text-neutral-500 text-lg">
                    Nous proposons une vaste gamme de formations adaptées à divers secteurs professionnels, permettant aux étudiants de choisir des cursus alignés avec leurs aspirations et les besoins du marché.
                </p>
            </div>
            <div class="category-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-two-25 border border-neutral-30 hover-border-main-two-600 transition-2" data-aos="fade-up" data-aos-duration="400">
                <span class="w-96 h-96 flex-center d-inline-flex bg-white text-main-600 text-40 rounded-circle box-shadow-md mb-24">
                    <img src="{{ asset('assets/images/icons/category-icon2.png') }}" class="animate__flipInY" alt="" />
                </span>
                <h4 class="display-four mb-16 text-neutral-700">CONCOURS & EXAMENS</h4>
                <p class="text-neutral-500 text-lg">
                    Nous organisons régulièrement des concours d'entrée et des examens rigoureux pour sélectionner et évaluer les étudiants, garantissant un niveau académique élevé et l'excellence dans chaque programme.
                </p>
            </div>
            <div class="category-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-three-25 border border-neutral-30 hover-border-main-three-600 transition-2" data-aos="fade-up" data-aos-duration="600">
                <span class="w-96 h-96 flex-center d-inline-flex bg-white text-main-three-600 text-40 rounded-circle box-shadow-md mb-24">
                    <img src="{{ asset('assets/images/icons/category-icon3.png') }}" class="animate__flipInY" alt="" />
                </span>
                <h4 class="display-four mb-16 text-neutral-700">LEADERSHIP</h4>
                <p class="text-neutral-500 text-lg">
                    Nous formons des leaders engagés, aptes à répondre aux enjeux agricoles et environnementaux du monde actuel. Elle développe chez les étudiants des compétences en gestion agro-pastorale, en innovation rurale et en prise de décision stratégique pour un développement durable des territoires.
                </p>
            </div>
            <div class="category-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-two-25 border border-neutral-30 hover-border-main-two-600 transition-2" data-aos="fade-up" data-aos-duration="800">
                <span class="w-96 h-96 flex-center d-inline-flex bg-white text-main-600 text-40 rounded-circle box-shadow-md mb-24">
                    <img src="{{ asset('assets/images/icons/category-icon4.png') }}" class="animate__flipInY" alt="" />
                </span>
                <h4 class="display-four mb-16 text-neutral-700">INSCRIPTION EN LIGNE</h4>
                <p class="text-neutral-500 text-lg">
                    Nous offrons un processus d'inscription en ligne simple et rapide, permettant aux futurs étudiants de postuler à distance, en toute sécurité, via la plateforme dédiée. Vous pouvez soumettre vos documents et suivre l'évolution de votre dossier en quelques clics.
                </p>
            </div>
        </div>
        <div class="flex-align gap-16 mt-40 justify-content-center">
            <button type="button" id="category-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                <i class="ph ph-caret-left"></i>
            </button>
            <button type="button" id="category-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                <i class="ph ph-caret-right"></i>
            </button>
        </div>
    </div>
</section>
<!-- ============================ Category Section End ==================================== -->

<!-- ================================== Free Trail Section Start ================================ -->
<section class="free-trails py-120 position-relative z-1 bg-main-25 overflow-hidden">
    <div class="position-relative">
        <div class="container">
            <div class="row gy-xl-0 gy-5 flex-wrap-reverse align-items-center">
                <div class="col-lg-6">
                    <div class="position-relative wow bounceIn">
                        <img src="https://istapa.com/wp-content/uploads/2025/06/457504865_122130726842331499_374861020851708552_n-1-768x576.jpg" alt="" data-tilt data-tilt-max="8" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-transition="1s" data-tilt-full-page-listening />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-40">
                        <div class="flex-align d-inline-flex gap-8 mb-16 wow bounceInDown">
                            <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                            <h5 class="text-main-600 mb-0">Prochaine Rentrée</h5>
                        </div>
                        <h2 class="mb-24 wow bounceInRight">Rentrée prévue pour le 28 juillet 2026</h2>
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
                            <img src="{{ asset('assets/images/thumbs/testimonials-three-img1.png') }}" alt="Avatar" class="cover-img rounded-circle" />
                            @endif
                            <span class="w-40 h-40 bg-main-two-600 flex-center border border-white border-2 rounded-circle position-absolute inset-block-end-0 inset-inline-end-0 mt--5 me--5">
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
                </div>
            </div>

            <div class="col-xl-5 ps-xl-5">
                <div class="flex-align d-inline-flex gap-8 mb-16 wow bounceInDown">
                    <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-book-open"></i></span>
                    <h5 class="text-main-600 mb-0">Témoignages</h5>
                </div>
                <h2 class="mb-24 wow bounceInRight">Ce que Dit Notre Communauté</h2>
                <p class="text-neutral-500 text-line-4 wow bounceInUp">
                    Bienvenue dans notre section témoignages, où les membres de notre communauté universitaire partagent leurs expériences et points de vue sur la vie à EduAll. Nous vous invitons à nous rejoindre et à faire partie de notre parcours inspirant d'apprentissage, de croissance et d'accomplissement.
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
                    <a href="{{ route('blog.details', $blog->slug) }}" class="w-100 h-100">
                        <img src="{{ $blog->cover_image ? asset('storage/' . $blog->cover_image) : asset('assets/images/thumbs/blog-two-img1.png') }}" alt="{{ $blog->title }}" class="scale-hover-item__img rounded-12 cover-img transition-2" />
                    </a>
                    <div class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-three-600 text-white fw-medium">
                        <h3 class="mb-0 text-white fw-medium">{{ $blog->published_at ? $blog->published_at->format('d') : '' }}</h3>
                        {{ $blog->published_at ? strtoupper($blog->published_at->translatedFormat('M')) : '' }}
                    </div>
                </div>
                <div class="pt-32 pb-24 px-16 position-relative">
                    <h4 class="mb-28">
                        <a href="{{ route('blog.details', $blog->slug) }}" class="link text-line-2">{{ $blog->title }}</a>
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
                        <a href="{{ route('blog.details', $blog->slug) }}" class="flex-align gap-8 text-main-600 hover-text-decoration-underline transition-1 fw-semibold">
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
                <div class="row gy-4 align-items-center">
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
                            <img src="https://istapa.com/wp-content/uploads/2025/06/457774318_122130731990331499_8404464423876650403_n-768x768.jpg" alt="" class="wow bounceIn" data-tilt data-tilt-max="12" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening />
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
                        <img src="https://istapa.com/wp-content/uploads/2025/07/act-3.png" alt="" />
                    </div>
                    <div class="brand-slider__item px-24">
                        <img src="https://istapa.com/wp-content/uploads/2025/08/Sharda-University-Logo-Vector.svg--1024x322.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========================== Brand Section End =========================== -->
@endsection

@push('scripts')
<script>
    // Banner slider initialization
    $(document).ready(function() {
        if ($('.banner-three__slider').length) {
            $('.banner-three__slider').slick({
                dots: false,
                infinite: true,
                speed: 1000,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,
                prevArrow: '#banner-three-prev',
                nextArrow: '#banner-three-next',
                fade: true,
                cssEase: 'linear'
            });
        }

        if ($('.category-item-slider').length) {
            $('.category-item-slider').slick({
                dots: false,
                infinite: true,
                speed: 1000,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                prevArrow: '#category-prev',
                nextArrow: '#category-next',
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }

        if ($('.testimonials-three-slider').length) {
            $('.testimonials-three-slider').slick({
                dots: false,
                infinite: true,
                speed: 1000,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 4000,
                prevArrow: '#testimonials-three-prev',
                nextArrow: '#testimonials-three-next',
                fade: true,
                cssEase: 'linear'
            });
        }

        if ($('.blog-two-slider').length) {
            $('.blog-two-slider').slick({
                dots: false,
                infinite: true,
                speed: 1000,
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                prevArrow: '#blog-two-prev',
                nextArrow: '#blog-two-next',
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                        }
                    }
                ]
            });
        }

        if ($('.brand-slider').length) {
            $('.brand-slider').slick({
                dots: false,
                infinite: true,
                speed: 800,
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 5,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                        }
                    }
                ]
            });
        }
    });
</script>
@endpush