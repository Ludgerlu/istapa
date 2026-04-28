<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead class="bg-main-25">
            <tr><th>Élève</th><th>Statut</th><th>Commentaire</th></tr>
        </thead>
        <tbody>
            @forelse($presenceList as $item)
            @php $student = $item['student']; @endphp
            <tr>
                <td>{{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? '' }}<br><small class="text-muted">{{ $student->matricule ?? '' }}</small></td>
                <td>
                    @switch($item['status'])
                        @case('present') <span class="badge bg-success-600">Présent</span> @break
                        @case('absent') <span class="badge bg-danger-600">Absent</span> @break
                        @case('late') <span class="badge bg-warning-600">En retard</span> @break
                        @case('excused') <span class="badge bg-info-600">Excusé</span> @break
                        @default <span class="badge bg-secondary">Non renseigné</span>
                    @endswitch
                </td>
                <td>{{ $item['comment'] ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center">Aucun élève inscrit dans cette classe.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>