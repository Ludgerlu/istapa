@extends('layouts.admin')

@section('title', 'Gestion des présences')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Sessions de présence</h4>
    <a href="{{ route('admin.attendances.create') }}" class="btn btn-main rounded-pill">
        <i class="ph ph-plus-circle"></i> Nouvelle session
    </a>
</div>

{{-- Filter bar --}}
<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label text-14">Matière</label>
            <select name="subject_id" class="form-select">
                <option value="">Toutes les matières</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label text-14">Date de début</label>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label text-14">Date de fin</label>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-main w-100">Filtrer</button>
            <a href="{{ route('admin.classes.attendances', $class) }}" class="btn btn-outline-secondary w-100 mt-2">Réinitialiser</a>
        </div>
    </form>
</div>

{{-- Sessions list --}}
<div class="bg-white rounded-10 p-24">
    @if($sessions->count())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-main-25">
                    <tr>
                        <th>#</th>
                        <th>Classe</th>
                        <th>Matière</th>
                        <th>Date</th>
                        <th>Horaire</th>
                        <th>Enseignant</th>
                        <th>Présents / Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                    @php
                        $total = $session->details->count();
                        $present = $session->details->where('status', 'present')->count();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $session->class->name ?? '—' }}</td>
                        <td>{{ $session->subject->name ?? '—' }}</td>
                        <td>{{ $session->session_date->format('d/m/Y') }}</td>
                        <td>
                            {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '—' }}
                            -
                            {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '—' }}
                        </td>
                        <td>{{ $session->takenBy->full_name ?? '—' }}</td>
                        <td>
                            <span class="badge bg-success-600">{{ $present }}</span>
                            /
                            <span class="badge bg-secondary">{{ $total }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.attendances.show', $session) }}" class="btn btn-sm btn-outline-primary">
                                <i class="ph ph-eye"></i>
                            </a>
                            <a href="{{ route('admin.attendances.edit', $session) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ph ph-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-20 d-flex justify-content-end">
            {{ $sessions->links() }}
        </div>
    @else
        <p class="text-muted text-center py-40">Aucune session de présence trouvée.</p>
    @endif
</div>
@endsection