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
            <form action="{{ route('admission.store') }}" method="POST" id="admissionForm" enctype="multipart/form-data">
                @csrf
                <h3 class="mb-24">Formulaire de Candidature</h3>

                <!-- Personal information Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24">
                    <h5 class="mb-0">Informations Personnelles</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label for="first_name" class="text-neutral-700 text-lg fw-medium mb-12">Prénom <span class="text-danger-600">*</span></label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="last_name" class="text-neutral-700 text-lg fw-medium mb-12">Nom <span class="text-danger-600">*</span></label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="email" class="text-neutral-700 text-lg fw-medium mb-12">Email <span class="text-danger-600">*</span></label>
                            <input type="email" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="phone" class="text-neutral-700 text-lg fw-medium mb-12">Téléphone <span class="text-danger-600">*</span></label>
                            <input type="tel" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="phone" name="phone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="birth_date" class="text-neutral-700 text-lg fw-medium mb-12">Date de naissance <span class="text-danger-600">*</span></label>
                            <input type="date" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                        </div>
                        <div class="col-sm-12">
                            <label class="text-neutral-700 text-lg fw-medium mb-12">Genre <span class="text-danger-600">*</span></label>
                            <div class="flex-align gap-24">
                                <div class="form-check common-check common-radio mb-0">
                                    <input class="form-check-input" type="radio" name="gender" id="Male" value="M" {{ old('gender') == 'M' ? 'checked' : '' }} required>
                                    <label class="form-check-label fw-normal flex-grow-1" for="Male">Masculin</label>
                                </div>
                                <div class="form-check common-check common-radio mb-0">
                                    <input class="form-check-input" type="radio" name="gender" id="Female" value="F" {{ old('gender') == 'F' ? 'checked' : '' }} required>
                                    <label class="form-check-label fw-normal flex-grow-1" for="Female">Féminin</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="country" class="text-neutral-700 text-lg fw-medium mb-12">Pays <span class="text-danger-600">*</span></label>
                            <select class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600 form-select py-14" id="country" name="country" required>
                                <option value="">Sélectionnez votre pays</option>
                                <option value="Cameroun" {{ old('country') == 'Cameroun' ? 'selected' : '' }}>Cameroun</option>
                                <option value="Côte d'Ivoire" {{ old('country') == 'Côte d\'Ivoire' ? 'selected' : '' }}>Côte d'Ivoire</option>
                                <option value="Sénégal" {{ old('country') == 'Sénégal' ? 'selected' : '' }}>Sénégal</option>
                                <option value="Mali" {{ old('country') == 'Mali' ? 'selected' : '' }}>Mali</option>
                                <option value="Burkina Faso" {{ old('country') == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                <option value="Gabon" {{ old('country') == 'Gabon' ? 'selected' : '' }}>Gabon</option>
                                <option value="Congo" {{ old('country') == 'Congo' ? 'selected' : '' }}>Congo</option>
                                <option value="RDC" {{ old('country') == 'RDC' ? 'selected' : '' }}>RDC</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="city" class="text-neutral-700 text-lg fw-medium mb-12">Ville <span class="text-danger-600">*</span></label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="city" name="city" value="{{ old('city') }}" required>
                        </div>
                        <div class="col-sm-12">
                            <label for="address" class="text-neutral-700 text-lg fw-medium mb-12">Adresse complète</label>
                            <textarea class="common-input bg-main-25 rounded-24 border-transparent focus-border-main-600" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Program Selection Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Programme choisi</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <label for="program_id" class="text-neutral-700 text-lg fw-medium mb-12">Filière de formation <span class="text-danger-600">*</span></label>
                            <select class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600 form-select py-14" id="program_id" name="program_id" required>
                                <option value="">Sélectionnez votre programme</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->title_en }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Previous Education Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Formation antérieure</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label for="previous_school" class="text-neutral-700 text-lg fw-medium mb-12">Dernier établissement fréquenté</label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="previous_school" name="previous_school" value="{{ old('previous_school') }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="previous_diploma" class="text-neutral-700 text-lg fw-medium mb-12">Diplôme obtenu</label>
                            <input type="text" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="previous_diploma" name="previous_diploma" value="{{ old('previous_diploma') }}">
                        </div>
                    </div>
                </div>

                <!-- Documents Upload Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Documents à joindre</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <label for="doc_cv" class="text-neutral-700 text-lg fw-medium mb-12">CV / Curriculum Vitae</label>
                            <input type="file" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="doc_cv" name="documents[cv]">
                            <small class="text-neutral-500">Format: PDF, DOC (Max 5MB)</small>
                        </div>
                        <div class="col-sm-6">
                            <label for="doc_diploma" class="text-neutral-700 text-lg fw-medium mb-12">Copie du diplôme</label>
                            <input type="file" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="doc_diploma" name="documents[diploma]">
                            <small class="text-neutral-500">Format: PDF, JPG (Max 5MB)</small>
                        </div>
                        <div class="col-sm-6">
                            <label for="doc_id" class="text-neutral-700 text-lg fw-medium mb-12">Pièce d'identité</label>
                            <input type="file" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="doc_id" name="documents[id]">
                            <small class="text-neutral-500">Format: PDF, JPG (Max 5MB)</small>
                        </div>
                        <div class="col-sm-6">
                            <label for="doc_photo" class="text-neutral-700 text-lg fw-medium mb-12">Photo d'identité</label>
                            <input type="file" class="common-input bg-main-25 rounded-pill border-transparent focus-border-main-600" id="doc_photo" name="documents[photo]">
                            <small class="text-neutral-500">Format: JPG, PNG (Max 2MB)</small>
                        </div>
                    </div>
                </div>

                <!-- Additional Info Start -->
                <div class="border border-neutral-30 rounded-12 bg-white p-24 mt-24">
                    <h5 class="mb-0">Informations complémentaires</h5>
                    <span class="d-block border border-main-50 my-24 border-dashed"></span>
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <label for="motivation" class="text-neutral-700 text-lg fw-medium mb-12">Lettre de motivation</label>
                            <textarea class="common-input bg-main-25 rounded-24 border-transparent focus-border-main-600" id="motivation" name="motivation" rows="4">{{ old('motivation') }}</textarea>
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