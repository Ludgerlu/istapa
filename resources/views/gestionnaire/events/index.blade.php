@extends('layouts.admin')

@section('title', 'Événements gestionnaire')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-24 flex-wrap gap-12">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Gestion des événements</h4>
    <a href="{{ route('gestionnaire.events.create') }}" class="btn px-20 py-10 bg-main-600 text-white rounded-pill">
        <i class="ph ph-plus-circle"></i> Nouvel événement
    </a>
</div>

<div class="bg-white rounded-10 px-24 py-24">
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr class="bg-main-25">
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr>
                    <td>{{ Str::limit($event->title_en ?? $event->title, 50) }}</td>
                    <td>{{ optional($event->start_date)->format('d/m/Y') }}</td>
                    <td>{{ $event->location ?: '—' }}</td>
                    <td>{{ $event->is_published ? 'Publié' : 'Brouillon' }}</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('gestionnaire.events.show', $event) }}" class="btn btn-sm bg-main-600 text-white">Voir</a>
                        <a href="{{ route('gestionnaire.events.edit', $event) }}" class="btn btn-sm bg-neutral-200">Modifier</a>
                        <form action="{{ route('gestionnaire.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Supprimer cet événement ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm bg-danger-600 text-white">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-40 text-neutral-400">Aucun événement trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-24 d-flex justify-content-end">
        {{ $events->withQueryString()->links() }}
    </div>
</div>
@endsection
