{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<h4 class="fw-semibold text-neutral-500 text-20 mb-24">Tableau de bord</h4>

{{-- ═══ KPI CARDS ══════════════════════════════════════════════════════════════ --}}
<div class="row gy-4 mb-4">

    {{-- Total Students --}}
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Total Étudiants</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($stats['total_students']) }}</h6>
                </div>
                <span class="w-44 h-44 bg-main-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-student text-white text-20"></i>
                </span>
            </div>
            <a href="#" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>

    {{-- Total Teachers --}}
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Total Enseignants</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($stats['total_teachers']) }}</h6>
                </div>
                <span class="w-44 h-44 bg-success-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-chalkboard-teacher text-white text-20"></i>
                </span>
            </div>
            <a href="#" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>

    {{-- Total Classes --}}
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Total Classes</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($stats['total_classes']) }}</h6>
                </div>
                <span class="w-44 h-44 bg-warning-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-books text-white text-20"></i>
                </span>
            </div>
            <a href="#" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>

    {{-- Total Fees Collected --}}
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Frais perçus</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($stats['total_fees_collected'], 0, ',', ' ') }} FCFA</h6>
                </div>
                <span class="w-44 h-44 bg-success-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-money text-white text-20"></i>
                </span>
            </div>
            <a href="#" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>

    {{-- Pending Fees --}}
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Frais en attente</span>
                    <h6 class="text-18 fw-semibold text-danger mb-0">{{ number_format($stats['pending_fees'], 0, ',', ' ') }} FCFA</h6>
                </div>
                <span class="w-44 h-44 bg-danger rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-warning text-white text-20"></i>
                </span>
            </div>
            <a href="#" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Événements à venir</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ $stats['upcoming_events'] }}</h6>
                </div>
                <span class="w-44 h-44 bg-main-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-calendar text-white text-20"></i>
                </span>
            </div>
            <a href="#" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>
</div>

{{-- ═══ CHARTS ROW ═════════════════════════════════════════════════════════════ --}}
<div class="row gy-4 mb-4">
    {{-- Overview line chart --}}
    <div class="col-xl-8">
        <div class="bg-white px-20 py-20 rounded-10">
            <div class="d-flex align-items-center justify-content-between gap-24 mb-4">
                <span class="text-16 fw-medium text-neutral-400">Aperçu des inscriptions</span>
                <select class="form-select text-12 w-auto pe-26 border-neutral-40 border bg-main-25 px-16 py-8 fw-normal" id="chartYearFilter">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div id="enrollmentChart"></div>
            <div class="d-flex justify-content-center gap-24 mt-12">
                <span class="text-14 fw-normal d-flex align-items-center gap-8 text-neutral-500">
                    <span class="w-6 h-6 bg-main-600 rounded-circle"></span> Étudiants inscrits
                </span>
                <span class="text-14 fw-normal d-flex align-items-center gap-8 text-neutral-500">
                    <span class="w-6 h-6 bg-warning-600 rounded-circle"></span> Frais perçus (×1000)
                </span>
            </div>
        </div>
    </div>

    {{-- Donut chart --}}
    <div class="col-xl-4">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex align-items-center justify-content-between gap-24 mb-4">
                <span class="text-14 fw-normal text-neutral-500">Répartition</span>
            </div>
            <div id="distributionChart"></div>
            <div class="mt-16 d-flex flex-column gap-8">
                <span class="text-14 fw-normal text-neutral-400 d-flex align-items-center gap-12">
                    <span class="w-6 h-6 bg-primary-500 rounded-circle"></span> Étudiants
                </span>
                <span class="text-14 fw-normal text-neutral-400 d-flex align-items-center gap-12">
                    <span class="w-6 h-6 bg-success-600 rounded-circle"></span> Enseignants
                </span>
                <span class="text-14 fw-normal text-neutral-400 d-flex align-items-center gap-12">
                    <span class="w-6 h-6 bg-warning-700 rounded-circle"></span> Classes
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ═══ TABLES ROW ══════════════════════════════════════════════════════════════ --}}
<div class="row gy-4 mb-4">

    {{-- Recent Students --}}
    <div class="col-xl-6">
        <div class="px-24 py-24 bg-white rounded-10">
            <div class="d-flex align-items-center justify-content-between mb-24">
                <h6 class="mb-0 fw-medium text-16 text-neutral-500">Derniers étudiants inscrits</h6>
                <a href="#" class="text-12 fw-medium text-main-600 hover-underline transition-03">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="display min-w-max w-100">
                    <thead>
                        <tr class="bg-main-25 border-bottom">
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Nom</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Classe</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents as $student)
                        <tr class="hover-bg-neutral-20 border-bottom transition-03">
                            <td class="py-16 px-20 shadow-none">
                                <div class="d-flex align-items-center gap-12">
                                    <div class="w-32 h-32 bg-main-600 rounded-circle d-flex align-items-center justify-content-center text-white text-12 fw-bold flex-shrink-0">
                                        {{ strtoupper(substr($student->last_name, 0, 2)) }}
                                    </div>
                                    <span class="fw-medium text-14 text-neutral-500">{{ $student->last_name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-14 fw-normal text-neutral-500">
                                    {{ optional($student->class)->class_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ $student->created_at }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-24 text-neutral-400">Aucun étudiant.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="col-xl-6">
        <div class="px-24 py-24 bg-white rounded-10">
            <div class="d-flex align-items-center justify-content-between mb-24">
                <h6 class="mb-0 fw-medium text-16 text-neutral-500">Événements à venir</h6>
                <a href="#" class="text-12 fw-medium text-main-600 hover-underline transition-03">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="display min-w-max w-100">
                    <thead>
                        <tr class="bg-main-25 border-bottom">
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Événement</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Date début</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Date fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingEvents as $event)
                        <tr class="hover-bg-neutral-20 border-bottom transition-03">
                            <td class="py-16 px-20 shadow-none">
                                <span class="fw-medium text-14 text-neutral-500">{{ $event->event_title }}</span>
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-24 text-neutral-400">Aucun événement à venir.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ═══ LEAVE REQUESTS + MESSAGES ══════════════════════════════════════════════ --}}
<div class="row gy-4">

    {{-- Pending leave requests --}}
    <div class="col-xl-6">
        <div class="px-24 py-24 bg-white rounded-10">
            <div class="d-flex align-items-center justify-content-between mb-24">
                <h6 class="mb-0 fw-medium text-16 text-neutral-500">Demandes de congé en attente</h6>
                <span class="badge bg-warning text-dark">{{ $pendingLeaves->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="display min-w-max w-100">
                    <thead>
                        <tr class="bg-main-25 border-bottom">
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Étudiant</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Motif</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingLeaves as $leave)
                        <tr class="hover-bg-neutral-20 border-bottom transition-03">
                            <td class="py-16 px-20 shadow-none text-14 text-neutral-500">
                                {{ optional($leave->student)->display_name ?? 'N/A' }}
                            </td>
                            <td class="py-16 px-20 shadow-none text-14 text-neutral-500">
                                {{ Str::limit($leave->leave_reason, 40) }}
                            </td>
                            <td class="py-16 px-20 shadow-none">
                                <div class="d-flex gap-8">
                                    <form action="{{ route('admin.leaves.approve', $leave->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-success">Approuver</button>
                                    </form>
                                    <form action="{{ route('admin.leaves.reject', $leave->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-danger">Rejeter</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-24 text-neutral-400">Aucune demande en attente.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
@endsection


@push('scripts')
<script>
// ── Enrollment line chart ────────────────────────────────────────────────────
var enrollmentChart = new ApexCharts(document.querySelector("#enrollmentChart"), {
    series: [
        { name: 'Étudiants inscrits', data: {!! json_encode($chartData['students'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!} },
        { name: 'Frais (×1000 FCFA)', data: {!! json_encode($chartData['fees'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!} },
    ],
    chart: { height: 300, type: 'line', toolbar: { show: false }, zoom: { enabled: false } },
    colors: ['#066AC9', '#F37639'],
    stroke: { curve: 'smooth', width: 2 },
    dataLabels: { enabled: false },
    xaxis: { categories: ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Aoû','Sep','Oct','Nov','Déc'] },
    grid: { borderColor: '#e7e7e7' },
    legend: { show: false },
    markers: { size: 3 },
});
enrollmentChart.render();

// ── Distribution donut chart ─────────────────────────────────────────────────
var distChart = new ApexCharts(document.querySelector("#distributionChart"), {
    series: [
        {{ $stats['total_students'] ?? 0 }},
        {{ $stats['total_teachers'] ?? 0 }},
        {{ $stats['total_classes'] ?? 0 }},
    ],
    labels: ['Étudiants', 'Enseignants', 'Classes'],
    chart: { type: 'donut', height: 220 },
    colors: ['#066AC9', '#22C55E', '#F59E0B'],
    legend: { show: false },
    dataLabels: { enabled: true },
});
distChart.render();
</script>
@endpush