@extends('layouts.admin')

@section('title', 'Messages de contact')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h4 class="fw-semibold text-neutral-500 text-20 mb-0">Messages de contact</h4>
    <div>
        <a href="{{ route('manager.contact-messages.index') }}" class="btn bg-success-600 rounded-pill">Tous</a>
        <a href="{{ route('manager.contact-messages.index', ['status' => 'unread']) }}" class="btn bg-success-600 rounded-pill">Non lus</a>
        <a href="{{ route('manager.contact-messages.index', ['status' => 'read']) }}" class="btn bg-success-600 rounded-pill">Lus</a>
        <a href="{{ route('manager.contact-messages.index', ['status' => 'archived']) }}" class="btn bg-success-600 rounded-pill">Archivés</a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-4 mb-24">
    <div class="col-md-3">
        <div class="bg-white rounded-10 p-20 d-flex align-items-center justify-content-between">
            <div>
                <h6 class="text-muted mb-2">Total</h6>
                <h3 class="mb-0">{{ $stats['total'] }}</h3>
            </div>
            <i class="ph ph-chat-circle text-40 text-main-600"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white rounded-10 p-20 d-flex align-items-center justify-content-between">
            <div>
                <h6 class="text-muted mb-2">Non lus</h6>
                <h3 class="mb-0 text-warning">{{ $stats['unread'] }}</h3>
            </div>
            <i class="ph ph-envelope-simple text-40 text-warning"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white rounded-10 p-20 d-flex align-items-center justify-content-between">
            <div>
                <h6 class="text-muted mb-2">Lus</h6>
                <h3 class="mb-0 text-success">{{ $stats['read'] }}</h3>
            </div>
            <i class="ph ph-check-circle text-40 text-success"></i>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white rounded-10 p-20 d-flex align-items-center justify-content-between">
            <div>
                <h6 class="text-muted mb-2">Archivés</h6>
                <h3 class="mb-0">{{ $stats['archived'] }}</h3>
            </div>
            <i class="ph ph-archive text-40 text-muted"></i>
        </div>
    </div>
</div>

{{-- Filter & Search --}}
<div class="bg-white rounded-10 p-20 mb-24">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label>Rechercher</label>
            <input type="text" name="q" class="form-control" placeholder="Nom, email, sujet..." value="{{ request('q') }}">
        </div>
        <div class="col-md-3">
            <label>Statut</label>
            <select name="status" class="form-select">
                <option value="">Tous</option>
                <option value="new" {{ request('status')=='new' ? 'selected' : '' }}>Non lus</option>
                <option value="read" {{ request('status')=='read' ? 'selected' : '' }}>Lus</option>
                <option value="archived" {{ request('status')=='archived' ? 'selected' : '' }}>Archivés</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-main w-100">Filtrer</button>
        </div>
        <div class="col-md-3 d-flex align-items-end justify-content-end">
            @if(request()->anyFilled(['q', 'status']))
                <a href="{{ route('manager.contact-messages.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
            @endif
        </div>
    </form>
</div>

{{-- Messages Table --}}
<div class="bg-white rounded-10 p-24">
    <div class="overflow-x-auto">
        <table class="table table-bordered">
            <thead class="bg-main-25">
                <tr>
                    <th>Date</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Tel</th>
                    <th>Sujet</th>
                    <th>Message</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr class="{{ $message->status == 'new' ? 'fw-semibold bg-main-50' : '' }}">
                    <td>{{ $message->created_at }}</td>
                    <td>{{ $message->full_name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->phone ?? '—' }}</td>
                    <td>{{ Str::limit($message->subject, 40) }}</td>
                    <td>{{ Str::limit($message->message, 60) }}</td>
                    <td>
                        @if($message->status == 'new')
                            <span class="badge bg-warning-600">Non lu</span>
                        @elseif($message->status == 'read')
                            <span class="badge bg-success-600">Lu</span>
                        @else
                            <span class="badge bg-neutral-400">Archivé</span>
                        @endif
                    </td>
                    <td class="d-flex gap-8">
                        <a href="{{ route('manager.contact-messages.show', $message) }}" class="btn btn-sm bg-success-600 btn-outline-secondary">
                            <i class="ph ph-eye"></i> Voir
                        </a>
                        @if($message->status == 'new')
                            <form action="{{ route('manager.contact-messages.mark-read', $message) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm bg-success-600"><i class="ph ph-check"></i> Marquer lu</button>
                            </form>
                        @elseif($message->status == 'read')
                            <form action="{{ route('manager.contact-messages.mark-unread', $message) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm bg-warning-600"><i class="ph ph-envelope"></i> Marquer non lu</button>
                            </form>
                        @endif
                        <form action="{{ route('manager.contact-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Supprimer ce message ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm bg-danger-600"><i class="ph ph-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-40 text-muted">Aucun message trouvé. </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-24 d-flex justify-content-end">
        {{ $messages->withQueryString()->links() }}
    </div>
</div>
@endsection