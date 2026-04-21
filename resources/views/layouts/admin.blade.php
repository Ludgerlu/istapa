<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord') — ISTAP Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    @stack('styles')
</head>
<body>


<div class="overlay"></div>
<div class="side-overlay"></div>

{{-- Scroll to top --}}
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>

{{-- Dashboard wrapper --}}
<div class="dashbord bg-main-25 w-100 overflow-hidden">
    <div class="d-flex">

        {{-- ═══ SIDEBAR ════════════════════════════════════════════════ --}}
        <div class="dashboard-sidebar px-20 py-24 max-w-288-px bg-white w-100 border-end border-neutral-40 position-relative">
            <a href="{{ route('admin.dashboard') }}" class="justify-content-center d-flex">
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="ISTAP" class="" height="60" width="60">
            </a>
            <span class="w-100 bg-neutral-40 mb-24 mt-24 h-1 d-block"></span>

            <div class="overflow-x-auto">
                <div class="scrollbar min-w-max">
                    <span class="text-neutral-500 fw-normal text-14 mb-8 d-block">
                        Bonjour, {{ auth()->user()->display_name }} 👋
                    </span>

                    @php
                        $navItems = [
                            ['route' => 'admin.dashboard',  'icon' => 'ph-bold ph-house',          'label' => 'Tableau de bord'],
                            ['route' => 'admin.students',   'icon' => 'ph ph-student',              'label' => 'Étudiants'],
                            ['route' => 'admin.teachers',   'icon' => 'ph ph-chalkboard-teacher',   'label' => 'Enseignants'],
                            ['route' => 'admin.classes',    'icon' => 'ph ph-books',                'label' => 'Classes'],
                            ['route' => 'admin.subjects',   'icon' => 'ph ph-notepad',              'label' => 'Matières'],
                            ['route' => 'admin.exams',      'icon' => 'ph ph-exam',                 'label' => 'Examens'],
                            ['route' => 'admin.fees',       'icon' => 'ph ph-money',                'label' => 'Frais scolaires'],
                            ['route' => 'admin.events',     'icon' => 'ph ph-calendar',             'label' => 'Événements'],
                            ['route' => 'admin.blogs.index',      'icon' => 'ph ph-newspaper',            'label' => 'Blog'],
                            ['route' => 'admin.messages',   'icon' => 'ph ph-chat-dots',            'label' => 'Messages'],
                            ['route' => 'admin.profile',    'icon' => 'ph ph-user-circle',          'label' => 'Mon profil'],
                        ];
                    @endphp

                    <ul>
                        @foreach($navItems as $item)
                            @if(Route::has($item['route']))
                            <li class="mb-8">
                                <a href="{{ route($item['route']) }}"
                                   class="fw-medium d-flex align-items-center text-14 gap-8 text-neutral-500 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap
                                          {{ request()->routeIs($item['route']) ? 'bg-main-600 text-white' : '' }}">
                                    <span class="text-16 text-main-600 item-hover__text transition-03">
                                        <i class="{{ $item['icon'] }}"></i>
                                    </span>
                                    {{ $item['label'] }}
                                </a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="position-absolute inset-block-end-0 inset-inline-start-0 pb-16 px-16 w-100">
                <a href="{{ route('logout') }}"
                   class="text-14 fw-medium text-neutral-500 d-flex align-items-center gap-8 hover-bg-main-600 px-24 py-10 hover-text-white rounded-12 item-hover flex-wrap bg-white">
                    <span class="text-16 text-main-600 item-hover__text transition-03">
                        <i class="ph ph-sign-out"></i>
                    </span>
                    Déconnexion
                </a>
            </div>
        </div>
        {{-- ═══ END SIDEBAR ════════════════════════════════════════════ --}}

        <div class="dashbord-body flex-grow-1">

            {{-- ═══ TOPBAR ═══════════════════════════════════════════════ --}}
            <div class="px-24 py-16 bg-neutral-10 border-bottom border-neutral-40 w-100">
                <div class="d-flex align-items-center justify-content-between gap-24 w-100">
                    <div class="d-flex align-items-center gap-24">
                        <button type="button" class="toggle-dashbord-button text-neutral-500 text-28 line-height-1 d-lg-none d-block">
                            <i class="ph-bold ph-list"></i>
                        </button>
                        <div class="max-w-357-px position-relative d-sm-block d-none">
                            <input type="text" placeholder="Rechercher…"
                                   class="ps-16 pe-36 py-9 border border-neutral-40 rounded-pill focus-visible-outline focus-border-main-600 text-14 line-height-1">
                            <button type="button" class="w-28 h-28 bg-main-600 text-white text-16 rounded-circle justify-content-center align-items-center d-flex position-absolute top-50-percent translate-middle-y inset-inline-end-0-px me-4">
                                <i class="ph-bold ph-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-16">
                        {{-- Notifications --}}
                        <div class="position-relative">
                            <div class="w-36 h-36 border-neutral-50 border rounded-pill justify-content-center align-items-center d-flex text-20 text-neutral-500 position-relative">
                                <button class="dropdown-toggle w-36 h-36 border-0 bg-transparent hover-bg-main-600 hover-text-white transition-03 rounded-pill"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ph ph-bell-simple"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end rounded-12" style="min-width:320px">
                                    <li><span class="dropdown-item text-14 text-neutral-400">Aucune notification</span></li>
                                </ul>
                                @php $unread = 0; @endphp
                                @if($unread > 0)
                                <div class="position-absolute inset-inline-start-22px top--20-percent">
                                    <span class="bg-main-600 text-white w-16 h-16 rounded-circle text-9 d-flex justify-content-center align-items-center">{{ $unread }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Messages --}}
                        <a href="#"
                           class="w-36 h-36 border-neutral-50 border rounded-pill justify-content-center align-items-center d-flex text-20 text-neutral-500 hover-bg-main-600 hover-text-white transition-03">
                            <i class="ph ph-chat-dots"></i>
                        </a>

                        {{-- User dropdown --}}
                        <div class="dropdown">
                            <button class="dropdown-toggle w-36 h-36 border-neutral-50 border rounded-pill overflow-hidden"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->user()->profile_photo ?? asset('assets/images/thumbs/default-avatar.png') }}"
                                     alt="" class="w-100 h-100 object-fit-cover">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end rounded-12">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-12 hover-text-main-600 transition-03"
                                       href="{{ route('admin.profile') }}">
                                        <i class="ph ph-user-circle"></i> Mon profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-12 hover-text-main-600 transition-03"
                                       href="{{ route('logout') }}">
                                        <i class="ph ph-power"></i> Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ═══ END TOPBAR ════════════════════════════════════════════ --}}

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible mx-24 mt-16 fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible mx-24 mt-16 fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ═══ PAGE CONTENT ══════════════════════════════════════════ --}}
            <div class="px-24 py-24">
                @yield('content')
            </div>
            {{-- ═══ END PAGE CONTENT ══════════════════════════════════════ --}}

            {{-- Footer --}}
            <div class="bg-neutral-20 border-neutral-40 border-top px-24 py-16 mt-auto">
                <div class="d-flex align-items-center gap-24 justify-content-between flex-wrap">
                    <p class="fw-medium text-14 text-neutral-500 mb-0">
                        Copyright ©{{ date('Y') }}
                        <span class="text-main-600 fw-medium">ISTAP</span>. Tous droits réservés.
                    </p>
                </div>
            </div>

        </div>{{-- end dashbord-body --}}
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/boostrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/phosphor-icon.js') }}"></script>
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>