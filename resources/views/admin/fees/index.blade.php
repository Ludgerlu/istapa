@extends('layouts.admin')
@section('title', 'Gestion des frais')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>Frais scolaires</h4>
    <a href="{{ route('admin.fees.create') }}" class="btn btn-main rounded-pill"><i class="ph ph-plus"></i> Nouveau frais</a>
</div>

<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-3"><label>Classe</label><select name="class_id" class="form-select"><option value="">Toutes</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id')==$c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><label>Année scolaire</label><select name="academic_year_id" class="form-select"><option value="">Toutes</option>@foreach($academicYears as $y)<option value="{{ $y->id }}" {{ request('academic_year_id')==$y->id ? 'selected' : '' }}>{{ $y->label }}</option>@endforeach</select></div>
        <div class="col-md-3"><label>Catégorie</label><select name="fee_category_id" class="form-select"><option value="">Toutes</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('fee_category_id')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach</select></div>
        <div class="col-md-3 d-flex align-items-end"><button type="submit" class="btn btn-main w-100">Filtrer</button></div>
    </form>
</div>

<div class="bg-white rounded-10 p-24">
    <table class="table">
        <thead><tr><th>Classe</th><th>Année scolaire</th><th>Catégorie</th><th>Montant</th><th>Échéance</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($fees as $fee)
            <tr>
                <td>{{ $fee->class->name ?? '—' }}</td>
                <td>{{ $fee->academicYear->name ?? '—' }}</td>
                <td>{{ $fee->category->name ?? '—' }}</td>
                <td>{{ number_format($fee->amount, 2) }} FCFA</td>
                <td>{{ $fee->due_date?->format('d/m/Y') ?? '—' }}</td>
                <td class="d-flex gap-8">
                    <a href="{{ route('admin.fees.show', $fee) }}" class="btn bg-main-600 text-white px-12 py-6 rounded-pill text-12"><i class="ph ph-eye"></i></a>
                    <a href="{{ route('admin.fees.edit', $fee) }}" class="btn btn-sm bg-warning-100 text-warning-600 px-12 py-6 rounded-pill text-12"><i class="ph ph-pencil"></i></a>
                    <form action="{{ route('admin.fees.destroy', $fee) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm bg-danger-100 text-danger-600 px-12 py-6 rounded-pill text-12"><i class="ph ph-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-40 text-muted">Aucun frais enregistré.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $fees->withQueryString()->links() }}
</div>
@endsection