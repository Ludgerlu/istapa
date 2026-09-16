@extends('layouts.admin')

@section('title', 'Gestion des programmes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Programmes</h4>
    <a href="{{ route('manager.programs.create') }}" class="btn bg-main-600 text-white rounded-pill">
        <i class="fas fa-plus"></i> Nouveau programme
    </a>
</div>

<div class="bg-white rounded-10 p-24">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Titre (EN/FR)</th>
                    <th>Durée (mois)</th>
                    <th>Statut</th>
                    <th>Vues</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $program)
                <tr>
                    <td>{{ $program->id }}</td>
                    <td>
                        @if($program->cover_image)
                            <img src="{{ asset('storage/' . $program->cover_image) }}" alt="cover" style="height: 40px; width: 40px; object-fit: cover; border-radius: 6px;">
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $program->title_en }}</strong><br>
                        <small class="text-muted">{{ $program->title_fr }}</small>
                    </td>
                    <td>{{ $program->duration_months ?? '—' }}</td>
                    <td>
                        @if($program->is_published)
                            <span class="badge bg-success">Publié</span>
                        @else
                            <span class="badge bg-secondary">Brouillon</span>
                        @endif
                    </td>
                    <td>{{ $program->view_count ?? '—' }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('manager.programs.show', $program) }}" 
                                class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-white bg-main-600 hover-text-white transition-03"
                               title="Voir">
                                <i class="ph ph-eye text-14"></i>
                            </a>
                            <a href="{{ route('manager.programs.edit', $program) }}" 
                                class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-white bg-warning-600 hover-text-white transition-03"
                                title="Modifier">
                                    <i class="ph ph-pencil text-14"></i>
                            </a>
                            <form action="{{ route('manager.programs.destroy', $program) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce programme ?')">
                                @csrf @method('DELETE')
                                <button 
                                        class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-white bg-danger-600 hover-text-white transition-03"
                                        title="Supprimer">
                                    <i class="ph ph-trash text-14"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Aucun programme.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $programs->links() }}
</div>
@endsection