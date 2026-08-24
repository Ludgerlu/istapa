{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
{{--
    Modal de statistiques de vues mensuelles.
    À inclure une seule fois dans votre layout admin (ex: @include('partials.monthly-views-modal')).

    Pour l'ouvrir, ajoutez ces attributs à n'importe quel bouton :
    <button type="button"
            class="btn btn-sm btn-outline-main rounded-pill"
            data-stats-trigger
            data-item-type="blog_post"        {{-- ou "program" --}}
            data-item-id="{{ $blog->id }}"
            data-item-label="{{ $blog->title_fr }}">
        <i class="ph-bold ph-chart-line"></i> Statistiques
    </button>
--}}

<div class="modal fade" id="monthlyViewsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-16 border-0">
            <div class="modal-header border-bottom border-neutral-30 px-24 py-20">
                <div>
                    <h5 class="modal-title mb-4" id="monthlyViewsModalLabel">Statistiques de vues</h5>
                    <span class="text-neutral-500 text-sm" id="monthlyViewsModalItem"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <div class="modal-body px-24 py-24">
                <!-- Bascule Cumul / Mensuel -->
                <div class="flex-align gap-8 mb-24">
                    <button type="button" class="btn btn-sm btn-main rounded-pill px-16" data-views-mode="month_views">
                        Vues du mois
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-main rounded-pill px-16" data-views-mode="cumulative_views">
                        Cumul
                    </button>
                </div>

                <!-- États -->
                <div id="monthlyViewsLoading" class="text-center py-40 text-neutral-500">
                    Chargement des statistiques...
                </div>
                <div id="monthlyViewsEmpty" class="text-center py-40 text-neutral-500 d-none">
                    Pas encore de données de vues pour cet élément.
                </div>

                <div id="monthlyViewsContent" class="d-none">
                    <div style="height: 260px;">
                        <canvas id="monthlyViewsChart"></canvas>
                    </div>

                    <div class="table-responsive mt-32">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr class="text-neutral-500">
                                    <th class="fw-medium">Mois</th>
                                    <th class="fw-medium text-end">Vues du mois</th>
                                    <th class="fw-medium text-end">Cumul</th>
                                </tr>
                            </thead>
                            <tbody id="monthlyViewsTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
{{-- Chart.js (une seule fois même si le modal est inclus sur plusieurs pages) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>

<script>
(function () {
    const MONTH_LABELS = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
    const STATS_ENDPOINT = "{{ route('admin.stats.monthly-views') }}";

    let chartInstance = null;
    let currentRows = [];
    let currentMode = 'month_views';
    const modalEl = document.getElementById('monthlyViewsModal');
    const modal = modalEl ? new bootstrap.Modal(modalEl) : null;

    function setMode(mode) {
        currentMode = mode;
        document.querySelectorAll('[data-views-mode]').forEach(btn => {
            const active = btn.dataset.viewsMode === mode;
            btn.classList.toggle('btn-main', active);
            btn.classList.toggle('btn-outline-main', !active);
        });
        renderChart();
    }

    function renderChart() {
        const ctx = document.getElementById('monthlyViewsChart');
        if (!ctx) return;

        const labels = currentRows.map(r => `${MONTH_LABELS[r.month - 1]} ${r.year}`);
        const data = currentRows.map(r => r[currentMode]);
        const label = currentMode === 'month_views' ? 'Vues du mois' : 'Vues cumulées';

        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(ctx, {
            type: currentMode === 'month_views' ? 'bar' : 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: 'rgba(46, 125, 50, 0.35)',
                    borderColor: 'rgba(46, 125, 50, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: currentMode === 'cumulative_views',
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }

    function renderTable() {
        const body = document.getElementById('monthlyViewsTableBody');
        body.innerHTML = currentRows.map(r => `
            <tr>
                <td>${MONTH_LABELS[r.month - 1]} ${r.year}</td>
                <td class="text-end">${r.month_views.toLocaleString('fr-FR')}</td>
                <td class="text-end">${r.cumulative_views.toLocaleString('fr-FR')}</td>
            </tr>
        `).join('');
    }

    async function openStatsModal(itemType, itemId, itemLabel) {
        document.getElementById('monthlyViewsModalItem').textContent = itemLabel || '';
        document.getElementById('monthlyViewsLoading').classList.remove('d-none');
        document.getElementById('monthlyViewsEmpty').classList.add('d-none');
        document.getElementById('monthlyViewsContent').classList.add('d-none');
        modal?.show();

        try {
            const url = new URL(STATS_ENDPOINT, window.location.origin);
            url.searchParams.set('item_type', itemType);
            url.searchParams.set('item_id', itemId);

            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Erreur réseau');
            const data = await res.json();

            currentRows = data.rows || [];
            document.getElementById('monthlyViewsLoading').classList.add('d-none');

            if (currentRows.length === 0) {
                document.getElementById('monthlyViewsEmpty').classList.remove('d-none');
                return;
            }

            document.getElementById('monthlyViewsContent').classList.remove('d-none');
            setMode('month_views');
            renderTable();
        } catch (err) {
            document.getElementById('monthlyViewsLoading').classList.add('d-none');
            document.getElementById('monthlyViewsEmpty').textContent = 'Impossible de charger les statistiques. Veuillez réessayer.';
            document.getElementById('monthlyViewsEmpty').classList.remove('d-none');
        }
    }

    // Ouverture via délégation d'événement : fonctionne même pour des boutons ajoutés dynamiquement
    document.addEventListener('click', function (e) {
        const trigger = e.target.closest('[data-stats-trigger]');
        if (trigger) {
            openStatsModal(trigger.dataset.itemType, trigger.dataset.itemId, trigger.dataset.itemLabel);
            return;
        }
        const modeBtn = e.target.closest('[data-views-mode]');
        if (modeBtn) {
            setMode(modeBtn.dataset.viewsMode);
        }
    });
})();
</script>
@endpush