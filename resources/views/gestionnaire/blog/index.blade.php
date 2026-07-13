@extends('layouts.admin')

@section('title', 'Blog gestionnaire')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-24 flex-wrap gap-12">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Gestion des articles</h4>
    <a href="{{ route('gestionnaire.blogs.create') }}" class="btn px-20 py-10 bg-main-600 text-white rounded-pill text-14 d-flex align-items-center gap-8">
        <i class="ph ph-plus-circle"></i> Nouvel article
    </a>
</div>

<div class="bg-white rounded-10 px-24 py-24">
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr class="bg-main-25">
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                <tr>
                    <td>{{ Str::limit($blog->title_en ?? $blog->title, 50) }}</td>
                    <td>{{ $blog->author->display_name ?? '—' }}</td>
                    <td>{{ ucfirst($blog->status) }}</td>
                    <td>{{ $blog->created_at->format('d/m/Y') }}</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('gestionnaire.blogs.show', $blog) }}" class="btn btn-sm bg-main-600 text-white">Voir</a>
                        <a href="{{ route('gestionnaire.blogs.edit', $blog) }}" class="btn btn-sm bg-neutral-200">Modifier</a>
                        <form action="{{ route('gestionnaire.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm bg-danger-600 text-white">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-40 text-neutral-400">Aucun article trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-24 d-flex justify-content-end">
        {{ $blogs->withQueryString()->links() }}
    </div>
</div>
@endsection
