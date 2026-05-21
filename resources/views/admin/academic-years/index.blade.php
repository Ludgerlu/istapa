@extends('layouts.admin')

@section('title', 'Années académiques')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Années académiques</h4>
    <a href="{{ route('admin.academic-years.create') }}" class="btn btn-main rounded-pill"><i class="ph ph-plus-circle"></i> Nouvelle année</a>
</div>

<div class="bg-white rounded-10 p-24">
    <div class="overflow-x-auto">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr>
                    <th>Libellé</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Année en cours</th>
                    <th>Classes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($academicYears as $year)
                <tr>
                    <td>{{ $year->label }}</td>
                    <td>{{ $year->start_date->format('d/m/Y') }}</td>
                    <td>{{ $year->end_date->format('d/m/Y') }}</td>
                    <td>
                        @if($year->is_current)
                            <span class="badge bg-success-600"><i class="ph ph-check-circle"></i> Actuelle</span>
                        @else
                            <span class="badge bg-neutral-400">—</span>
                        @endif
                    </td>
                    <td>{{ $year->classes_count ?? $year->classes->count() ?? 0 }}</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('admin.academic-years.show', $year) }}" class="btn btn-sm btn-outline-secondary"><i class="ph ph-eye"></i></a>
                        <a href="{{ route('admin.academic-years.edit', $year) }}" class="btn btn-sm btn-outline-secondary"><i class="ph ph-pencil"></i></a>
                        <form action="{{ route('admin.academic-years.destroy', $year) }}" method="POST" onsubmit="return confirm('Supprimer cette année académique ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-40 text-muted">Aucune année académique enregistrée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-24 d-flex justify-content-end">
        {{ $academicYears->links() }}
    </div>
</div>
@endsection