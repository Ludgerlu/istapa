@extends('layouts.app')

@section('title', 'Fees — ' . $student->name)
@section('page-title', $student->name . ' — Fee details')

@section('topbar-actions')
    <a href="{{ route('fees.index') }}" class="btn">← Back</a>
    <a href="{{ route('fees.create-payment') }}?student_id={{ $student->id }}" class="btn btn-primary">+ Record payment</a>
@endsection

@section('content')

@if($fee)
    @php
        $balance = $fee->total_amount - $fee->amount_paid;
        $rate    = $fee->total_amount > 0 ? round(($fee->amount_paid / $fee->total_amount) * 100) : 0;
        $statusBadge = ['paid' => 'badge-green', 'partial' => 'badge-amber', 'unpaid' => 'badge-red'];
    @endphp

    {{-- Summary --}}
    <div class="stats-grid" style="max-width:600px">
        <div class="stat-card">
            <div class="stat-label">Total fees</div>
            <div class="stat-value">{{ number_format($fee->total_amount) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Paid</div>
            <div class="stat-value green">{{ number_format($fee->amount_paid) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Balance</div>
            <div class="stat-value {{ $balance > 0 ? 'red' : 'green' }}">{{ number_format($balance) }}</div>
        </div>
    </div>

    <div class="card" style="max-width:600px;margin-bottom:1rem">
        <div style="display:flex;justify-content:space-between;margin-bottom:6px">
            <span style="font-size:13px;color:#888780">Payment progress</span>
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:13px;font-weight:500">{{ $rate }}%</span>
                <span class="badge {{ $statusBadge[$fee->status] ?? 'badge-gray' }}">{{ ucfirst($fee->status) }}</span>
            </div>
        </div>
        <div class="progress" style="height:10px">
            <div class="progress-bar {{ $rate >= 100 ? 'bg-green' : ($rate > 0 ? 'bg-amber' : 'bg-red') }}"
                 style="width:{{ $rate }}%"></div>
        </div>
    </div>

    {{-- Payment history --}}
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem">Payment history</div>
        @if($payments->count())
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th>Notes</th>
                        <th>Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->paid_at->format('d M Y') }}</td>
                            <td style="font-weight:500">{{ number_format($payment->amount) }} FCFA</td>
                            <td>
                                @php
                                    $methodLabel = ['cash'=>'Cash','mobile_money'=>'Mobile Money','bank_transfer'=>'Bank transfer','cheque'=>'Cheque'];
                                @endphp
                                <span class="badge badge-gray">{{ $methodLabel[$payment->method] ?? $payment->method }}</span>
                            </td>
                            <td style="color:#888780">{{ $payment->reference ?? '—' }}</td>
                            <td style="color:#888780">{{ $payment->notes ?? '—' }}</td>
                            <td>
                                <a href="{{ route('fees.receipt', $payment) }}" class="btn btn-sm" target="_blank">
                                    🖨 Print
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#888780;font-size:13px">No payments recorded yet.</p>
        @endif
    </div>

@else
    <div class="card">
        <p style="color:#888780;font-size:13px;margin-bottom:1rem">
            No fee record found for {{ $student->name }} this academic year.
        </p>
        <a href="{{ route('fees.create-payment') }}?student_id={{ $student->id }}" class="btn btn-primary">
            Record first payment
        </a>
    </div>
@endif

@endsection
