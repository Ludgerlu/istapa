<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ISTAPA')</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://istapa.com/wp-content/uploads/2025/06/cropped-logo-modif-180x180.png" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- jquery-ui -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <!-- plyr Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plyr.css') }}">
    <!-- Editor js Toolbar Start -->
    <link rel="stylesheet" href="{{ asset('assets/css/editor-quill.css') }}">
    <!-- animate -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- dataTables -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.min.css') }}">
    <!-- AOS -->
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    @stack('styles')
</head>
<body>
    
<!--==================== Overlay Start ====================-->
<div class="overlay"></div>
<!--==================== Overlay End ====================-->

<!--==================== Sidebar Overlay End ====================-->
<div class="side-overlay"></div>
<!--==================== Sidebar Overlay End ====================-->

<!-- ==================== Scroll to Top End Here ==================== -->
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- ==================== Scroll to Top End Here ==================== -->

<!-- ==================== Mobile Menu Start Here ==================== -->
<div class="mobile-menu scroll-sm d-lg-none d-block">
    <button type="button" class="close-button"><i class="ph ph-x"></i></button>
    <div class="mobile-menu__inner">
        <a href="{{ route('home') }}" class="mobile-menu__logo">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" width="80"/>
        </a>
        <div class="mobile-menu__menu">
            <ul class="nav-menu flex-align nav-menu--mobile">
                <li class="nav-menu__item">
                    <a href="{{ route('home') }}" class="nav-menu__link">Accueil</a>
                </li>
                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">À Propos</a>
                    <ul class="nav-submenu scroll-sm">
                        <li class="nav-submenu__item">
                            <a href="{{ route('about.founder') }}" class="nav-submenu__link hover-bg-neutral-30">
                                Le Mot du Fondateur
                            </a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="{{ route('about.establishment') }}" class="nav-submenu__link hover-bg-neutral-30">
                                L'Établissement
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">Programme</a>
                    <ul class="nav-submenu scroll-sm">
                        <li class="nav-submenu__item">
                            <a href="{{ route('courses') }}" class="nav-submenu__link hover-bg-neutral-30">
                                Nos Ateliers
                            </a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="{{ route('courses.list') }}" class="nav-submenu__link hover-bg-neutral-30">
                                Vue Liste des Cours
                            </a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="{{ route('course.details', 1) }}" class="nav-submenu__link hover-bg-neutral-30">
                                Détails du Cours
                            </a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="{{ route('lesson.details', 1) }}" class="nav-submenu__link hover-bg-neutral-30">
                                Détails de la Leçon
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-menu__item">
                    <a href="{{ route('blog') }}" class="nav-menu__link">Blog</a>
                </li>
                <li class="nav-menu__item">
                    <a href="{{ route('admission') }}" class="nav-menu__link">Admission</a>
                </li>
                <li class="nav-menu__item">
                    <a href="{{ route('gallery') }}" class="nav-menu__link">Galerie</a>
                </li>
                <li class="nav-menu__item">
                    <a href="{{ route('contact') }}" class="nav-menu__link">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- ==================== Mobile Menu End Here ==================== -->

<!-- ==================== Header Start Here ==================== -->
<header class="header">
    <div class="container container--xl">
        <nav class="header-inner flex-between gap-8">
            <div class="header-content-wrapper flex-align flex-grow-1">
                <!-- Logo Start -->
                <div class="logo">
                    <a href="{{ route('home') }}" class="link">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" width="80" />
                    </a>
                </div>
                <!-- Logo End  -->

                <!-- Menu Start  -->
                <div class="header-menu d-lg-block d-none">
                    <ul class="nav-menu flex-align">
                        <li class="nav-menu__item @if(request()->routeIs('home')) activePage @endif">
                            <a href="{{ route('home') }}" class="nav-menu__link">Accueil</a>
                        </li>
                        <li class="nav-menu__item has-submenu @if(request()->routeIs('about.*')) activePage @endif">
                            <a href="javascript:void(0)" class="nav-menu__link">À Propos</a>
                            <ul class="nav-submenu scroll-sm">
                                <li class="nav-submenu__item">
                                    <a href="{{ route('about.founder') }}" class="nav-submenu__link hover-bg-neutral-30">
                                        LE MOT DU FONDATEUR
                                    </a>
                                </li>
                                <li class="nav-submenu__item">
                                    <a href="{{ route('about.establishment') }}" class="nav-submenu__link hover-bg-neutral-30">
                                        L'ÉTABLISSEMENT
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-menu__item has-submenu">
                            <a href="javascript:void(0)" class="nav-menu__link">Programme</a>
                            <ul class="nav-submenu scroll-sm">
                                <li class="nav-submenu__item">
                                    <a href="{{ route('courses') }}" class="nav-submenu__link hover-bg-neutral-30">Nos Ateliers</a>
                                </li>
                                <li class="nav-submenu__item">
                                    <a href="{{ route('courses.list') }}" class="nav-submenu__link hover-bg-neutral-30">Vue Liste des Cours</a>
                                </li>
                                <li class="nav-submenu__item">
                                    <a href="{{ route('course.details', 1) }}" class="nav-submenu__link hover-bg-neutral-30">Détails du Cours</a>
                                </li>
                                <li class="nav-submenu__item">
                                    <a href="{{ route('lesson.details', 1) }}" class="nav-submenu__link hover-bg-neutral-30">Détails de la Leçon</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-menu__item @if(request()->routeIs('blog*')) activePage @endif">
                            <a href="{{ route('blog') }}" class="nav-menu__link">Blog</a>
                        </li>
                        <li class="nav-menu__item @if(request()->routeIs('admission')) activePage @endif">
                            <a href="{{ route('admission') }}" class="nav-submenu__link">Admission</a>
                        </li>
                        <li class="nav-menu__item @if(request()->routeIs('gallery')) activePage @endif">
                            <a href="{{ route('gallery') }}" class="nav-menu__link">Galerie</a>
                        </li>
                        <li class="nav-menu__item @if(request()->routeIs('contact')) activePage @endif">
                            <a href="{{ route('contact') }}" class="nav-menu__link">Contact</a>
                        </li>
                    </ul>
                </div>
                <!-- Menu End  -->
            </div>
            <!-- Header Right start -->
            <div class="header-right flex-align">
                <div class="header-select border border-neutral-30 bg-main-25 rounded-pill position-relative">
                    <span class="select-icon d-xxl-block d-none position-absolute top-50 translate-middle-y inset-inline-start-0 z-1 ms-lg-4 ms-12 text-xl pointer-event-none d-flex">
                        <i class="ph-bold ph-squares-four"></i>
                    </span>
                    <select class="js-example-basic-single border-0" name="state">
                        <option value="1" selected disabled>Langue</option>
                        <option value="1">Fr</option>
                        <option value="1">En</option>
                    </select>
                </div>
                <a href="{{ route('signin') }}" class="info-action w-52 h-52 bg-main-25 hover-bg-main-600 border border-neutral-30 rounded-circle flex-center text-2xl text-neutral-500 hover-text-white hover-border-main-600">
                    <i class="ph ph-user-circle"></i>
                </a>
                <button type="button" class="toggle-mobileMenu d-lg-none text-neutral-200 flex-center">
                    <i class="ph ph-list"></i>
                </button>
            </div>  
            <!-- Header Right End  -->
        </nav>
    </div>
</header>
<!-- ==================== Header End Here ==================== -->

<main>
    @yield('content')
</main>

<!-- ==================== Footer Start Here ==================== -->
<footer class="footer bg-main-25 position-relative z-1">
    <img src="{{ asset('assets/images/shapes/shape2.png') }}" alt="" class="shape five animation-scalation">
    <img src="{{ asset('assets/images/shapes/shape6.png') }}" alt="" class="shape one animation-scalation">
    
    <div class="py-120">
        <div class="container container-two">
            <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-5">
                <div class="col" data-aos="fade-up" data-aos-duration="300">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{ route('home') }}"> <img src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a>
                        </div>
                        <p class="my-32">EduAll exceeded all my expectations! The instructors were not only experts</p>
                        <ul class="social-list flex-align gap-24">
                            <li class="social-list__item">
                                <a href="https://www.facebook.com/" class="text-main-600 text-2xl hover-text-main-two-600"><i class="ph-bold ph-facebook-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="https://www.twitter.com/" class="text-main-600 text-2xl hover-text-main-two-600"> <i class="ph-bold ph-twitter-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="https://www.linkedin.com/" class="text-main-600 text-2xl hover-text-main-two-600"><i class="ph-bold ph-instagram-logo"></i></a>
                            </li>
                            <li class="social-list__item">
                                <a href="https://www.pinterest.com/" class="text-main-600 text-2xl hover-text-main-two-600"><i class="ph-bold ph-pinterest-logo"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-duration="400">
                    <div class="footer-item">
                        <h4 class="footer-item__title mb-32">Navigation</h4>
                        <ul class="footer-menu">
                            <li class="mb-16">
                                <a href="{{ route('about.founder') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">About us</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{ route('courses') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">Courses</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{ route('faq') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">FAQs</a>
                            </li>
                            <li class="mb-0">
                                <a href="{{ route('blog') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">Blogs</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-duration="600">
                    <div class="footer-item">
                        <h4 class="footer-item__title mb-32">Category</h4>
                        <ul class="footer-menu">
                            <li class="mb-16">
                                <a href="{{ route('courses') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">UI/UX Design</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{ route('courses') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">Web Development</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{ route('courses') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">Python Development</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{ route('courses') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">Digital Marketing</a>
                            </li>
                            <li class="mb-16">
                                <a href="{{ route('courses') }}" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">Graphic Design</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-duration="800">
                    <div class="footer-item">
                        <h4 class="footer-item__title mb-32">Contact Us</h4>
                        <div class="flex-align gap-20 mb-24">
                            <span class="icon d-flex text-32 text-main-600"><i class="ph ph-phone"></i></span>
                            <div class="">
                                <a href="tel:(207)555-0119" class="text-neutral-500 d-block hover-text-main-600 mb-4">(207) 555-0119</a>
                                <a href="tel:(704)555-0127" class="text-neutral-500 d-block hover-text-main-600 mb-0">(704) 555-0127</a>
                            </div>
                        </div>
                        <div class="flex-align gap-20 mb-24">
                            <span class="icon d-flex text-32 text-main-600"><i class="ph ph-envelope-open"></i></span>
                            <div class="">
                                <a href="mailto:dwallo@gmail.com" class="text-neutral-500 d-block hover-text-main-600 mb-4">dwallo@gmail.com</a>
                                <a href="mailto:eduAll@gmail.com" class="text-neutral-500 d-block hover-text-main-600 mb-0">eduAll@gmail.com</a>
                            </div>
                        </div>
                        <div class="flex-align gap-20 mb-24">
                            <span class="icon d-flex text-32 text-main-600"><i class="ph ph-map-trifold"></i></span>
                            <div class="">
                                <span class="text-neutral-500 d-block mb-4">5488 srker Rd .</span>
                                <span class="text-neutral-500 d-block mb-0">8745 doer Dr.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col" data-aos="fade-up" data-aos-duration="1000">
                    <div class="footer-item">
                        <h4 class="footer-item__title mb-32">Subscribe Here</h4>
                        <p class="text-neutral-500">Enter your email address to register to our newsletter subscription</p>
                        <form action="#" class="mt-24 position-relative">
                            <input type="email" class="form-control bg-white shadow-none border border-neutral-30 rounded-pill h-52 ps-24 pe-48 focus-border-main-600" placeholder="Email...">
                            <button type="submit" class="w-36 h-36 flex-center rounded-circle bg-main-600 text-white hover-bg-main-800 position-absolute top-50 translate-middle-y inset-inline-end-0 me-8">
                                <i class="ph ph-paper-plane-tilt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- bottom Footer -->
        <div class="bottom-footer bg-main-25 border-top border-dashed border-main-100 border-0 py-32">
            <div class="container container-two">
                <div class="bottom-footer__inner flex-between gap-3 flex-wrap">
                    <p class="bottom-footer__text"> Copyright &copy; {{ date('Y') }} <span class="fw-semibold">EduAll</span> All Rights Reserved.</p>
                    <div class="footer-links">
                        <a href="#" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">Privacy Policy</a>
                        <a href="#" class="text-neutral-500 hover-text-main-600 hover-text-decoration-underline">Terms & Conditions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ==================== Footer End Here ==================== -->

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/boostrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/phosphor-icon.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/counter.min.js') }}"></script>
<script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/marquee.min.js') }}"></script>
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script src="{{ asset('assets/js/plyr.js') }}"></script>
<script src="{{ asset('assets/js/editor-quill.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/vanilla-tilt.min.js') }}"></script>
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/js/aos.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>