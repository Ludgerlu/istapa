{{-- resources/views/admin/blog/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Blog — Articles')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-24 flex-wrap gap-12">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Articles du blog</h4>
    <a href="{{ route('admin.blogs.create') }}"
       class="btn px-20 py-10 bg-main-600 text-white rounded-pill text-14 d-flex align-items-center gap-8">
        <i class="ph ph-plus-circle"></i> Nouvel article
    </a>
</div>

{{-- Filters --}}
<div class="bg-white rounded-10 px-20 py-16 mb-4 d-flex align-items-center gap-16 flex-wrap">
    <form action="{{ route('admin.blogs.index') }}" method="GET" class="d-flex gap-12 flex-wrap align-items-center w-100">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un article…"
               class="form-control text-14 border-neutral-40 rounded-pill ps-16" style="max-width:280px">
        <select name="status" class="form-select text-14 border-neutral-40 w-auto">
            <option value="">Tous les statuts</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Brouillon</option>
            <option value="archived"  {{ request('status') === 'archived'  ? 'selected' : '' }}>Archivé</option>
        </select>
        <button type="submit" class="btn bg-main-600 text-white rounded-pill px-20 py-9 text-14">Filtrer</button>
        @if(request()->anyFilled(['q','status']))
            <a href="{{ route('admin.blogs.index') }}" class="text-14 text-neutral-400 hover-text-main-600">Réinitialiser</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-10 px-24 py-24">
    <div class="overflow-x-auto">
        <table class="display w-100" id="blogsTable">
            <thead>
                <tr class="bg-main-25 border-bottom">
                    <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Titre</th>
                    <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Auteur</th>
                    <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Statut</th>
                    <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Date</th>
                    <th class="text-12 fw-medium text-neutral-500 py-16 px-20">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                <tr class="hover-bg-neutral-20 border-bottom transition-03">
                    <td class="py-16 px-20 shadow-none">
                        <div class="d-flex align-items-center gap-12">
                            @if($blog->cover_image)
                            <img src="{{ asset('app/' . $blog->cover_image) }}"
                                 alt="" class="rounded-8" style="width:56px;height:40px;object-fit:cover">
                            @else
                            <div class="rounded-8 bg-main-25 d-flex align-items-center justify-content-center"
                                 style="width:56px;height:40px">
                                <i class="ph ph-article text-main-600 text-20"></i>
                            </div>
                            @endif
                            <div>
                                <span class="fw-medium text-14 text-neutral-500 d-block">{{ Str::limit($blog->title, 50) }}</span>
                                <span class="text-12 text-neutral-400">{{ Str::limit($blog->excerpt_or_trimmed, 60) }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-16 px-20 shadow-none text-14 text-neutral-500">
                        {{ $blog->author->display_name ?? '—' }}
                    </td>
                    <td class="py-16 px-20 shadow-none">
                        @switch($blog->status)
                            @case('published')
                                <span class="badge bg-success-100 text-success-600 px-12 py-6 rounded-pill text-12">Publié</span>
                                @break
                            @case('draft')
                                <span class="badge bg-warning-100 text-warning-600 px-12 py-6 rounded-pill text-12">Brouillon</span>
                                @break
                            @case('archived')
                                <span class="badge bg-neutral-100 text-neutral-500 px-12 py-6 rounded-pill text-12">Archivé</span>
                                @break
                        @endswitch
                    </td>
                    <td class="py-16 px-20 shadow-none text-14 text-neutral-500">
                        {{ $blog->created_at }}
                    </td>
                    <td class="py-16 px-20 shadow-none">
                        <div class="d-flex align-items-center gap-8">
                            <a href="{{ route('admin.blogs.show', $blog->id) }}"
                               class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-neutral-500 hover-bg-main-600 hover-text-white transition-03"
                               title="Voir">
                                <i class="ph ph-eye text-14"></i>
                            </a>
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                               class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-neutral-500 hover-bg-main-600 hover-text-white transition-03"
                               title="Modifier">
                                <i class="ph ph-pencil text-14"></i>
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                  onsubmit="return confirm('Supprimer cet article ?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-32 h-32 rounded-circle border border-neutral-40 d-flex align-items-center justify-content-center text-neutral-500 hover-bg-danger hover-text-white transition-03 bg-transparent"
                                        title="Supprimer">
                                    <i class="ph ph-trash text-14"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-40 text-neutral-400">
                        <i class="ph ph-newspaper text-40 d-block mb-8 text-neutral-300"></i>
                        Aucun article trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-20 d-flex justify-content-end">
        {{ $blogs->withQueryString()->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#blogsTable').DataTable({ paging: false, searching: false, info: false, ordering: true });
</script>
@endpush