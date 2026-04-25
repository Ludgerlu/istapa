@extends('layouts.app')

@section('title', 'Fees')
@section('page-title', 'Fees Management')

@section('topbar-actions')
    <a href="{{ route('fees.create-payment') }}" class="btn btn-primary">+ Record payment</a>
    <a href="{{ route('fees.structure') }}" class="btn">Fee structure</a>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Expected (term)</div>
        <div class="stat-value">{{ number_format($stats['expected']) }} FCFA</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Collected</div>
        <div class="stat-value green">{{ number_format($stats['collected']) }} FCFA</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Outstanding</div>
        <div class="stat-value red">{{ number_format($stats['outstanding']) }} FCFA</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Paid in full</div>
        <div class="stat-value">{{ $stats['paid_full'] }} students</div>
    </div>
</div>

{{-- Collection progress --}}
@php
    $collectionRate = $stats['expected'] > 0
        ? round(($stats['collected'] / $stats['expected']) * 100)
        : 0;
@endphp
<div class="card" style="margin-bottom:1rem">
    <div style="display:flex;justify-content:space-between;margin-bottom:6px">
        <span style="font-size:13px;color:#888780">Collection progress</span>
        <span style="font-size:13px;font-weight:500">{{ $collectionRate }}%</span>
    </div>
    <div class="progress" style="height:10px">
        <div class="progress-bar {{ $collectionRate >= 80 ? 'bg-green' : ($collectionRate >= 50 ? 'bg-amber' : 'bg-red') }}"
             style="width:{{ $collectionRate }}%"></div>
    </div>
</div>

{{-- Filters + table --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">Student fees</span>
        <form method="GET" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
            <input name="search" placeholder="Search student…" value="{{ request('search') }}" style="width:160px">
            <select name="status" onchange="this.form.submit()">
                <option value="">All status</option>
                <option value="paid"    {{ request('status') === 'paid'    ? 'selected' : '' }}>Paid</option>
                <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>Partial</option>
                <option value="unpaid"  {{ request('status') === 'unpaid'  ? 'selected' : '' }}>Unpaid</option>
            </select>
            <button type="submit" class="btn">Filter</button>
            @if(request()->hasAny(['status','search']))
                <a href="{{ route('fees.index') }}" class="btn">Clear</a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Class</th>
                    <th>Total fees</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fees as $fee)
                    @php
                        $balance   = $fee->total_amount - $fee->amount_paid;
                        $statusBadge = ['paid' => 'badge-green', 'partial' => 'badge-amber', 'unpaid' => 'badge-red'];
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center">
                                <div class="avatar" style="background:#E6F1FB;color:#185FA5">
                                    {{ strtoupper(substr($fee->student->name, 0, 2)) }}
                                </div>
                                <a href="{{ route('fees.student', $fee->student) }}"
                                   style="color:inherit;text-decoration:none;font-weight:500">
                                    {{ $fee->student->name }}
                                </a>
                            </div>
                        </td>
                        <td style="color:#888780">{{ $fee->student->schoolClass->name ?? '—' }}</td>
                        <td>{{ number_format($fee->total_amount) }}</td>
                        <td>{{ number_format($fee->amount_paid) }}</td>
                        <td style="{{ $balance > 0 ? 'color:#A32D2D;font-weight:500' : 'color:#888780' }}">
                            {{ number_format($balance) }}
                        </td>
                        <td>
                            <span class="badge {{ $statusBadge[$fee->status] ?? 'badge-gray' }}">
                                {{ ucfirst($fee->status) }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a href="{{ route('fees.student', $fee->student) }}" class="btn btn-sm">Details</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;color:#888780;padding:2rem">
                            No fee records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($fees->hasPages())
        <div style="padding-top:1rem">{{ $fees->links() }}</div>
    @endif
</div>

@endsection
