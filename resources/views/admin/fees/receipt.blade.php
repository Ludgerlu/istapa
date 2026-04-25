@extends('layouts.app')

@section('title', 'Receipt #' . $payment->reference)
@section('page-title', 'Payment Receipt')

@section('topbar-actions')
    <button onclick="window.print()" class="btn">🖨 Print</button>
    <a href="{{ route('fees.student', $payment->student) }}" class="btn">← Back</a>
@endsection

@section('content')
<div style="max-width:520px;margin:0 auto">
<div class="card" id="receipt">
    {{-- Header --}}
    <div style="text-align:center;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid #E0DFD8">
        <div style="font-size:20px;margin-bottom:4px">🏫</div>
        <div style="font-size:16px;font-weight:500">EduManager School</div>
        <div style="font-size:12px;color:#888780">Official payment receipt</div>
    </div>

    {{-- Receipt no --}}
    <div style="display:flex;justify-content:space-between;margin-bottom:1rem">
        <div>
            <div style="font-size:11px;color:#888780">Receipt no.</div>
            <div style="font-weight:500">{{ $payment->reference ?? 'REC-' . str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div style="text-align:right">
            <div style="font-size:11px;color:#888780">Date</div>
            <div style="font-weight:500">{{ $payment->paid_at->format('d M Y') }}</div>
        </div>
    </div>

    {{-- Student info --}}
    <div style="background:#F8F8F7;border-radius:8px;padding:.875rem;margin-bottom:1rem">
        <div style="font-size:11px;color:#888780;margin-bottom:.5rem">Received from</div>
        <div style="font-weight:500;font-size:15px">{{ $payment->student->name }}</div>
        <div style="font-size:12px;color:#888780">{{ $payment->student->schoolClass->name ?? '' }}</div>
    </div>

    {{-- Payment details --}}
    <table style="width:100%;font-size:13px">
        <tr>
            <td style="color:#888780;padding:6px 0">Payment for</td>
            <td style="text-align:right;font-weight:500;padding:6px 0">School fees {{ config('school.academic_year', '2025/2026') }}</td>
        </tr>
        <tr>
            <td style="color:#888780;padding:6px 0">Method</td>
            <td style="text-align:right;padding:6px 0">
                @php $methodLabel = ['cash'=>'Cash','mobile_money'=>'Mobile Money','bank_transfer'=>'Bank transfer','cheque'=>'Cheque']; @endphp
                {{ $methodLabel[$payment->method] ?? $payment->method }}
            </td>
        </tr>
        @if($payment->notes)
        <tr>
            <td style="color:#888780;padding:6px 0">Note</td>
            <td style="text-align:right;padding:6px 0">{{ $payment->notes }}</td>
        </tr>
        @endif
        <tr>
            <td colspan="2" style="border-top:1px solid #E0DFD8;padding-top:12px"></td>
        </tr>
        <tr>
            <td style="font-weight:500;padding:4px 0;font-size:15px">Amount received</td>
            <td style="text-align:right;font-weight:500;font-size:18px;color:#3B6D11;padding:4px 0">
                {{ number_format($payment->amount) }} FCFA
            </td>
        </tr>
    </table>

    {{-- Balance --}}
    @php
        $balance = $payment->fee->total_amount - $payment->fee->amount_paid;
    @endphp
    <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #E0DFD8;
                display:flex;justify-content:space-between;font-size:13px">
        <span style="color:#888780">Remaining balance</span>
        <span style="font-weight:500;color:{{ $balance > 0 ? '#A32D2D' : '#3B6D11' }}">
            {{ number_format($balance) }} FCFA
        </span>
    </div>

    {{-- Footer --}}
    <div style="text-align:center;margin-top:1.5rem;padding-top:1rem;border-top:1px solid #E0DFD8;
                font-size:11px;color:#888780">
        Recorded by {{ $payment->recordedBy->name ?? 'Admin' }} · {{ $payment->created_at->format('d M Y, H:i') }}
    </div>
</div>
</div>

<style>
@media print {
    .sidebar, .topbar { display: none !important; }
    .main { margin-left: 0 !important; }
    .content { padding: 0 !important; }
    .btn { display: none !important; }
}
</style>
@endsection
