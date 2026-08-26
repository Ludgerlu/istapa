@extends('layouts.app')

@section('title', 'ISTAPA - Connexion')

@section('content')
<!-- ==================== Breadcrumb Start Here ==================== -->
<!-- <section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
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
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center">Connexion</h1>
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
                            <span class="text-main-two-600">Connexion</span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- ==================== Breadcrumb End Here ==================== -->

<!-- ============================== Sign In Section Start ============================== -->
<div class="account py-120 position-relative">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-lg-6">
                <div class="bg-main-25 border border-neutral-30 rounded-8 p-32">
                    <div class="mb-40">
                        <div class="flex-align gap-8 mb-16">
                            <span class="w-8 h-8 bg-main-600 rounded-circle"></span>
                            <h5 class="text-main-600 mb-0">Bienvenue</h5>
                        </div>
                        <h3 class="mb-16 text-neutral-500">Content de vous revoir !</h3>
                        <p class="text-neutral-500">Connectez-vous à votre compte pour accéder à votre espace personnel</p>
                    </div>
                    
                    <form action="#" method="POST" id="signinForm">
                        @csrf
                        <div class="mb-24">
                            <label for="email" class="fw-medium text-lg text-neutral-500 mb-16">Adresse Email</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ms-16 text-neutral-400">
                                    <i class="ph-bold ph-envelope"></i>
                                </span>
                                <input type="email" class="common-input rounded-pill ps-48" id="email" name="email" placeholder="exemple@email.com" required>
                            </div>
                        </div>
                        <div class="mb-16">
                            <label for="password" class="fw-medium text-lg text-neutral-500 mb-16">Mot de passe</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 translate-middle-y ms-16 text-neutral-400">
                                    <i class="ph-bold ph-lock"></i>
                                </span>
                                <input type="password" class="common-input rounded-pill ps-48 pe-44" id="password" name="password" placeholder="••••••••" required>
                                <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y ph-bold ph-eye-closed" style="cursor: pointer;" id="togglePassword"></span>
                            </div>
                        </div>
                        <div class="flex-between flex-wrap gap-16 mb-16">
                            <div class="form-check common-check mb-0">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label fw-normal" for="remember">Se souvenir de moi</label>
                            </div>
                            <a href="javascript:void(0)" class="text-main-600 hover-text-decoration-underline" id="forgotPassword">Mot de passe oublié ?</a>
                        </div>
                        <div class="mt-40">
                            <button type="submit" class="btn btn-main rounded-pill w-100 flex-center gap-8 py-14">
                                Se Connecter
                                <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                            </button>
                        </div>
                    </form>

                    <!-- <div class="position-relative my-32">
                        <hr class="border-neutral-30">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-16 text-neutral-500">ou</span>
                    </div> -->

                    <!-- Social Login Buttons -->
                    <!-- <div class="d-grid gap-16">
                        <button type="button" class="btn btn-outline-main rounded-pill flex-center gap-8 py-12">
                            <i class="ph-bold ph-google-logo text-xl"></i>
                            Continuer avec Google
                        </button>
                        <button type="button" class="btn btn-outline-main rounded-pill flex-center gap-8 py-12">
                            <i class="ph-bold ph-facebook-logo text-xl"></i>
                            Continuer avec Facebook
                        </button>
                    </div> -->

                    <!-- <div class="mt-32 text-center">
                        <p class="text-neutral-500">Pas encore de compte ? 
                            <a href="{{ route('signup') }}" class="fw-semibold text-main-600 hover-text-decoration-underline">Créer un compte</a> 
                        </p>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-6 d-lg-block d-none">
                <div class="account-img text-center">
                    <img src="{{ asset('assets/images/thumbs/account-img.png') }}" alt="Login Illustration" class="w-100">
                    <div class="mt-40 text-center">
                        <h4>Étudiant à ISTAPA ?</h4>
                        <p class="text-neutral-500">Accédez à vos cours, suivez votre progression et interagissez avec vos formateurs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-20">
            <div class="modal-header border-0 pt-32 px-32">
                <h4 class="modal-title">Réinitialiser le mot de passe</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-32 pb-32">
                <p class="text-neutral-500 mb-24">Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
                <form id="forgotForm">
                    <input type="email" class="common-input rounded-pill mb-24" placeholder="Votre adresse email" required>
                    <button type="submit" class="btn btn-main rounded-pill w-100">Envoyer le lien</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ============================== Sign In Section End ============================== -->
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    togglePassword?.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('ph-eye-closed');
        this.classList.toggle('ph-eye');
    });

    // Handle sign in form submission
    // document.getElementById('signinForm')?.addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     alert('Connexion réussie ! Redirection vers votre tableau de bord...');
    //     // window.location.href = "#";
    // });

    // Handle forgot password
    document.getElementById('forgotPassword')?.addEventListener('click', function() {
        new bootstrap.Modal(document.getElementById('forgotModal')).show();
    });

    document.getElementById('forgotForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Un lien de réinitialisation a été envoyé à votre adresse email.');
        bootstrap.Modal.getInstance(document.getElementById('forgotModal')).hide();
    });
</script>
@endpush