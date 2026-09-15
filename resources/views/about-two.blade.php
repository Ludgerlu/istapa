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
                    <img src="{{ asset('assets/images/thumbs/about-7.jpg') }}" alt="ISTAPA Campus" class="rounded-12 w-100 h-100" data-tilt data-tilt-max="10">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="flex-align gap-8 mb-16">
                        <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                        <h5 class="text-main-600 mb-0">Notre Établissement</h5>
                    </div>
                    <h2 class="mb-24">Un Cadre d'Excellence pour la Formation Agro-Pastorale</h2>
                    <p class="text-neutral-500 mb-32">Situé sur la route de Soa, au lieu-dit Ebogo 1 - Entrée ISTAPA, après Radio Bonne Nouvelle (Yaoundé, Cameroun), l'ISTAPA est un institut qui promeut la vulgarisation et la transformation des secteurs verts en secteurs modernes, technologiques et hautement rentables. Conscients qu'après le Baccalauréat chaque jeune réfléchit à son orientation professionnelle et au besoin de garantir un emploi stable et décent, nous façonnons l'avenir des jeunes bacheliers d'aujourd'hui en les immergeant dans un environnement de formation de pointe qui allie théorie et pratique sur site, dans des filières telles que l'agriculture, l'élevage, les énergies renouvelables, la gestion forestière et la gestion environnementale.</p>
                    
                    <div class="row gy-4 mb-32">
                        <div class="col-sm-6">
                            <div class="flex-align gap-12">
                                <span class="w-48 h-48 bg-main-25 rounded-circle flex-center text-main-600 text-xl"><i class="ph-bold ph-building"></i></span>
                                <div>
                                    <!-- <h4 class="mb-0">5+</h4> -->
                                    <span class="text-neutral-500">Bâtiments Modernes</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="flex-align gap-12">
                                <span class="w-48 h-48 bg-main-25 rounded-circle flex-center text-main-600 text-xl"><i class="ph-bold ph-flask"></i></span>
                                <div>
                                    <!-- <h4 class="mb-0">8</h4> -->
                                    <span class="text-neutral-500">Laboratoires Spécialisés</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="flex-align gap-12">
                                <span class="w-48 h-48 bg-main-25 rounded-circle flex-center text-main-600 text-xl"><i class="ph-bold ph-user-switch"></i></span>
                                <div>
                                    <!-- <h4 class="mb-0">50+</h4> -->
                                    <span class="text-neutral-500">Enseignants Qualifiés</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="flex-align gap-12">
                                <span class="w-48 h-48 bg-main-25 rounded-circle flex-center text-main-600 text-xl"><i class="ph-bold ph-tree"></i></span>
                                <div>
                                    <!-- <h4 class="mb-0">10</h4> -->
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

<!-- ================================ Cycles Section Start ==================================== -->
<section class="cycles py-120 position-relative z-1">
    <div class="container">
        <div class="section-heading text-center mb-60">
            <div class="flex-align gap-8 mb-16 justify-content-center">
                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                <h5 class="text-main-600 mb-0">Nos Cycles de Formation</h5>
            </div>
            <h2 class="mb-24">Du BTS/HND à la Licence et au Master Professionnels</h2>
            <p class="text-neutral-500">Nos formations vont du cycle <strong>BTS/HND</strong> au cycle <strong>Licence et Master Professionnels</strong></p>
        </div>
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="facility-item p-32 bg-white rounded-12 border border-neutral-30 h-100">
                    <span class="w-80 h-80 bg-main-25 rounded-circle flex-center text-main-600 text-40 mb-24"><i class="ph-bold ph-student"></i></span>
                    <h4 class="mb-16">Niveaux 1 et 2 — BTS / HND</h4>
                    <p class="text-neutral-500 mb-8"><i class="ph-bold ph-clock text-main-600"></i> Niveau 1 : du lundi au vendredi, de 8h à 16h</p>
                    <p class="text-neutral-500">Niveau 2 : du lundi au samedi, de 8h à 16h</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="facility-item p-32 bg-white rounded-12 border border-neutral-30 h-100">
                    <span class="w-80 h-80 bg-main-two-25 rounded-circle flex-center text-main-two-600 text-40 mb-24"><i class="ph-bold ph-graduation-cap"></i></span>
                    <h4 class="mb-16">Niveaux 3, 4 et 5 — Licence / Master</h4>
                    <p class="text-neutral-500 mb-8"><i class="ph-bold ph-clock text-main-two-600"></i> En semaine : cours du soir, de 16h à 21h</p>
                    <p class="text-neutral-500">Samedi : de 8h à 14h</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ Cycles Section End ==================================== -->

<!-- ================================ Filières Section Start ==================================== -->
<section class="filieres py-120 bg-main-25 position-relative z-1">
    <div class="container">
        <div class="section-heading text-center mb-60">
            <div class="flex-align gap-8 mb-16 justify-content-center">
                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                <h5 class="text-main-600 mb-0">Nos Filières</h5>
            </div>
            <h2 class="mb-24">Filières Autorisées par le MINESUP</h2>
            <p class="text-neutral-500">Autorisation N° 24-01870/NHA/MINESUP/DDES/ESUP/SDA/MF du 06 Mars 2024</p>
        </div>
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="facility-item p-32 bg-white rounded-12 border border-neutral-30 h-100">
                    <span class="w-64 h-64 bg-main-25 rounded-circle flex-center text-main-600 text-32 mb-24"><i class="ph-bold ph-certificate"></i></span>
                    <h4 class="mb-20">Cycle BTS</h4>
                    <ul>
                        <li class="flex-align gap-12 mb-12">
                            <span class="flex-shrink-0 text-lg text-main-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Agriculture et Élevage</span>
                        </li>
                        <li class="flex-align gap-12 mb-12">
                            <span class="flex-shrink-0 text-lg text-main-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Génie Électrique</span>
                        </li>
                        <li class="flex-align gap-12 mb-0">
                            <span class="flex-shrink-0 text-lg text-main-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Sciences Environnementales</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="facility-item p-32 bg-white rounded-12 border border-neutral-30 h-100">
                    <span class="w-64 h-64 bg-main-two-25 rounded-circle flex-center text-main-two-600 text-32 mb-24"><i class="ph-bold ph-certificate"></i></span>
                    <h4 class="mb-20">Cycle HND</h4>
                    <ul>
                        <li class="flex-align gap-12 mb-12">
                            <span class="flex-shrink-0 text-lg text-main-two-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Agriculture and Food Sciences</span>
                        </li>
                        <li class="flex-align gap-12 mb-12">
                            <span class="flex-shrink-0 text-lg text-main-two-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Environmental Sciences</span>
                        </li>
                        <li class="flex-align gap-12 mb-0">
                            <span class="flex-shrink-0 text-lg text-main-two-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Thermal and Energy Engineering</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="facility-item p-32 bg-white rounded-12 border border-neutral-30 h-100">
                    <span class="w-64 h-64 bg-main-25 rounded-circle flex-center text-main-600 text-32 mb-24"><i class="ph-bold ph-certificate"></i></span>
                    <h4 class="mb-20">Cycle Licence et Master</h4>
                    <ul>
                        <li class="flex-align gap-12 mb-12">
                            <span class="flex-shrink-0 text-lg text-main-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Génie Énergétique</span>
                        </li>
                        <li class="flex-align gap-12 mb-12">
                            <span class="flex-shrink-0 text-lg text-main-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Production Végétale</span>
                        </li>
                        <li class="flex-align gap-12 mb-12">
                            <span class="flex-shrink-0 text-lg text-main-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Production Animale</span>
                        </li>
                        <li class="flex-align gap-12 mb-12">
                            <span class="flex-shrink-0 text-lg text-main-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Aménagement Forestier, Gestion de la Faune, des Aires Protégées et Écotourisme, Sylviculture et Plantation Forestière</span>
                        </li>
                        <li class="flex-align gap-12 mb-0">
                            <span class="flex-shrink-0 text-lg text-main-600 d-flex"><i class="ph-bold ph-check-circle"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Gestion Environnementale</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ Filières Section End ==================================== -->

<!-- ================================ Facilities Section Start ==================================== -->
<section class="facilities py-120 position-relative z-1">
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

<!-- ================================ Particularités Section Start ==================================== -->
<section class="particularites py-120 bg-main-25 position-relative z-1">
    <div class="container">
        <div class="section-heading text-center mb-60">
            <div class="flex-align gap-8 mb-16 justify-content-center">
                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                <h5 class="text-main-600 mb-0">Nos Particularités</h5>
            </div>
            <h2 class="mb-24">Ce Qui Distingue la Formation ISTAPA</h2>
            <p class="text-neutral-500">Plus de 10 ateliers innovants et un accompagnement pensé pour la réussite de chaque étudiant</p>
        </div>
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="p-32 bg-white rounded-12 border border-neutral-30 h-100">
                    <h4 class="mb-20">Ateliers Innovants sur le Campus</h4>
                    <ul>
                        <li class="flex-align gap-12 mb-16">
                            <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Pisciculture 2.0 et pisciculture avec système RAS</span>
                        </li>
                        <li class="flex-align gap-12 mb-16">
                            <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Atelier d'énergies renouvelables (solaire, éolienne, biogaz) et irrigation solaire</span>
                        </li>
                        <li class="flex-align gap-12 mb-16">
                            <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Culture sous serre et fourrage vert hydroponique</span>
                        </li>
                        <li class="flex-align gap-12 mb-0">
                            <span class="flex-shrink-0 text-xl text-main-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Élevage d'animaux non conventionnels (hannetons, escargots, larves de mouches soldats noirs), poulailler, porcs, lapins, basse-cour</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-32 bg-white rounded-12 border border-neutral-30 h-100">
                    <h4 class="mb-20">Accompagnement des Étudiants</h4>
                    <ul>
                        <li class="flex-align gap-12 mb-16">
                            <span class="flex-shrink-0 text-xl text-main-two-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Formation qui allie théorie et pratique, avec professionnalisation des enseignements</span>
                        </li>
                        <li class="flex-align gap-12 mb-16">
                            <span class="flex-shrink-0 text-xl text-main-two-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Formations gratuites aux AGR pour permettre aux étudiants d'être financièrement autonomes</span>
                        </li>
                        <li class="flex-align gap-12 mb-16">
                            <span class="flex-shrink-0 text-xl text-main-two-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Identification des lieux de stage selon le projet professionnel de chaque étudiant</span>
                        </li>
                        <li class="flex-align gap-12 mb-16">
                            <span class="flex-shrink-0 text-xl text-main-two-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Un jour de travaux pratiques par semaine, excursions et immersion annuelle en entreprise</span>
                        </li>
                        <li class="flex-align gap-12 mb-0">
                            <span class="flex-shrink-0 text-xl text-main-two-600 d-flex"><i class="ph-bold ph-checks"></i></span>
                            <span class="flex-grow-1 text-neutral-500">Salle informatique et multimédia, infirmerie, laboratoire, bibliothèque, aire de jeux et parcelles d'essai</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ Particularités Section End ==================================== -->

<!-- ================================ Vie Étudiante Section Start ==================================== -->
<section class="student-life py-120 position-relative z-1">
    <div class="container">
        <div class="row gy-5 align-items-center">
            <div class="col-lg-6">
                <div class="about-thumbs">
                    <img src="{{ asset('assets/images/thumbs/testimonial-img2.png') }}" alt="Vie étudiante à ISTAPA" class="rounded-12 w-100">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="flex-align gap-8 mb-16">
                    <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                    <h5 class="text-main-600 mb-0">Vie Étudiante</h5>
                </div>
                <h2 class="mb-24">Vivre Ensemble et Se Construire un Réseau Professionnel</h2>

                <div class="flex-align align-items-start gap-28 mb-32">
                    <span class="w-80 h-80 bg-main-25 rounded-circle flex-center text-main-600 text-xl flex-shrink-0"><i class="ph-bold ph-users-three"></i></span>
                    <div class="flex-grow-1">
                        <h4 class="text-neutral-500 mb-12">Délégation des Étudiants</h4>
                        <p class="text-neutral-500">Une entité qui permet aux étudiants de s'intégrer dans les activités extra-académiques de l'école, activités portées et gérées par les étudiants eux-mêmes, sous la supervision du staff administratif.</p>
                    </div>
                </div>

                <div class="flex-align align-items-start gap-28 mb-0">
                    <span class="w-80 h-80 bg-main-25 rounded-circle flex-center text-main-600 text-xl flex-shrink-0"><i class="ph-bold ph-handshake"></i></span>
                    <div class="flex-grow-1">
                        <h4 class="text-neutral-500 mb-12">Cérémonie de Parrainage</h4>
                        <p class="text-neutral-500">Chaque année, ISTAPA met en contact ses étudiants avec des professionnels de différents domaines d'activité, invités à participer à des conférences, ateliers, échanges et partages d'expérience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ Vie Étudiante Section End ==================================== -->

<!-- ================================ Tutelle Section Start ==================================== -->
<section class="tutelle py-120 bg-main-25 position-relative z-1">
    <div class="container">
        <div class="section-heading text-center mb-60">
            <div class="flex-align gap-8 mb-16 justify-content-center">
                <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                <h5 class="text-main-600 mb-0">Tutelle Académique &amp; Partenariats</h5>
            </div>
            <h2 class="mb-24">Une Reconnaissance Académique Nationale et Internationale</h2>
        </div>
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="p-32 bg-white rounded-12 border border-neutral-30 h-100 text-center">
                    <img src="{{ asset('assets/images/thumbs/logo-isabee.jpg') }}" alt="ISABEE - Université de Bertoua" class="mb-24" style="max-height:64px;">
                    <h4 class="mb-16">Tutelle Académique</h4>
                    <p class="text-neutral-500 mb-0">Tutelle académique en cours avec l'Université de Bertoua, notamment à travers l'Institut Supérieur d'Agriculture, du Bois, de l'Eau et de l'Environnement (ISABEE).</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-32 bg-white rounded-12 border border-neutral-30 h-100 text-center">
                    <img src="{{ asset('assets/images/thumbs/Sharda-University-Logo-Vector.png') }}" alt="Sharda University" class="mb-24" style="max-height:64px;">
                    <h4 class="mb-16">Partenariat International</h4>
                    <p class="text-neutral-500 mb-0">Partenariat en cours avec Sharda University, en Inde.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ Tutelle Section End ==================================== -->
@endsection