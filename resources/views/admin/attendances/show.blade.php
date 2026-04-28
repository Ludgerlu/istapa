@extends('layouts.admin')

@section('title', 'Détails de présence')

@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>Détails de la session</h4>
    <div>
        <a href="{{ route('admin.attendances.edit', $attendance) }}" class="btn btn-main rounded-pill"><i class="ph ph-pencil"></i> Modifier</a>
        <a href="{{ route('admin.attendances.index') }}" class="btn btn-outline-secondary rounded-pill">Retour à la liste</a>
    </div>
</div>

<div class="bg-white rounded-10 p-24 mb-24">
    <div class="row">
        <div class="col-md-4"><strong>Classe :</strong> {{ $attendance->class->name ?? '—' }}</div>
        <div class="col-md-4"><strong>Matière :</strong> {{ $attendance->subject->name ?? '—' }}</div>
        <div class="col-md-4"><strong>Date :</strong> {{ $attendance->session_date->format('d/m/Y') }}</div>
        <div class="col-md-4"><strong>Horaire :</strong> {{ $attendance->start_time ? \Carbon\Carbon::parse($attendance->start_time)->format('H:i') : '—' }} - {{ $attendance->end_time ? \Carbon\Carbon::parse($attendance->end_time)->format('H:i') : '—' }}</div>
        <div class="col-md-4"><strong>Enregistré par :</strong> {{ $attendance->takenBy->first_name ?? '' }} {{ $attendance->takenBy->last_name ?? '' }}</div>
        @if($attendance->notes)<div class="col-md-12"><strong>Notes :</strong> {{ $attendance->notes }}</div>@endif
    </div>
</div>

<div class="bg-white rounded-10 p-24">
    <h5 class="mb-16">Liste des présences</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr><th>Élève</th><th>Statut</th><th>Commentaire</th></tr>
            </thead>
            <tbody>
                @forelse($presenceList as $item)
                <tr>
                    <td>{{ $item->student->user->first_name ?? '' }} {{ $item->student->user->last_name ?? '' }}<br><small class="text-muted">{{ $item->student->matricule ?? '' }}</small></td>
                    <td>
                        @switch($item->status)
                            @case('present') <span class="badge bg-success-600">Présent</span> @break
                            @case('absent') <span class="badge bg-danger-600">Absent</span> @break
                            @case('late') <span class="badge bg-warning-600">En retard</span> @break
                            @case('excused') <span class="badge bg-info-600">Excusé</span> @break
                            @default <span class="badge bg-secondary">Non renseigné</span>
                        @endswitch
                    </td>
                    <td>{{ $item->comment ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Aucune donnée de présence.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection