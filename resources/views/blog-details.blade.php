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
                <!-- Review Start -->
                <div class="border border-neutral-30 rounded-12 bg-main-25 p-32 mt-24">
                    <h5 class="mb-0">Average Reviews</h5>
                    <span class="d-block border border-neutral-30 my-32 border-dashed"></span>

                    <div class="d-flex flex-sm-row flex-column gap-36">
                        <div class="rounded-16 px-40 py-24 flex-center flex-column flex-shrink-0 text-center bg-main-600 text-white">
                            <h2 class="mb-8 text-white">4.8</h2>
                            <div class="flex-center gap-4">
                                <span class="text-15 fw-medium text-white d-flex"><i class="ph-fill ph-star"></i></span>
                                <span class="text-15 fw-medium text-white d-flex"><i class="ph-fill ph-star"></i></span>
                                <span class="text-15 fw-medium text-white d-flex"><i class="ph-fill ph-star"></i></span>
                                <span class="text-15 fw-medium text-white d-flex"><i class="ph-fill ph-star"></i></span>
                                <span class="text-15 fw-medium text-white d-flex"><i class="ph-fill ph-star-half"></i></span>
                            </div>
                            <span class="mt-8 text-gray-500">26 Rating</span>
                        </div>

                        <div class="flex-grow-1">
                            <div class="flex-align gap-20 mb-8">
                                <div class="flex-align gap-8">
                                    <span class="text-lg fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                    <span class="text-gray-900 flex-shrink-0">5</span>
                                </div>
                                <div class="progress w-100 bg-white rounded-pill h-12" role="progressbar" aria-label="Basic example" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-main-600 rounded-pill" style="width: 90%"></div>
                                </div>
                                <span class="text-gray-900 flex-shrink-0">90%</span>
                            </div>
                            <div class="flex-align gap-20 mb-8">
                                <div class="flex-align gap-8">
                                    <span class="text-lg fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                    <span class="text-gray-900 flex-shrink-0">5</span>
                                </div>
                                <div class="progress w-100 bg-white rounded-pill h-12" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-main-600 rounded-pill" style="width: 75%"></div>
                                </div>
                                <span class="text-gray-900 flex-shrink-0">75%</span>
                            </div>
                            <div class="flex-align gap-20 mb-8">
                                <div class="flex-align gap-8">
                                    <span class="text-lg fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                    <span class="text-gray-900 flex-shrink-0">5</span>
                                </div>
                                <div class="progress w-100 bg-white rounded-pill h-12" role="progressbar" aria-label="Basic example" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-main-600 rounded-pill" style="width: 67%"></div>
                                </div>
                                <span class="text-gray-900 flex-shrink-0">67%</span>
                            </div>
                            <div class="flex-align gap-20 mb-8">
                                <div class="flex-align gap-8">
                                    <span class="text-lg fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                    <span class="text-gray-900 flex-shrink-0">5</span>
                                </div>
                                <div class="progress w-100 bg-white rounded-pill h-12" role="progressbar" aria-label="Basic example" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-main-600 rounded-pill" style="width: 44%"></div>
                                </div>
                                <span class="text-gray-900 flex-shrink-0">44%</span>
                            </div>
                            <div class="flex-align gap-20">
                                <div class="flex-align gap-8">
                                    <span class="text-lg fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                    <span class="text-gray-900 flex-shrink-0">5</span>
                                </div>
                                <div class="progress w-100 bg-white rounded-pill h-12" role="progressbar" aria-label="Basic example" aria-valuenow="21" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-main-600 rounded-pill" style="width: 21%"></div>
                                </div>
                                <span class="text-gray-900 flex-shrink-0">21%</span>
                            </div>
                        </div>
                    </div>
                    <span class="d-block border border-neutral-30 my-32 border-dashed"></span>
                    <div class="flex-between gap-16 flex-wrap mb-24">
                        <h6 class="mb-0">All Reviews</h6>
                        <div class="flex-align gap-16">
                            <div class="flex-align gap-8">
                                <span class="text-neutral-500 flex-shrink-0">Sort By :</span>
                                <select class="form-select ps-20 pe-28 py-8 fw-medium rounded-pill bg-main-25 border border-neutral-30 text-neutral-700">
                                    <option value="1">Newest</option>
                                    <option value="1">Trending</option>
                                    <option value="1">Popular</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Review Item -->
                    <div class="border border-neutral-30 rounded-12 bg-white p-32">
                        <div class="flex-align gap-8 mb-16">
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star-half"></i></span>
                        </div>
                        <p class="text-neutral-700">"This course was fantastic! The instructor's explanations were clear and concise, making it easy to understand even the more complex topics."</p>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                        <div class="flex-align gap-24">
                            <img src="assets/images/thumbs/reviewer-img1.png" alt="" class="w-60 h-60 rounded-circle cover-img">
                            <div class="">
                                <h6 class="text-xl mb-8 fw-medium">Mary Johnson</h6>
                                <span class="text-neutral-700 text-sm">Project Manager</span>
                            </div>
                        </div>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>

                        <div class="flex-align flex-wrap gap-40">
                            <button type="button" class="like-button flex-align gap-8 text-neutral-500 hover-text-main-600">
                                <span class="like-button__icon text-xl d-flex"><i class="ph-bold ph-thumbs-up"></i></span>
                                <span class="like-button__text">178</span>
                            </button>
                            <a href="#commentForm" class="flex-align gap-8 text-neutral-500 hover-text-main-600">
                                <i class="text-xl d-flex ph-bold ph-chat-centered-text"></i>
                                Reply
                            </a>
                        </div>
                        <div class="flex-align gap-20 mt-24">
                            <img src="assets/images/thumbs/reviewer-img2.png" alt="" class="w-60 h-60 rounded-circle cover-img">
                            <input type="text" class="common-input rounded-pill bg-main-25 border-neutral-30 py-16" placeholder="Join the discussion...">
                        </div>
                    </div>
                    <!-- Review Item -->

                    <!-- Review Item -->
                    <div class="border border-neutral-30 rounded-12 bg-white p-32 mt-24">
                        <div class="flex-align gap-8 mb-16">
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star-half"></i></span>
                        </div>
                        <p class="text-neutral-700">"Great course for beginners and advanced learners alike. The projects were particularly helpful in applying what I learned. Highly recommend!"</p>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                        <div class="flex-align gap-24">
                            <img src="assets/images/thumbs/reviewer-img2.png" alt="" class="w-60 h-60 rounded-circle cover-img">
                            <div class="">
                                <h6 class="text-xl mb-8 fw-medium">Alice Brown</h6>
                                <span class="text-neutral-700 text-sm">Software Developer</span>
                            </div>
                        </div>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>

                        <div class="flex-align flex-wrap gap-40">
                            <button type="button" class="like-button flex-align gap-8 text-neutral-500 hover-text-main-600">
                                <span class="like-button__icon text-xl d-flex"><i class="ph-bold ph-thumbs-up"></i></span>
                                <span class="like-button__text">178</span>
                            </button>
                            <a href="#commentForm" class="flex-align gap-8 text-neutral-500 hover-text-main-600">
                                <i class="text-xl d-flex ph-bold ph-chat-centered-text"></i>
                                Reply
                            </a>
                        </div>
                    </div>
                    <!-- Review Item -->

                    <!-- Review Item -->
                    <div class="border border-neutral-30 rounded-12 bg-white p-32 mt-24">
                        <div class="flex-align gap-8 mb-16">
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                            <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star-half"></i></span>
                        </div>
                        <p class="text-neutral-700">"Dr. Smith is an amazing instructor. Her real-world experience and teaching style made this course one of the best I've ever taken."</p>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>
                        <div class="flex-align gap-24">
                            <img src="assets/images/thumbs/reviewer-img3.png" alt="" class="w-60 h-60 rounded-circle cover-img">
                            <div class="">
                                <h6 class="text-xl mb-8 fw-medium">David Wilson</h6>
                                <span class="text-neutral-700 text-sm">Ethical Hacker</span>
                            </div>
                        </div>
                        <span class="d-block border border-neutral-30 my-24 border-dashed"></span>

                        <div class="flex-align flex-wrap gap-40">
                            <button type="button" class="like-button flex-align gap-8 text-neutral-500 hover-text-main-600">
                                <span class="like-button__icon text-xl d-flex"><i class="ph-bold ph-thumbs-up"></i></span>
                                <span class="like-button__text">178</span>
                            </button>
                            <a href="#commentForm" class="flex-align gap-8 text-neutral-500 hover-text-main-600">
                                <i class="text-xl d-flex ph-bold ph-chat-centered-text"></i>
                                Reply
                            </a>
                        </div>
                    </div>
                    <!-- Review Item -->

                    <button type="button" class="btn btn-main rounded-pill flex-center gap-8 mt-40">
                        See All Reviews
                        <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                    </button>
                </div>
                <!-- Review End -->

                <!-- Review Form Start -->
                <div class="border border-neutral-30 rounded-12 bg-main-25 p-32 mt-24">
                    <form action="#" id="commentForm">
                        <h5 class="mb-0">Write a Review</h5>
                        <span class="d-block border border-neutral-30 my-32 border-dashed"></span>
                        <div class="mb-24">
                            <label for="name" class="text-neutral-700 text-lg fw-medium mb-12">Name </label>
                            <input type="text" class="common-input rounded-pill" id="name" placeholder="Enter Name...">
                        </div>
                        <div class="mb-24">
                            <label for="email" class="text-neutral-700 text-lg fw-medium mb-12">Email </label>
                            <input type="email" class="common-input rounded-pill" id="email" placeholder="Enter Email...">
                        </div>
                        <div class="mb-24">
                            <label class="text-neutral-700 text-lg fw-medium mb-12">Star Reviews </label>
                            
                            <div id="half-star-rating">
                                <div class="rating-group">
                                    <input class="rating__input rating__input--none" checked name="rating2" id="rating2-0" value="0" type="radio">
                                    <label aria-label="0 stars" class="rating__label" for="rating2-0">&nbsp;</label>
                                    <label aria-label="0.5 stars" class="rating__label rating__label--half" for="rating2-05"><i class="rating__icon rating__icon--star ph-fill ph-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-05" value="0.5" type="radio">
                                    <label aria-label="1 star" class="rating__label" for="rating2-10"><i class="rating__icon rating__icon--star ph-fill ph-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-10" value="1" type="radio">
                                    <label aria-label="1.5 stars" class="rating__label rating__label--half" for="rating2-15"><i class="rating__icon rating__icon--star ph-fill ph-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-15" value="1.5" type="radio">
                                    <label aria-label="2 stars" class="rating__label" for="rating2-20"><i class="rating__icon rating__icon--star ph-fill ph-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-20" value="2" type="radio">
                                    <label aria-label="2.5 stars" class="rating__label rating__label--half" for="rating2-25"><i class="rating__icon rating__icon--star ph-fill ph-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-25" value="2.5" type="radio" checked>
                                    <label aria-label="3 stars" class="rating__label" for="rating2-30"><i class="rating__icon rating__icon--star ph-fill ph-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-30" value="3" type="radio">
                                    <label aria-label="3.5 stars" class="rating__label rating__label--half" for="rating2-35"><i class="rating__icon rating__icon--star ph-fill ph-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-35" value="3.5" type="radio">
                                    <label aria-label="4 stars" class="rating__label" for="rating2-40"><i class="rating__icon rating__icon--star ph-fill ph-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-40" value="4" type="radio">
                                    <label aria-label="4.5 stars" class="rating__label rating__label--half" for="rating2-45"><i class="rating__icon rating__icon--star ph-fill ph-star-half"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-45" value="4.5" type="radio">
                                    <label aria-label="5 stars" class="rating__label" for="rating2-50"><i class="rating__icon rating__icon--star ph-fill ph-star"></i></label>
                                    <input class="rating__input" name="rating2" id="rating2-50" value="5" type="radio">
                                </div>
                            </div>

                        </div>
                        <div class="mb-24">
                            <label for="desc" class="text-neutral-700 text-lg fw-medium mb-12">Your Question </label>
                            <textarea id="desc" class="common-input rounded-24" placeholder="Write you question..."></textarea>
                        </div>
                        <div class="mb-0">
                            <button type="submit" class="btn btn-main rounded-pill flex-center gap-8 mt-40">
                                Submit Review
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Review Form End -->
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