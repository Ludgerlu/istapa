@extends('layouts.app')

@section('title', 'ISTAPA - Admission')

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
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Formulaire d'Admission</h1>
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
                            <span class="text-main-two-600">Admission</span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ================================ Apply For Admission Section Start =================================== -->
<section class="py-120">
    <div class="container">
        <div class="section-heading text-center mb-60">
            <div class="flex-align d-inline-flex gap-8 mb-16">
                <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-graduation-cap"></i></span>
                <h5 class="text-main-600 mb-0">Rejoignez ISTAPA</h5>
            </div>
            <h2 class="mb-24">Inscrivez-vous dès Maintenant</h2>
            <p class="text-neutral-500">Remplissez le formulaire ci-dessous pour postuler à nos programmes de formation</p>
        </div>

        <div class="border border-neutral-30 rounded-12 bg-main-25 p-24">
            <form action="#" method="POST" id="admissionForm">
                @csrf
                <h3 class="mb-24">Formulaire de Candidature</h3> 

                <!-- Personal information Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24">
                    <h5 class="mb-0">Informations Personnelles</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label for="name" class="text-neutral-700 text-lg fw-medium mb-12">Nom complet <span class="text-danger-600">*</span> </label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="name" name="name" placeholder="Entrez votre nom...">
                        </div>
                        <div class="col-sm-6">
                            <label for="email" class="text-neutral-700 text-lg fw-medium mb-12">Email <span class="text-danger-600">*</span> </label>
                            <input type="email" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="email" name="email" placeholder="Entrez votre email...">
                        </div>
                        <div class="col-sm-6">
                            <label for="phone" class="text-neutral-700 text-lg fw-medium mb-12">Téléphone <span class="text-danger-600">*</span> </label>
                            <input type="tel" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="phone" name="phone" placeholder="Entrez votre numéro...">
                        </div>
                        <div class="col-sm-6">
                            <label for="dateBirth" class="text-neutral-700 text-lg fw-medium mb-12">Date de naissance <span class="text-danger-600">*</span> </label>
                            <input type="date" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="dateBirth" name="date_birth">
                        </div>
                        <div class="col-sm-12">
                            <label class="text-neutral-700 text-lg fw-medium mb-12">Genre <span class="text-danger-600">*</span> </label>
                            <div class="flex-align gap-24">
                                <div class="form-check common-check common-radio mb-0">
                                    <input class="form-check-input" type="radio" name="gender" id="Male" value="male">
                                    <label class="form-check-label fw-normal flex-grow-1" for="Male">Masculin</label>
                                </div>
                                <div class="form-check common-check common-radio mb-0">
                                    <input class="form-check-input" type="radio" name="gender" id="Female" value="female">
                                    <label class="form-check-label fw-normal flex-grow-1" for="Female">Féminin</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="selectCountry" class="text-neutral-700 text-lg fw-medium mb-12">Pays <span class="text-danger-600">*</span> </label>
                            <select class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600 form-select py-14" id="selectCountry" name="country">
                                <option value="">Sélectionnez votre pays</option>
                                <option value="CM">Cameroun</option>
                                <option value="CI">Côte d'Ivoire</option>
                                <option value="SN">Sénégal</option>
                                <option value="ML">Mali</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="GA">Gabon</option>
                                <option value="CG">Congo</option>
                                <option value="CD">RDC</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="selectCity" class="text-neutral-700 text-lg fw-medium mb-12">Ville <span class="text-danger-600">*</span> </label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="selectCity" name="city" placeholder="Entrez votre ville">
                        </div>
                        <div class="col-sm-12">
                            <label for="address" class="text-neutral-700 text-lg fw-medium mb-12">Adresse complète </label>
                            <textarea class="common-input bg-main-25 rounded-24 border-transparent focus-border-main-600" id="address" name="address" rows="3" placeholder="Entrez votre adresse..."></textarea>
                        </div>
                    </div>
                </div>
                <!-- Personal information End -->

                <!-- Program Selection Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Programme choisi</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <label for="program" class="text-neutral-700 text-lg fw-medium mb-12">Filière de formation <span class="text-danger-600">*</span> </label>
                            <select class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600 form-select py-14" id="program" name="program">
                                <option value="">Sélectionnez votre programme</option>
                                <option value="agro">Techniques Agro-Pastorales</option>
                                <option value="agroalimentaire">Transformation Agroalimentaire</option>
                                <option value="elevage">Élevage et Santé Animale</option>
                                <option value="agriculture">Agriculture Durable</option>
                                <option value="gestion">Gestion des Ressources Naturelles</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="preferredStart" class="text-neutral-700 text-lg fw-medium mb-12">Date de début souhaitée <span class="text-danger-600">*</span> </label>
                            <input type="date" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="preferredStart" name="preferred_start">
                        </div>
                        <div class="col-sm-6">
                            <label for="hearAbout" class="text-neutral-700 text-lg fw-medium mb-12">Comment avez-vous connu ISTAPA ? <span class="text-danger-600">*</span> </label>
                            <select class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600 form-select py-14" id="hearAbout" name="hear_about">
                                <option value="">Sélectionnez</option>
                                <option value="internet">Internet / Réseaux sociaux</option>
                                <option value="friend">Recommandation d'un ami</option>
                                <option value="radio">Radio / Télévision</option>
                                <option value="school">Établissement scolaire</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Program Selection End -->

                <!-- Parent detail Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Informations du tuteur / parent</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label for="parentName" class="text-neutral-700 text-lg fw-medium mb-12">Nom du parent/tuteur <span class="text-danger-600">*</span> </label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="parentName" name="parent_name" placeholder="Entrez le nom...">
                        </div>
                        <div class="col-sm-6">
                            <label for="parentPhone" class="text-neutral-700 text-lg fw-medium mb-12">Téléphone <span class="text-danger-600">*</span> </label>
                            <input type="tel" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="parentPhone" name="parent_phone" placeholder="Entrez le numéro...">
                        </div>
                        <div class="col-sm-6">
                            <label for="parentEmail" class="text-neutral-700 text-lg fw-medium mb-12">Email <span class="text-danger-600">*</span> </label>
                            <input type="email" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="parentEmail" name="parent_email" placeholder="Entrez l'email...">
                        </div>
                        <div class="col-sm-6">
                            <label for="relation" class="text-neutral-700 text-lg fw-medium mb-12">Lien de parenté <span class="text-danger-600">*</span> </label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="relation" name="relation" placeholder="Ex: Père, Mère, Tuteur...">
                        </div>
                    </div>
                </div>
                <!-- Parent detail End -->

                <!-- Previous Education Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Formation antérieure</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label for="lastSchool" class="text-neutral-700 text-lg fw-medium mb-12">Dernier établissement fréquenté <span class="text-danger-600">*</span> </label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="lastSchool" name="last_school" placeholder="Nom de l'établissement">
                        </div>
                        <div class="col-sm-6">
                            <label for="diploma" class="text-neutral-700 text-lg fw-medium mb-12">Diplôme obtenu <span class="text-danger-600">*</span> </label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="diploma" name="diploma" placeholder="Ex: BAC, BEPC, Probatoire...">
                        </div>
                        <div class="col-sm-6">
                            <label for="passYear" class="text-neutral-700 text-lg fw-medium mb-12">Année d'obtention <span class="text-danger-600">*</span> </label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="passYear" name="pass_year" placeholder="Ex: 2024">
                        </div>
                        <div class="col-sm-6">
                            <label for="average" class="text-neutral-700 text-lg fw-medium mb-12">Moyenne / Mention </label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="average" name="average" placeholder="Ex: 14/20, Bien...">
                        </div>
                    </div>
                </div>
                <!-- Previous Education End -->

                <!-- Documents Upload Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Documents à joindre</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label for="cv" class="text-neutral-700 text-lg fw-medium mb-12">CV / Curriculum Vitae </label>
                            <input type="file" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="cv" name="cv">
                            <small class="text-neutral-500">Format: PDF, DOC (Max 5MB)</small>
                        </div>
                        <div class="col-sm-6">
                            <label for="diplomaFile" class="text-neutral-700 text-lg fw-medium mb-12">Copie du diplôme </label>
                            <input type="file" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="diplomaFile" name="diploma_file">
                            <small class="text-neutral-500">Format: PDF, JPG (Max 5MB)</small>
                        </div>
                        <div class="col-sm-6">
                            <label for="idFile" class="text-neutral-700 text-lg fw-medium mb-12">Pièce d'identité </label>
                            <input type="file" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="idFile" name="id_file">
                            <small class="text-neutral-500">Format: PDF, JPG (Max 5MB)</small>
                        </div>
                        <div class="col-sm-6">
                            <label for="photo" class="text-neutral-700 text-lg fw-medium mb-12">Photo d'identité </label>
                            <input type="file" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="photo" name="photo">
                            <small class="text-neutral-500">Format: JPG, PNG (Max 2MB)</small>
                        </div>
                    </div>
                </div>
                <!-- Documents Upload End -->

                <!-- Additional Info Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Informations complémentaires</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <label for="motivation" class="text-neutral-700 text-lg fw-medium mb-12">Lettre de motivation </label>
                            <textarea class="common-input bg-main-25 rounded-24 border-transparent focus-border-main-600" id="motivation" name="motivation" rows="4" placeholder="Dites-nous pourquoi vous souhaitez rejoindre ISTAPA..."></textarea>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check common-check mb-0">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label fw-normal" for="terms">
                                    J'accepte les <a href="#" class="text-main-600">conditions générales</a> et confirme que les informations fournies sont exactes.
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-main rounded-pill flex-center gap-8 mt-16">
                                Soumettre ma candidature
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Additional Info End -->
            </form>
        </div>
    </div>
</section>
<!-- ================================ Apply For Admission Section End =================================== -->

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
                                    <h5 class="text-white mb-0">Besoin d'aide ?</h5>
                                </div>
                                <h2 class="text-white mb-40 fw-medium wow bounceIn">Notre équipe est à votre disposition</h2>
                                <a href="{{ route('contact') }}" class="btn btn-white rounded-pill flex-align d-inline-flex gap-8 hover-bg-main-800 wow bounceInUp">
                                    Nous Contacter
                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 d-xl-block d-none">
                            <div class="certificate__thumb" data-aos="fade-up-left">    
                                <img src="{{ asset('assets/images/thumbs/certificate-img.png') }}" alt="">
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

@push('scripts')
<script>
    document.getElementById('admissionForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Votre candidature a été envoyée avec succès ! Nous vous contacterons sous 48h.');
        // Here you would normally send the form data via AJAX
    });
</script>
@endpush