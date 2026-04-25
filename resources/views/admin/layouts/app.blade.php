<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'School Management') — EduManager</title>
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

{{-- Sidebar --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <span>🏫</span> EduManager
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">General</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="icon">⊞</span> Dashboard
        </a>

        <div class="nav-section">People</div>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <span class="icon">👤</span> Users
        </a>

        <div class="nav-section">Academic</div>
        <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
            <span class="icon">✓</span> Attendance
        </a>
        <a href="{{ route('fees.index') }}" class="nav-link {{ request()->routeIs('fees.*') ? 'active' : '' }}">
            <span class="icon">₣</span> Fees
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-pill">
            <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
            <div>
                <div style="font-weight:500;color:#2C2C2A;font-size:12px">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div style="font-size:11px">{{ auth()->user()->role ?? 'admin' }}</div>
            </div>
        </div>
    </div>
</aside>

{{-- Main --}}
<div class="main">
    <header class="topbar">
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        <div class="topbar-actions">@yield('topbar-actions')</div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✕ {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>
