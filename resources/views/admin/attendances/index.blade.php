@extends('layouts.admin')

@section('title', 'Gestion des présences')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>Sessions de présence</h4>
    <a href="{{ route('admin.attendances.create') }}" class="btn btn-main rounded-pill"><i class="ph ph-plus-circle"></i> Nouvelle présence</a>
</div>

<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-3"><label>Classe</label><select name="class_id" class="form-select"><option value="">Toutes</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id')==$c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><label>Matière</label><select name="subject_id" class="form-select"><option value="">Toutes</option>@foreach($subjects as $s)<option value="{{ $s->id }}" {{ request('subject_id')==$s->id ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
        <div class="col-md-2"><label>Du</label><input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}"></div>
        <div class="col-md-2"><label>Au</label><input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}"></div>
        <div class="col-md-2 d-flex align-items-end"><button type="submit" class="btn btn-main w-100">Filtrer</button></div>
    </form>
</div>

<div class="bg-white rounded-10 p-24">
    <div class="overflow-x-auto">
        <table class="table">
            <thead class="bg-main-25">
                <td><th>Classe</th><th>Matière</th><th>Date</th><th>Horaire</th><th>Enregistré par</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($sessions as $session)
                <tr>
                    <td>{{ $session->class->name ?? '—' }}</td>
                    <td>{{ $session->subject->name ?? '—' }}</td>
                    <td>{{ $session->session_date->format('d/m/Y') }}</td>
                    <td>{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '—' }} - {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '—' }}</td>
                    <td>{{ $session->takenBy->first_name ?? '' }} {{ $session->takenBy->last_name ?? '' }}</td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('admin.attendances.show', $session) }}" class="btn btn-sm btn-outline-secondary"><i class="ph ph-eye"></i></a>
                        <a href="{{ route('admin.attendances.edit', $session) }}" class="btn btn-sm btn-outline-secondary"><i class="ph ph-pencil"></i></a>
                        <form action="{{ route('admin.attendances.destroy', $session) }}" method="POST" onsubmit="return confirm('Supprimer cette session ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-40">Aucune session de présence. <a href="{{ route('admin.attendances.create') }}">Créer la première</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $sessions->withQueryString()->links() }}
</div>
@endsection