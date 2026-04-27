@extends('layouts.admin')
@section('title', 'Détails du frais')
@section('content')
<div class="d-flex justify-content-between mb-24">
    <h4>Frais : {{ $fee->category->name }} - {{ $fee->class->name }}</h4>
    <div><a href="{{ route('admin.fees.edit', $fee) }}" class="btn btn-main">Modifier</a></div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="bg-white rounded-10 p-24 mb-24">
            <h5>Informations générales</h5>
            <table class="table table-borderless">
                <tr><th>Classe</th><td>{{ $fee->class->name }}</td></tr>
                <tr><th>Année scolaire</th><td>{{ $fee->academicYear->name }}</td></tr>
                <tr><th>Catégorie</th><td>{{ $fee->category->name }}</td></tr>
                <tr><th>Montant</th><td>{{ number_format($fee->amount, 2) }} FCFA</td></tr>
                <tr><th>Échéance</th><td>{{ $fee->due_date?->format('d/m/Y') ?? 'Non définie' }}</td></tr>
                <tr><th>Description</th><td>{{ $fee->description ?: 'Aucune' }}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="bg-white rounded-10 p-24 mb-24">
            <h5>Récapitulatif des paiements</h5>
            <p><strong>Total payé :</strong> {{ number_format($totalPaid, 2) }} FCFA</p>
            <p><strong>Reste à payer :</strong> {{ number_format($remaining, 2) }} FCFA</p>
            <p><strong>Statut :</strong> 
                @if($remaining <= 0) <span class="badge bg-success-100 text-success-600">Soldé</span>
                @elseif($totalPaid > 0) <span class="badge bg-warning-100 text-warning-600">Partiel</span>
                @else <span class="badge bg-danger-100 text-danger-600">Impayé</span>
                @endif
            </p>
        </div>
    </div>
</div>

<div class="bg-white rounded-10 p-24">
    <h5>Historique des paiements</h5>
    @if($fee->payments->count())
    <table class="table">
        <thead><tr><th>Élève</th><th>Montant payé</th><th>Méthode</th><th>Référence</th><th>Date</th><th>Reçu par</th></tr></thead>
        <tbody>
            @foreach($fee->payments as $payment)
            <tr>
                <td>{{ $payment->student->user->first_name }} {{ $payment->student->user->last_name ?? 'N/A' }}</td>
                <td>{{ number_format($payment->amount_paid, 2) }} FCFA</td>
                <td>{{ $payment->payment_method }}</td>
                <td>{{ $payment->transaction_ref ?? '—' }}</td>
                <td>{{ $payment->paid_on->format('d/m/Y') }}</td>
                <td>{{ $payment->receivedBy->name ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-40 text-muted">Aucun paiement enregistré pour ce frais.</div>
    @endif
</div>
@endsection