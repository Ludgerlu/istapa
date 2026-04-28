<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord') — ISTAP Admin</title>
    <link rel="shortcut icon" href="https://istapa.com/wp-content/uploads/2025/06/cropped-logo-modif-180x180.png">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    @stack('styles')
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --nav-w: 220px;
            --blue: #185FA5; --blue-light: #E6F1FB;
            --green: #3B6D11; --green-light: #EAF3DE;
            --amber: #854F0B; --amber-light: #FAEEDA;
            --red: #A32D2D; --red-light: #FCEBEB;
            --gray-50: #F8F8F7; --gray-100: #EFEFED;
            --gray-500: #888780; --gray-800: #2C2C2A;
            --border: #E0DFD8;
            --radius: 8px; --radius-lg: 12px;
        }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
               font-size: 14px; color: var(--gray-800);
               background: var(--gray-50); display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--nav-w); background: #fff; border-right: 1px solid var(--border);
            display: flex; flex-direction: column; position: fixed; top: 0; left: 0; height: 100vh;
            z-index: 100;
        }
        .sidebar-logo {
            padding: 1.25rem 1rem; border-bottom: 1px solid var(--border);
            font-weight: 600; font-size: 15px; color: var(--blue);
            display: flex; align-items: center; gap: 8px;
        }
        .sidebar-logo span { font-size: 20px; }
        .sidebar-nav { flex: 1; padding: 1rem 0; }
        .nav-section { padding: 0 1rem; margin-bottom: .25rem;
                       font-size: 10px; text-transform: uppercase; letter-spacing: .07em;
                       color: var(--gray-500); margin-top: 1rem; }
        .nav-link {
            display: flex; align-items: center; gap: 10px; padding: 8px 1rem;
            color: var(--gray-500); text-decoration: none; font-size: 13px;
            border-left: 2px solid transparent; transition: .15s;
        }
        .nav-link:hover { background: var(--gray-50); color: var(--gray-800); }
        .nav-link.active { background: var(--blue-light); color: var(--blue);
                           border-left-color: var(--blue); font-weight: 500; }
        .nav-link .icon { width: 16px; text-align: center; }
        .sidebar-footer {
            padding: 1rem; border-top: 1px solid var(--border);
            font-size: 12px; color: var(--gray-500);
        }
        .user-pill {
            display: flex; align-items: center; gap: 8px;
        }
        .avatar-sm {
            width: 28px; height: 28px; border-radius: 50%; background: var(--blue-light);
            color: var(--blue); display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600;
        }

        /* ── Main ── */
        .main { margin-left: var(--nav-w); flex: 1; display: flex; flex-direction: column; }
        .topbar {
            background: #fff; border-bottom: 1px solid var(--border);
            padding: .875rem 1.5rem; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 50;
        }
        .page-title { font-size: 16px; font-weight: 500; }
        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .content { padding: 1.5rem; flex: 1; }

        /* ── Alerts ── */
        .alert { padding: .75rem 1rem; border-radius: var(--radius); margin-bottom: 1rem;
                 font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: var(--green-light); color: var(--green); }
        .alert-error   { background: var(--red-light);   color: var(--red);   }

        /* ── Stats grid ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px,1fr));
                      gap: 10px; margin-bottom: 1.5rem; }
        .stat-card { background: var(--gray-50); border-radius: var(--radius); padding: 1rem; }
        .stat-label { font-size: 11px; color: var(--gray-500); margin-bottom: 5px; }
        .stat-value { font-size: 22px; font-weight: 500; }
        .stat-value.blue  { color: var(--blue); }
        .stat-value.green { color: var(--green); }
        .stat-value.amber { color: var(--amber); }
        .stat-value.red   { color: var(--red); }

        /* ── Card ── */
        .card { background: #fff; border: 1px solid var(--border);
                border-radius: var(--radius-lg); padding: 1.25rem; margin-bottom: 1rem; }
        .card-header { display: flex; align-items: center; justify-content: space-between;
                       margin-bottom: 1rem; }
        .card-title { font-size: 14px; font-weight: 500; }

        /* ── Buttons ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px;
               border-radius: var(--radius); border: 1px solid var(--border);
               background: transparent; color: var(--gray-800); cursor: pointer;
               font-size: 13px; text-decoration: none; transition: .15s; }
        .btn:hover { background: var(--gray-50); }
        .btn-primary { background: var(--blue); color: #fff; border-color: var(--blue); }
        .btn-primary:hover { background: #0C447C; }
        .btn-danger { color: var(--red); border-color: #F09595; }
        .btn-danger:hover { background: var(--red-light); }
        .btn-sm { padding: 4px 10px; font-size: 12px; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { text-align: left; padding: 8px 10px; color: var(--gray-500);
             font-weight: 500; border-bottom: 1px solid var(--border); font-size: 12px; }
        td { padding: 9px 10px; border-bottom: 1px solid var(--border); }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--gray-50); }

        /* ── Badge ── */
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px;
                 font-size: 11px; font-weight: 500; }
        .badge-blue   { background: var(--blue-light);  color: var(--blue); }
        .badge-green  { background: var(--green-light); color: var(--green); }
        .badge-amber  { background: var(--amber-light); color: var(--amber); }
        .badge-red    { background: var(--red-light);   color: var(--red); }
        .badge-gray   { background: var(--gray-100);    color: var(--gray-500); }

        /* ── Forms ── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid.three { grid-template-columns: 1fr 1fr 1fr; }
        .form-group { margin-bottom: 14px; }
        label { display: block; font-size: 12px; color: var(--gray-500); margin-bottom: 4px; }
        input, select, textarea {
            width: 100%; padding: 8px 10px; border: 1px solid var(--border);
            border-radius: var(--radius); font-size: 13px; color: var(--gray-800);
            background: #fff; transition: border-color .15s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--blue);
        }
        .error-msg { color: var(--red); font-size: 11px; margin-top: 3px; }

        /* ── Avatar ── */
        .avatar { width: 30px; height: 30px; border-radius: 50%; display: inline-flex;
                  align-items: center; justify-content: center; font-size: 11px;
                  font-weight: 600; margin-right: 8px; vertical-align: middle; flex-shrink: 0; }

        /* ── Pagination ── */
        .pagination { display: flex; gap: 4px; justify-content: flex-end;
                      padding-top: 1rem; }
        .pagination a, .pagination span {
            padding: 5px 10px; border-radius: var(--radius); border: 1px solid var(--border);
            font-size: 12px; text-decoration: none; color: var(--gray-800);
        }
        .pagination .active { background: var(--blue); color: #fff; border-color: var(--blue); }

        /* ── Progress ── */
        .progress { height: 6px; background: var(--gray-100); border-radius: 3px; overflow: hidden; }
        .progress-bar { height: 100%; border-radius: 3px; transition: width .3s; }
        .bg-green { background: var(--green); }
        .bg-amber { background: #EF9F27; }
        .bg-red   { background: #E24B4A; }

        /* ── Attendance calendar ── */
        .att-calendar { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; margin: 1rem 0; }
        .att-day { text-align: center; padding: 7px 0; border-radius: var(--radius); font-size: 11px; font-weight: 500; }
        .att-P { background: var(--green-light); color: var(--green); }
        .att-A { background: var(--red-light);   color: var(--red); }
        .att-L { background: var(--amber-light); color: var(--amber); }
        .att-H { background: var(--gray-100);    color: var(--gray-500); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main { margin-left: 0; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
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
                            ['route' => 'admin.users.index',   'icon' => 'ph ph-student',              'label' => 'Utilisateurs'],
                            ['route' => 'admin.attendance.index',   'icon' => 'ph ph-chalkboard-teacher',   'label' => 'present'],
                            ['route' => 'admin.classes.index',    'icon' => 'ph ph-books',                'label' => 'Classes'],
                            ['route' => 'admin.subjects',   'icon' => 'ph ph-notepad',              'label' => 'Matières'],
                            ['route' => 'admin.exams',      'icon' => 'ph ph-exam',                 'label' => 'Examens'],
                            ['route' => 'admin.fees.index',       'icon' => 'ph ph-money',                'label' => 'Frais scolaires'],
                            ['route' => 'admin.events.index',     'icon' => 'ph ph-calendar',             'label' => 'Événements'],
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/boostrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/phosphor-icon.js') }}"></script>
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
@stack('scripts')
</body>
</html>