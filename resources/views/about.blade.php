@extends('layouts.app')

@section('title', 'ISTAPA - Le Mot du Fondateur')

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
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Le Mot du Fondateur</h1>
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
                            <span class="text-main-two-600">Le Mot du Fondateur</span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ================================ About Section Start ==================================== -->
<section class="about py-120 position-relative z-1 mash-bg-main mash-bg-main-two">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape one animation-scalation">
    <img src="{{ asset('assets/images/shapes/shape6.png') }}" alt="" class="shape four animation-scalation">

    <div class="position-relative">
        <div class="container">
            <div class="row gy-xl-0 gy-5 flex-wrap-reverse align-items-center">
                <div class="col-xl-6">
                    <div class="about-thumbs position-relative pe-lg-5">
                        <img src="{{ asset('assets/images/shapes/shape7.png') }}" alt="" class="shape seven animation-scalation">
    
                        <div class="offer-message px-24 py-12 rounded-12 bg-main-two-50 fw-medium flex-align d-inline-flex gap-16 border border-neutral-30 animation-upDown">
                            <span class="flex-shrink-0 w-48 h-48 bg-main-two-600 text-white text-2xl flex-center rounded-circle"><i class="ph ph-watch"></i></span>
                            <div>
                                <h6 class="mb-4">20% OFF</h6>
                                <span class="text-neutral-500">Pour Toutes les Formations</span>
                            </div>
                        </div>
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <img src="{{ asset('assets/images/thumbs/fondateur.jpg') }}" alt="" class="rounded-12 w-100" data-tilt data-tilt-max="15" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening>
                            </div>
                            <div class="col-sm-6">
                                <div class="flex-align gap-24 mb-24">
                                    <div class="bg-main-600 rounded-12 text-center py-24 px-2 w-50-percent" data-aos="fade-right">    
                                        <h1 class="mb-0 text-white counter">16+</h1>
                                        <span class="text-white">Années d'expérience</span>
                                    </div>
                                    <div class="bg-neutral-700 rounded-12 text-center py-24 px-2 w-50-percent" data-aos="fade-left">    
                                        <h1 class="mb-0 text-white counter">3.2k</h1>
                                        <span class="text-white">Étudiants formés</span>
                                    </div>
                                </div>
                                <img src="{{ asset('assets/images/thumbs/slide5.png') }}" alt="" class="rounded-12 w-100" data-tilt data-tilt-max="20" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="about-content">
                        <div class="mb-40">
                            <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                                <h5 class="text-main-600 mb-0">Le Mot du Fondateur</h5>
                            </div>
                            <h2 class="mb-24 wow bounceIn">Renforcer les Capacités pour un Développement Durable</h2>
                            <p class="text-neutral-500 wow bounceInUp">Les secteurs agropastoraux et de la protection de l'environnement sont des piliers très importants dans le processus de développement économique durable des pays d'Afrique subsaharienne. C'est pourquoi ces secteurs occupent une place de choix dans les politiques et stratégies de développement des pays.</p>
                            <p class="text-neutral-500 wow bounceInUp">D'une part, la participation active des producteurs agropastoraux aux initiatives de développement initiées par les Etats, les partenaires au développement ou le secteur privé, se heurte à un certain nombre de contraintes, notamment : l'inadéquation des formations et l'insuffisance des structures de formation. La formation en nombre et en qualité de ressources humaines capables de stimuler la croissance du secteur agro-pastoral grâce notamment à l'exploitation des énergies renouvelables disponibles en abondance, nécessite notamment la disponibilité de structures de formation modernes, innovantes et performantes.</p>
                            <p class="text-neutral-500 wow bounceInUp">D'autre part, compte tenu de l'impact du changement climatique, il est crucial de mettre en place des stratégies d'adaptation et de résilience qui incluent la promotion des pratiques intelligentes face au climat, notamment à travers la formation des ressources humaines sur les métiers de l'environnement, de la gestion efficace de l'eau et des énergies renouvelables.</p>
                            <p class="text-neutral-500 wow bounceInUp">C'est dans le but de soutenir les gouvernements africains dans leurs actions pour le développement durable que l'ISTAPA contribue, à travers son système de formation innovant, au renforcement des capacités techniques des acteurs travaillant dans ces secteurs.</p>
                        </div>
                    </div>
                    <div class="flex-align flex-wrap gap-32 pt-40 border-top border-neutral-50 mt-40 border-dashed border-0" data-aos="fade-left" data-aos-duration="600">
                        <a href="{{ route('courses') }}" class="btn btn-main rounded-pill flex-align gap-8">
                            Découvrir nos Programmes
                            <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                        </a>
                        <div class="flex-align gap-20">
                            <!--  <img src="{{ asset('assets/images/thumbs/ceo-img.png') }}" alt="" class="w-52 h-52 rounded-circle object-fit-cover flex-shrink-0"> -->
                            <div class="flex-grow-1">
                                <span class="mb-4">
                                    <img src="{{ asset('assets/images/thumbs/signature.png') }}" alt="">
                                </span>
                                <span class="text-sm d-block">Fondateur d'ISTAPA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ About Section End ==================================== -->

<!-- =========================== CHoose Us Section Start ================================ -->
<section class="choose-us pt-120 position-relative z-1 mash-bg-main mash-bg-main-two">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape one animation-scalation">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape six animation-scalation">

    <div class="container">
        <div class="row gy-4">
            <div class="col-xl-6">
                <div class="choose-us__content">
                    <div class="mb-40">
                        <div class="flex-align gap-8 mb-16 wow bounceInDown">
                            <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                            <h5 class="text-main-600 mb-0">Pourquoi Choisir ISTAPA</h5>
                        </div>
                        <h2 class="mb-24 wow bounceIn">Notre Engagement pour l'Excellence, Apprendre, Grandir & Réussir.</h2>
                        <p class="text-neutral-500 text-line-2 wow bounceInUp">Nous sommes passionnés par la transformation des vies à travers l'éducation. Fondé avec la vision de rendre l'apprentissage accessible à tous, nous croyons au pouvoir de la connaissance pour ouvrir des opportunités et façonner l'avenir.</p>
                    </div>

                    <ul>
                        <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="200">
                            <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">9/10 Taux de Satisfaction Moyen</span>
                        </li>
                        <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="400">
                            <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">96% Taux d'Assiduité</span>
                        </li>
                        <li class="flex-align gap-12 mb-16" data-aos="fade-up-left" data-aos-duration="500">
                            <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Environnement Convivial & Enseignants Experts</span>
                        </li>
                    </ul>

                    
                    <div class="flex-align align-items-start gap-28 mb-32" data-aos="fade-left" data-aos-duration="200">
                        <span class="w-80 h-80 bg-main-25 border border-neutral-30 flex-center rounded-circle flex-shrink-0">
                            <img src="{{ asset('assets/images/icons/about-img1.png') }}" alt="">
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="text-neutral-500 mb-12">Former des Entrepreneurs</h4>
                            <p class="text-neutral-500">En formant les apprenants aux techniques innovantes de production agropastorale et aux bonnes pratiques de protection de l'environnement, ISTAPA vise à préparer ses étudiants à devenir des entrepreneurs prospères à la fin de leur formation et à contribuer au développement durable de l'Afrique.</p>
                        </div>
                    </div>
                    <div class="flex-align align-items-start gap-28 mb-0" data-aos="fade-left" data-aos-duration="400">
                        <span class="w-80 h-80 bg-main-25 border border-neutral-30 flex-center rounded-circle flex-shrink-0">
                            <img src="{{ asset('assets/images/icons/about-img2.png') }}" alt="">
                        </span>
                        <div class="flex-grow-1">
                            <h4 class="text-neutral-500 mb-12">Un Appel à la Jeunesse</h4>
                            <p class="text-neutral-500">Les étudiants de ISTAPA se forment dans un environnement académique et professionnel innovant, ce qui les incite à comprendre que leur vocation est de créer leur propre emploi à la fin de la formation et d'employer d'autres jeunes.</p>
                        </div>
                    </div>

                    <div class="pt-24 border-top border-neutral-50 mt-28 border-dashed border-0">
                        <a href="{{ route('about.establishment') }}" class="btn btn-main rounded-pill flex-align d-inline-flex gap-8">
                            En Savoir Plus
                            <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="choose-us__thumbs position-relative">
                    <div class="offer-message style-two px-24 py-12 rounded-12 bg-white fw-medium flex-align d-inline-flex gap-16 box-shadow-lg animation-upDown">
                        <span class="flex-shrink-0 w-48 h-48 bg-dark-yellow text-white text-2xl flex-center rounded-circle">
                            <img src="{{ asset('assets/images/icons/stars.png') }}" alt="">
                        </span>
                        <div>
                            <span class="text-lg text-neutral-700 d-block">4.6 <span class="text-neutral-100">(2.4k)</span></span>
                            <span class="text-neutral-500">Avis Moyens</span>
                        </div>
                    </div>

                    <div class="text-end" data-aos="zoom-out">
                        <div class="d-sm-inline-block d-block position-relative">
                            <img src="{{ asset('assets/images/thumbs/choose-us-img2.jpg') }}" alt="" class="choose-us__img rounded-12" data-tilt data-tilt-max="16" data-tilt-speed="500" data-tilt-perspective="5000" data-tilt-full-page-listening>
                            <span class="shadow-main-two w-80 h-80 flex-center bg-main-two-600 rounded-circle position-absolute inset-block-start-0 inset-inline-start-0 mt-40 ms--40 animation-upDown">
                                <img src="{{ asset('assets/images/icons/book.png') }}" alt="">
                            </span>
                            <a href="https://www.youtube.com/watch?v=2tNKYy1ftb4" class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                                <i class="ph-fill ph-play"></i>
                            </a>
                        </div>
                    </div>
                    <!-- <div class="animation-video" data-aos="zoom-in">
                        <img src="{{ asset('assets/images/thumbs/choose-us-img2.jpg') }}" alt="" class="border border-white rounded-circle border-3" data-tilt>
                        <a href="https://www.youtube.com/watch?v=2tNKYy1ftb4" class="play-button w-48 h-48 flex-center bg-main-600 text-white rounded-circle text-xl position-absolute top-50 start-50 translate-middle">
                            <i class="ph-fill ph-play"></i>
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =========================== CHoose Us Section End ================================ -->

<!-- ========================== Counter Section start ============================== -->
<section class="counter py-120">
    <div class="container">
        <div class="row gy-4">
            <div class="col-xl-3 col-sm-6 col-xs-6" data-aos="fade-up" data-aos-duration="200">
                <div class="counter-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-25 border border-neutral-30">
                    <span class="w-80 h-80 flex-center d-inline-flex bg-white text-main-600 text-40 rounded-circle box-shadow-md mb-24">
                        <i class="animate__wobble ph ph-users"></i>
                    </span>
                    <h2 class="display-four mb-16 text-neutral-700 counter">1.6K</h2>
                    <span class="text-neutral-500 text-lg">Formés avec Succès</span>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-xs-6" data-aos="fade-up" data-aos-duration="400">
                <div class="counter-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-two-25 border border-neutral-30">
                    <span class="w-80 h-80 flex-center d-inline-flex bg-white text-main-two-600 text-40 rounded-circle box-shadow-md mb-24">
                        <i class="animate__wobble ph ph-video-camera"></i>
                    </span>
                    <h2 class="display-four mb-16 text-neutral-700 counter">16.5K</h2>
                    <span class="text-neutral-500 text-lg">Cours Complétés</span>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-xs-6" data-aos="fade-up" data-aos-duration="600">
                <div class="counter-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-25 border border-neutral-30">
                    <span class="w-80 h-80 flex-center d-inline-flex bg-white text-main-600 text-40 rounded-circle box-shadow-md mb-24">
                        <i class="animate__wobble ph ph-thumbs-up"></i>
                    </span>
                    <h2 class="display-four mb-16 text-neutral-700 counter">45.8K</h2>
                    <span class="text-neutral-500 text-lg">Taux de Satisfaction</span>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-xs-6" data-aos="fade-up" data-aos-duration="800">
                <div class="counter-item animation-item h-100 text-center px-16 py-32 rounded-12 bg-main-two-25 border border-neutral-30">
                    <span class="w-80 h-80 flex-center d-inline-flex bg-white text-main-two-600 text-40 rounded-circle box-shadow-md mb-24">
                        <i class="animate__wobble ph ph-users-three"></i>
                    </span>
                    <h2 class="display-four mb-16 text-neutral-700 counter">55.6K</h2>
                    <span class="text-neutral-500 text-lg">Communauté Étudiante</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ========================== Counter Section End ============================== -->

<!-- ================================= testimonials Section Start ========================================= -->
<section class="testimonials py-120 position-relative z-1 bg-main-25">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape six animation-scalation">
    <img src="{{ asset('assets/images/shapes/shape3.png') }}" alt="" class="shape four animation-rotation">
    
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-6">
                <div class="testimonials__thumbs-slider pe-lg-5 me-xxl-5">
                    <div class="testimonials__thumbs wow bounceIn" data-tilt data-tilt-max="15" data-tilt-speed="500" data-tilt-perspective="5000">
                        <img src="{{ asset('assets/images/thumbs/testimonial-img1.png') }}" alt="">
                    </div>
                    <div class="testimonials__thumbs wow bounceIn" data-tilt data-tilt-max="15" data-tilt-speed="500" data-tilt-perspective="5000">
                        <img src="{{ asset('assets/images/thumbs/testimonial-img2.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testimonials__content">
                    <div class="section-heading style-left">
                        <div class="flex-align gap-8 mb-16 wow bounceInDown">
                            <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                            <h5 class="text-main-600 mb-0">Ce que Disent Nos Étudiants</h5>
                        </div>
                        <h2 class="mb-24 wow bounceIn">Témoignages d'Apprenants Heureux d'ISTAPA</h2>
                        <p class="text-neutral-500 text-line-2 wow bounceInUp">Plus de 16 millions d'étudiants apprennent déjà sur la plateforme ISTAPA</p>
                    </div>

                    <div class="testimonials__slider">
                        @foreach($testimonials as $testimonial)

                            <div class="testimonials-item">
                                <ul class="flex-align gap-8 mb-16" data-aos="fade-left" data-aos-duration="800">
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
                                <p class="text-neutral-700" data-aos="fade-left" data-aos-duration="1200">
                                    "{{ $testimonial->content }}"
                                </p>
                                <h4 class="mt-48 mb-8" data-aos="fade-left">{{ $testimonial->author_name }}</h4>
                                <span class="text-neutral-700" data-aos="fade-left">{{ $testimonial->author_role ?? 'Étudiant' }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex-align gap-16 mt-40">
                        <button type="button" id="testimonials-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                            <i class="ph ph-caret-left"></i>
                        </button>
                        <button type="button" id="testimonials-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1 w-48 h-48">
                            <i class="ph ph-caret-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================= testimonials Section End ========================================= -->

<!-- ========================== Brand Section Start =========================== -->
<div class="brand wow fadeInUpBig" data-wow-duration="1s" data-wow-delay=".5s">
    <div class="container container--lg">
        <div class="brand-box py-80 px-16">
            <h5 class="mb-40 text-center text-neutral-500">ILS NOUS FONT CONFIANCE</h5>
            <div class="container">
                <div class="brand-slider">
                    <div class="brand-slider__item px-24">
                        <img src="{{ asset('assets/images/thumbs/Sharda-University-Logo-Vector.png') }}" alt="" />
                    </div>
                    <div class="brand-slider__item px-24">
                        <img src="{{ asset('assets/images/thumbs/cefprepa.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========================== Brand Section End =========================== -->

<!-- ================================= Certificate Section Start ================================= -->
<div class="certificate">
    <div class="container container--lg">
        <div class="certificate-box px-16 bg-main-600 rounded-16">
            <div class="container">
                <div class="position-relative py-80">
                    <div class="row align-items-center">
                        <div class="col-xl-6">
                            <div class="certificate__content">
                                <div class="flex-align gap-8 mb-16 wow bounceInDown">
                                    <span class="w-8 h-8 bg-white rounded-circle"></span>
                                    <h5 class="text-white mb-0">Obtenez un Certificat</h5>
                                </div>
                                <h2 class="text-white mb-40 fw-medium wow bounceIn">Obtenez un Certificat de Compétences de Qualité d'ISTAPA</h2>
                                <a href="#" class="btn btn-white rounded-pill flex-align d-inline-flex gap-8 hover-bg-main-800 wow bounceInUp">
                                    Commencer Maintenant
                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 d-xl-block d-none">
                            <div class="certificate__thumb" data-aos="fade-up-left">    
                                <img src="{{ asset('assets/images/thumbs/certificate-img.png') }}" alt="" data-tilt data-tilt-max="8" data-tilt-speed="500" data-tilt-perspective="5000">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ================================= Certificate Section End ================================= -->
@endsection