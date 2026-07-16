@extends('layouts.admin')

@section('title', 'Événements')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-24 flex-wrap gap-12">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Événements</h4>
    <a href="{{ route('manager.events.create') }}" class="btn px-20 py-10 bg-main-600 text-white rounded-pill">
        <i class="ph ph-plus-circle"></i> Nouvel événement
    </a>
</div>

<div class="bg-white rounded-10 px-20 py-16 mb-4">
    <form action="{{ route('manager.events.index') }}" method="GET" class="d-flex gap-12 flex-wrap align-items-center">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher…" class="form-control text-14" style="max-width:250px">
        <select name="status" class="form-select w-auto">
            <option value="">Tous</option>
            <option value="published" {{ request('status')=='published' ? 'selected' : '' }}>Publiés</option>
            <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Brouillons</option>
        </select>
        <button type="submit" class="btn bg-main-600 text-white rounded-pill px-20">Filtrer</button>
        @if(request()->anyFilled(['q','status']))
            <a href="{{ route('manager.events.index') }}" class="text-neutral-400">Réinitialiser</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-10 px-24 py-24">
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr><th>Titre</th><th>Date</th><th>Lieu</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-12">
                            @if($event->cover_image)
                                <img src="{{ asset('storage/'.$event->cover_image) }}" width="50" height="40" class="rounded-8 object-fit-cover">
                            @else
                                <div class="rounded-8 bg-main-25 d-flex align-items-center justify-content-center" style="width:50px;height:40px">
                                    <i class="ph ph-calendar text-main-600"></i>
                                </div>
                            @endif
                            <span>{{ $event->title }}</span>
                        </div>
                    </td>
                    <td>{{ $event->start_date->format('d/m/Y') }} @if($event->start_time) {{ $event->start_time }} @endif</td>
                    <td>{{ $event->location ?: '—' }}</td>
                    <td>@if($event->is_published) <span class="badge bg-success-100 text-success-600">Publié</span> @else <span class="badge bg-neutral-100 text-neutral-500">Brouillon</span> @endif</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('manager.events.show', $event) }}" class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-neutral-500 hover-bg-main-600 hover-text-white transition-03"><i class="ph ph-eye"></i></a>
                        <a href="{{ route('manager.events.edit', $event) }}" class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-neutral-500 hover-bg-main-600 hover-text-white transition-03"><i class="ph ph-pencil"></i></a>
                        <form action="{{ route('manager.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-neutral-500 hover-bg-danger hover-text-white transition-03 bg-transparent"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-40 text-neutral-400">Aucun événement.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $events->withQueryString()->links() }}
</div>
@endsection