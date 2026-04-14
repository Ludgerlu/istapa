@extends('layouts.app')

@section('title', 'ISTAPA - Contact')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <img src="{{ asset('assets/images/shapes/shape1.png') }}" alt="" class="shape one animation-rotation d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape two animation-scalation d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape3.png') }}" alt="" class="shape eight animation-walking d-md-block d-none">
    <img src="{{ asset('assets/images/shapes/shape5.png') }}" alt="" class="shape six animation-walking d-md-block d-none">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Contactez-nous</h1>
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
                            <span class="text-main-two-600">Contact</span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==================== Breadcrumb End Here ==================== -->



<!-- ================================ Contact Section Start =================================== -->
<section class="contact py-120">
    <div class="container">
        <div class="section-heading text-center mb-60">
            <div class="flex-align d-inline-flex gap-8 mb-16">
                <span class="text-main-600 text-2xl d-flex"><i class="ph-bold ph-phone-call"></i></span>
                <h5 class="text-main-600 mb-0">Restons en contact</h5>
            </div>
            <h2 class="mb-24">N'hésitez pas à nous contacter</h2>
            <p class="text-neutral-500">Notre équipe est disponible pour répondre à toutes vos questions</p>
        </div>

        <div class="row gy-5">
            <!-- Contact Info Cards -->
            <div class="col-lg-4">
                <div class="contact-info">
                    <div class="contact-card p-24 bg-main-25 rounded-12 border border-neutral-30 mb-24" data-aos="fade-up" data-aos-duration="300">
                        <div class="flex-align gap-16">
                            <span class="w-60 h-60 bg-main-600 rounded-circle flex-center text-white text-2xl flex-shrink-0"><i class="ph-bold ph-map-pin"></i></span>
                            <div>
                                <h4 class="mb-8">Notre Adresse</h4>
                                <p class="text-neutral-500 mb-0">Ebogo 1 - Yaoundé, Cameroun</p>
                                <p class="text-neutral-500 mb-0">BP: 1234 Yaoundé</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-card p-24 bg-main-25 rounded-12 border border-neutral-30 mb-24" data-aos="fade-up" data-aos-duration="400">
                        <div class="flex-align gap-16">
                            <span class="w-60 h-60 bg-main-600 rounded-circle flex-center text-white text-2xl flex-shrink-0"><i class="ph-bold ph-phone"></i></span>
                            <div>
                                <h4 class="mb-8">Nous Appeler</h4>
                                <p class="text-neutral-500 mb-0">
                                    <a href="tel:+237655555555" class="text-neutral-500 hover-text-main-600">+237 655 555 555</a>
                                </p>
                                <p class="text-neutral-500 mb-0">
                                    <a href="tel:+237699999999" class="text-neutral-500 hover-text-main-600">+237 699 999 999</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-card p-24 bg-main-25 rounded-12 border border-neutral-30 mb-24" data-aos="fade-up" data-aos-duration="500">
                        <div class="flex-align gap-16">
                            <span class="w-60 h-60 bg-main-600 rounded-circle flex-center text-white text-2xl flex-shrink-0"><i class="ph-bold ph-envelope"></i></span>
                            <div>
                                <h4 class="mb-8">Nous Écrire</h4>
                                <p class="text-neutral-500 mb-0">
                                    <a href="mailto:contact@istapa.com" class="text-neutral-500 hover-text-main-600">contact@istapa.com</a>
                                </p>
                                <p class="text-neutral-500 mb-0">
                                    <a href="mailto:admission@istapa.com" class="text-neutral-500 hover-text-main-600">admission@istapa.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-card p-24 bg-main-25 rounded-12 border border-neutral-30" data-aos="fade-up" data-aos-duration="600">
                        <div class="flex-align gap-16">
                            <span class="w-60 h-60 bg-main-600 rounded-circle flex-center text-white text-2xl flex-shrink-0"><i class="ph-bold ph-clock"></i></span>
                            <div>
                                <h4 class="mb-8">Horaires d'ouverture</h4>
                                <p class="text-neutral-500 mb-0">Lundi - Vendredi: 8h00 - 17h00</p>
                                <p class="text-neutral-500 mb-0">Samedi: 9h00 - 13h00</p>
                                <p class="text-neutral-500 mb-0">Dimanche: Fermé</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="contact-form bg-main-25 rounded-12 p-32 border border-neutral-30" data-aos="fade-left" data-aos-duration="800">
                    <h3 class="mb-24">Envoyez-nous un message</h3>
                    <p class="text-neutral-500 mb-32">Nous vous répondrons dans les plus brefs délais</p>
                    
                    <form action="#" method="POST" id="contactForm">
                        @csrf
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <label for="name" class="text-neutral-700 fw-medium mb-12">Votre nom <span class="text-danger-600">*</span></label>
                                <input type="text" class="common-input rounded-pill" id="name" name="name" placeholder="Jean Dupont" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="text-neutral-700 fw-medium mb-12">Votre email <span class="text-danger-600">*</span></label>
                                <input type="email" class="common-input rounded-pill" id="email" name="email" placeholder="jean@exemple.com" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="phone" class="text-neutral-700 fw-medium mb-12">Téléphone</label>
                                <input type="tel" class="common-input rounded-pill" id="phone" name="phone" placeholder="+237 6XX XXX XXX">
                            </div>
                            <div class="col-sm-6">
                                <label for="subject" class="text-neutral-700 fw-medium mb-12">Sujet <span class="text-danger-600">*</span></label>
                                <select class="common-input rounded-pill form-select" id="subject" name="subject" required>
                                    <option value="">Sélectionnez un sujet</option>
                                    <option value="admission">Informations sur l'admission</option>
                                    <option value="program">Questions sur un programme</option>
                                    <option value="partnership">Partenariat</option>
                                    <option value="support">Support technique</option>
                                    <option value="other">Autre</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="message" class="text-neutral-700 fw-medium mb-12">Message <span class="text-danger-600">*</span></label>
                                <textarea class="common-input rounded-24" id="message" name="message" rows="6" placeholder="Votre message..." required></textarea>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-check common-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="privacy" required>
                                    <label class="form-check-label" for="privacy">
                                        J'accepte la <a href="#" class="text-main-600">politique de confidentialité</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-main rounded-pill flex-center gap-8">
                                    Envoyer le message
                                    <i class="ph-bold ph-paper-plane-tilt d-flex text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ Contact Section End =================================== -->

<!-- ================================ Social Media Section Start =================================== -->
<section class="social-media py-60 bg-main-25">
    <div class="container">
        <div class="text-center">
            <h3 class="mb-32">Suivez-nous sur les réseaux sociaux</h3>
            <ul class="social-list flex-center gap-24">
                <li class="social-list__item">
                    <a href="https://www.facebook.com/istapa" class="text-main-600 text-3xl hover-text-main-two-600 w-60 h-60 bg-white rounded-circle flex-center shadow-sm transition-1">
                        <i class="ph-bold ph-facebook-logo"></i>
                    </a>
                </li>
                <li class="social-list__item">
                    <a href="https://www.twitter.com/istapa" class="text-main-600 text-3xl hover-text-main-two-600 w-60 h-60 bg-white rounded-circle flex-center shadow-sm transition-1">
                        <i class="ph-bold ph-twitter-logo"></i>
                    </a>
                </li>
                <li class="social-list__item">
                    <a href="https://www.instagram.com/istapa" class="text-main-600 text-3xl hover-text-main-two-600 w-60 h-60 bg-white rounded-circle flex-center shadow-sm transition-1">
                        <i class="ph-bold ph-instagram-logo"></i>
                    </a>
                </li>
                <li class="social-list__item">
                    <a href="https://www.linkedin.com/school/istapa" class="text-main-600 text-3xl hover-text-main-two-600 w-60 h-60 bg-white rounded-circle flex-center shadow-sm transition-1">
                        <i class="ph-bold ph-linkedin-logo"></i>
                    </a>
                </li>
                <li class="social-list__item">
                    <a href="https://www.youtube.com/@istapa" class="text-main-600 text-3xl hover-text-main-two-600 w-60 h-60 bg-white rounded-circle flex-center shadow-sm transition-1">
                        <i class="ph-bold ph-youtube-logo"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- ================================ Social Media Section End =================================== -->

<!-- ================================ Google Map Start =================================== -->
<div class="map-container py-60 bg-main-25">
    <div class="container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15915.205311479171!2d11.523847!3d3.866667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcfc6f4a5b9b9%3A0x8a5e5e5e5e5e5e5e!2sYaound%C3%A9%2C%20Cameroon!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus" 
            width="100%" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>
<!-- ================================ Google Map End =================================== -->


<!-- ================================ FAQ Contact Section Start =================================== -->
<section class="faq-contact py-60">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-8">
                <div class="bg-main-600 rounded-20 p-48 text-white">
                    <h3 class="text-white mb-16">Vous avez des questions ?</h3>
                    <p class="text-white-80 mb-32">Consultez notre foire aux questions ou contactez notre service client</p>
                    <div class="flex-center gap-24 flex-wrap">
                        <a href="{{ route('faq') }}" class="btn btn-white rounded-pill flex-align gap-8">
                            Voir la FAQ
                            <i class="ph-bold ph-question d-flex text-lg"></i>
                        </a>
                        <a href="tel:+237655555555" class="btn btn-outline-white rounded-pill flex-align gap-8">
                            <i class="ph-bold ph-phone d-flex text-lg"></i>
                            Appelez-nous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================ FAQ Contact Section End =================================== -->
@endsection

@push('scripts')
<script>
    document.getElementById('contactForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Votre message a été envoyé avec succès ! Nous vous répondrons sous 24h.');
        this.reset();
    });
</script>
@endpush