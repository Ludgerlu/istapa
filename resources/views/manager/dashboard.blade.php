@extends('layouts.admin')

@section('title', 'Tableau de bord Manager')

@section('content')
<h4 class="fw-semibold text-neutral-500 text-20 mb-24">Tableau de bord Manager</h4>

{{-- ═══ KPI CARDS (3 cards now) ═══════════════════════════════════════════ --}}
<div class="row gy-4 mb-4">
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Articles publiés</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($totalBlogs) }}</h6>
                </div>
                <span class="w-44 h-44 bg-main-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-newspaper text-white text-20"></i>
                </span>
            </div>
            <a href="{{ route('manager.blogs.index') }}" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Événements publiés</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($totalEvents) }}</h6>
                </div>
                <span class="w-44 h-44 bg-success-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-calendar text-white text-20"></i>
                </span>
            </div>
            <a href="{{ route('manager.events.index') }}" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>
    {{-- New card for Programs --}}
    <div class="col-xl-4 col-sm-6">
        <div class="px-20 py-20 bg-white rounded-10">
            <div class="d-flex gap-16 justify-content-between mb-12">
                <div>
                    <span class="fw-normal text-14 text-neutral-400 mb-4 d-block">Programmes publiés</span>
                    <h6 class="text-18 fw-semibold text-neutral-500 mb-0">{{ number_format($totalPrograms) }}</h6>
                </div>
                <span class="w-44 h-44 bg-warning-600 rounded-circle justify-content-center align-items-center d-flex flex-shrink-0">
                    <i class="ph ph-graduation-cap text-white text-20"></i>
                </span>
            </div>
            <a href="{{ route('manager.programs.index') }}" class="text-12 fw-medium text-main-600 text-decoration-underline transition-03">Voir tout</a>
        </div>
    </div>
</div>

{{-- ═══ CHART: Monthly Views (3 series) ═══════════════════════════════════ --}}
<div class="row gy-4 mb-4">
    <div class="col-xl-12">
        <div class="bg-white px-20 py-20 rounded-10">
            <div class="d-flex align-items-center justify-content-between gap-24 mb-4">
                <span class="text-16 fw-medium text-neutral-400">Vues mensuelles (blogs, événements et programmes)</span>
            </div>
            <div id="viewsChart"></div>
            <div class="d-flex justify-content-center gap-24 mt-12 flex-wrap">
                <span class="text-14 fw-normal d-flex align-items-center gap-8 text-neutral-500">
                    <span class="w-6 h-6 bg-main-600 rounded-circle"></span> Blogs
                </span>
                <span class="text-14 fw-normal d-flex align-items-center gap-8 text-neutral-500">
                    <span class="w-6 h-6 bg-warning-600 rounded-circle"></span> Événements
                </span>
                <span class="text-14 fw-normal d-flex align-items-center gap-8 text-neutral-500">
                    <span class="w-6 h-6 bg-success-600 rounded-circle"></span> Programmes
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ═══ BAR CHART: Top viewed programs ════════════════════════════════════ --}}
<div class="row gy-4 mb-4">
    <div class="col-xl-12">
        <div class="bg-white px-20 py-20 rounded-10">
            <div class="d-flex align-items-center justify-content-between gap-24 mb-4">
                <span class="text-16 fw-medium text-neutral-400">Top programmes vus</span>
            </div>
            <div id="programViewsBarChart"></div>
        </div>
    </div>
</div>

{{-- ═══ LATEST RECORDS (3 columns) ════════════════════════════════════════ --}}
<div class="row gy-4">
    {{-- Latest Blogs --}}
    <div class="col-xl-4">
        <div class="px-24 py-24 bg-white rounded-10">
            <div class="d-flex align-items-center justify-content-between mb-24">
                <h6 class="mb-0 fw-medium text-16 text-neutral-500">Derniers articles</h6>
                <a href="{{ route('manager.blogs.index') }}" class="text-12 fw-medium text-main-600 hover-underline transition-03">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="display min-w-max w-100">
                    <thead>
                        <tr class="bg-main-25 border-bottom">
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Titre</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Auteur</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Publié le</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestBlogs as $blog)
                        <tr class="hover-bg-neutral-20 border-bottom transition-03">
                            <td class="py-16 px-20 shadow-none">
                                <span class="fw-medium text-14 text-neutral-500">{{ $blog->title_en }}</span>
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ optional($blog->author)->display_name ?? 'N/A' }}
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ optional($blog->published_at)->format('d/m/Y') ?? '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-24 text-neutral-400">Aucun article.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Latest Events --}}
    <div class="col-xl-4">
        <div class="px-24 py-24 bg-white rounded-10">
            <div class="d-flex align-items-center justify-content-between mb-24">
                <h6 class="mb-0 fw-medium text-16 text-neutral-500">Derniers événements</h6>
                <a href="{{ route('manager.events.index') }}" class="text-12 fw-medium text-main-600 hover-underline transition-03">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="display min-w-max w-100">
                    <thead>
                        <tr class="bg-main-25 border-bottom">
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Titre</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Début</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestEvents as $event)
                        <tr class="hover-bg-neutral-20 border-bottom transition-03">
                            <td class="py-16 px-20 shadow-none">
                                <span class="fw-medium text-14 text-neutral-500">{{ $event->title_en }}</span>
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-24 text-neutral-400">Aucun événement.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Latest Programs (new) --}}
    <div class="col-xl-4">
        <div class="px-24 py-24 bg-white rounded-10">
            <div class="d-flex align-items-center justify-content-between mb-24">
                <h6 class="mb-0 fw-medium text-16 text-neutral-500">Derniers programmes</h6>
                <a href="{{ route('manager.programs.index') }}" class="text-12 fw-medium text-main-600 hover-underline transition-03">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="display min-w-max w-100">
                    <thead>
                        <tr class="bg-main-25 border-bottom">
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Titre</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Durée</th>
                            <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Créé le</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPrograms as $program)
                        <tr class="hover-bg-neutral-20 border-bottom transition-03">
                            <td class="py-16 px-20 shadow-none">
                                <span class="fw-medium text-14 text-neutral-500">{{ $program->title_en }}</span>
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ $program->duration_months ? $program->duration_months.' mois' : '—' }}
                            </td>
                            <td class="text-14 fw-normal py-16 px-20 shadow-none text-neutral-500">
                                {{ $program->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-24 text-neutral-400">Aucun programme.</td></tr>
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
var viewsChart = new ApexCharts(document.querySelector("#viewsChart"), {
    series: [
        { name: 'Blogs', data: {!! json_encode($chartData['blogs'] ?? array_fill(0,12,0)) !!} },
        { name: 'Événements', data: {!! json_encode($chartData['events'] ?? array_fill(0,12,0)) !!} },
        { name: 'Programmes', data: {!! json_encode($chartData['programs'] ?? array_fill(0,12,0)) !!} }, // 👈 new series
    ],
    chart: { height: 300, type: 'line', toolbar: { show: false }, zoom: { enabled: false } },
    colors: ['#066AC9', '#F59E0B', '#10B981'], 
    stroke: { curve: 'smooth', width: 2 },
    dataLabels: { enabled: false },
    xaxis: { categories: ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Aoû','Sep','Oct','Nov','Déc'] },
    grid: { borderColor: '#e7e7e7' },
    legend: { show: false },
    markers: { size: 3 },
});
viewsChart.render();
</script>

<script>
    // Bar chart for top programs
    var programBarChart = new ApexCharts(document.querySelector("#programViewsBarChart"), {
        series: [{
            name: 'Vues',
            data: {!! json_encode($programViews ?? []) !!}
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 4,
            }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: {!! json_encode($programLabels ?? []) !!},
            labels: { rotate: -45, trim: true },
        },
        colors: ['#066AC9'],
        grid: { borderColor: '#e7e7e7' },
    });
    programBarChart.render();
</script>
@endpush