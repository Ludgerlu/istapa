@extends('layouts.app')

@section('title', 'ISTAPA - L\'Établissement')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">L'Établissement</h1>
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
                            <span class="text-main-two-600">L'Établissement</span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ================================ About Section Start ==================================== -->
<section class="about py-120 position-relative z-1">
    <div class="container">
        <div class="row gy-5 align-items-center">
            <div class="col-lg-6">
                <div class="about-thumbs">
                    <img src="https://istapa.com/wp-content/uploads/2025/06/457774318_122130731990331499_8404464423876650403_n-768x768.jpg" alt="ISTAPA Campus" class="rounded-12 w-100" data-tilt data-tilt-max="10">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="flex-align gap-8 mb-16">
                        <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                        <h5 class="text-main-600 mb-0">Notre Établissement</h5>
                    </div>
                    <h2 class="mb-24">Un Cadre d'Excellence pour la Formation Agro-Pastorale</h2>
                    <p class="text-neutral-500 mb-32">Situé à Ebogo 1 - Yaoundé, Cameroun, l'ISTAPA dispose d'infrastructures modernes adaptées à la formation pratique et théorique dans les domaines de l'agriculture, de l'élevage et de la transformation agroalimentaire.</p>
                    
                    <div class="row gy-4 mb-32">
                        <div class="col-sm-6">
                            <div class="flex-align gap-12">
                                <span class="w-48 h-48 bg-main-25 rounded-circle flex-center text-main-600 text-xl"><i class="ph-bold ph-building"></i></span>
                                <div>
                                    <h4 class="mb-0">5+</h4>
                                    <span class="text-neutral-500">Bâtiments Modernes</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="flex-align gap-12">
                                <span class="w-48 h-48 bg-main-25 rounded-circle flex-center text-main-600 text-xl"><i class="ph-bold ph-flask"></i></span>
                                <div>
                                    <h4 class="mb-0">8</h4>
                                    <span class="text-neutral-500">Laboratoires Spécialisés</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="flex-align gap-12">
                                <span class="w-48 h-48 bg-main-25 rounded-circle flex-center text-main-600 text-xl"><i class="ph-bold ph-user-switch"></i></span>
                                <div>
                                    <h4 class="mb-0">50+</h4>
                                    <span class="text-neutral-500">Enseignants Qualifiés</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="flex-align gap-12">
                                <span class="w-48 h-48 bg-main-25 rounded-circle flex-center text-main-600 text-xl"><i class="ph-bold ph-tree"></i></span>
                                <div>
                                    <h4 class="mb-0">10</h4>
                                    <span class="text-neutral-500">Hectares de Terrain Agricole</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admission') }}" class="btn btn-main rounded-pill flex-align gap-8">
                        Postuler Maintenant
                        <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ About Section End ==================================== -->

<!-- ================================ Facilities Section Start ==================================== -->
<section class="facilities py-120 bg-main-25">
    <div class="container">
        <div class="section-heading text-center mb-60">
            <h2 class="mb-24">Nos Infrastructures et Équipements</h2>
            <p class="text-neutral-500">Découvrez les installations modernes mises à disposition de nos étudiants</p>
        </div>
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
                <div class="facility-item text-center p-32 bg-white rounded-12 border border-neutral-30">
                    <span class="w-80 h-80 bg-main-25 rounded-circle flex-center text-main-600 text-40 mb-24"><i class="ph-bold ph-computer"></i></span>
                    <h4 class="mb-16">Salles Informatiques</h4>
                    <p class="text-neutral-500">Équipées d'ordinateurs modernes et de logiciels spécialisés</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="facility-item text-center p-32 bg-white rounded-12 border border-neutral-30">
                    <span class="w-80 h-80 bg-main-25 rounded-circle flex-center text-main-600 text-40 mb-24"><i class="ph-bold ph-microscope"></i></span>
                    <h4 class="mb-16">Laboratoires</h4>
                    <p class="text-neutral-500">Laboratoires de biologie, chimie et agroalimentaire</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="facility-item text-center p-32 bg-white rounded-12 border border-neutral-30">
                    <span class="w-80 h-80 bg-main-25 rounded-circle flex-center text-main-600 text-40 mb-24"><i class="ph-bold ph-farm"></i></span>
                    <h4 class="mb-16">Ferme Pédagogique</h4>
                    <p class="text-neutral-500">Espace dédié aux travaux pratiques sur le terrain</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="facility-item text-center p-32 bg-white rounded-12 border border-neutral-30">
                    <span class="w-80 h-80 bg-main-25 rounded-circle flex-center text-main-600 text-40 mb-24"><i class="ph-bold ph-book"></i></span>
                    <h4 class="mb-16">Salle de qualité</h4>
                    <p class="text-neutral-500">Fonds documentaire riche en sciences agricoles</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ Facilities Section End ==================================== -->
@endsection