@extends('layouts.app')

@section('title', 'ISTAPA - Détails du Blog')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Détails du Blog</h1>
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
                            <span class="text-main-two-600">Détails du Blog</span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ================================ Blog Details Section Start =================================== -->
<div class="blog-page-section py-120">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="bg-main-25 rounded-16 p-12 border border-neutral-30">
                    <div class="rounded-12 overflow-hidden position-relative">
                        <img src="{{ asset('assets/images/thumbs/blog-details-img.png') }}" alt="Course Image" class="rounded-12 cover-img transition-2">
                        <div class="position-absolute inset-inline-end-0 inset-block-end-0 me-16 mb-16 py-12 px-24 rounded-8 bg-main-two-600 text-white fw-medium">
                            <h3 class="mb-0 text-white fw-medium">21</h3>
                            DEC
                        </div>
                    </div>
                    <div class="pt-32 pb-24 px-16 position-relative">
                        <div class="flex-align gap-14 flex-wrap mb-20">
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-user-circle"></i></span>
                                <span class="text-neutral-500 text-lg">Par Admin</span>
                            </div>
                            <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph-bold ph-eye"></i></span>
                                <span class="text-neutral-500 text-lg">1.6k</span>
                            </div>
                            <span class="w-8 h-8 bg-neutral-100 rounded-circle"></span>
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 text-2xl d-flex"><i class="ph ph-chat-dots"></i></span>
                                <span class="text-neutral-500 text-lg">24</span>
                            </div>
                        </div>
                        <h2 class="mb-24">Top 10 des Conseils pour Réussir l'Apprentissage en Ligne</h2>
                        <p class="text-neutral-500 mb-32">Cet article de blog fournit des conseils pratiques et des stratégies pour aider les étudiants à réussir leur parcours d'apprentissage en ligne. Il couvre des aspects comme la gestion du temps, le maintien de la motivation et les techniques d'étude efficaces.</p>

                        <h6 class="mb-16 text-neutral-500 text-lg">Points Clés:</h6>
                        <ul class="list-dotted d-flex flex-column gap-8">
                            <li>Créez un espace d'étude dédié : Assurez-vous que votre espace d'étude est calme, bien éclairé et sans distractions.</li>
                            <li>Établissez une routine : Développez un horaire d'étude cohérent pour rester organisé et sur la bonne voie.</li>
                            <li>Restez organisé : Utilisez des planificateurs ou des outils numériques pour suivre les devoirs et les délais.</li>
                            <li>Participez activement : Engagez-vous dans les discussions en ligne, les forums et les projets de groupe pour améliorer l'apprentissage.</li>
                            <li>Faites des pauses : Évitez l'épuisement en prenant des pauses régulières et en prenant soin de vous.</li>
                            <li>Restez connecté : Communiquez régulièrement avec les instructeurs et les camarades de classe pour obtenir du soutien et de la collaboration.</li>
                            <li>Utilisez les ressources : Profitez des ressources disponibles comme les bibliothèques en ligne, les services de tutorat et les guides d'étude.</li>
                            <li>Pratiquez la gestion du temps : Priorisez les tâches et divisez les grands projets en morceaux gérables.</li>
                            <li>Restez motivé : Fixez-vous des objectifs personnels et récompensez-vous pour avoir atteint des jalons.</li>
                            <li>Recherchez des commentaires : Recherchez et appliquez activement les commentaires pour améliorer votre compréhension et vos performances.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="border border-neutral-30 rounded-12 bg-main-25 p-32 bg-main-25">
                    <h4 class="mb-16">Articles Similaires</h4> 
                    <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                    
                    @php
                        $relatedBlogs = [
                            ['id' => 1, 'img' => 'assets/images/thumbs/blog-two-img1.png', 'title' => 'Le Rôle de l\'Intelligence Émotionnelle', 'date' => '23/10/24'],
                            ['id' => 2, 'img' => 'assets/images/thumbs/blog-two-img2.png', 'title' => 'La Psychologie de l\'Apprentissage: Comment la Cognition', 'date' => '23/10/24'],
                            ['id' => 3, 'img' => 'assets/images/thumbs/blog-two-img3.png', 'title' => 'L\'Avenir du Travail à Distance: Tendances', 'date' => '23/10/24'],
                        ];
                    @endphp

                    @foreach($relatedBlogs as $blog)
                    <div class="flex-align gap-16 mb-24">
                        <a href="{{ route('blog.details', $blog['id']) }}" class="flex-shrink-0">
                            <img src="{{ asset($blog['img']) }}" alt="" class="w-80 h-80 rounded-8 object-fit-cover">
                        </a>
                        <div class="flex-grow-1">
                            <h6 class="text-xl mb-10">
                                <a href="{{ route('blog.details', $blog['id']) }}" class="hover-text-main-600 text-line-2">{{ $blog['title'] }}</a>
                            </h6>
                            <span class="text-neutral-500">{{ $blog['date'] }}</span>
                        </div>
                    </div>
                    <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                    @endforeach
                    
                    <a href="{{ route('blog') }}" class="h6 mb-0 text-main-600 fw-semibold hover-text-decoration-underline">
                        Voir Tous
                        <i class="ph-bold ph-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ================================ Blog Details Section End =================================== -->
@endsection