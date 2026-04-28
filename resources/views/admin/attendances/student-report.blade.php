@extends('layouts.app')

@section('title', 'Attendance — ' . $student->name)
@section('page-title', $student->name . ' — Attendance report')

@section('topbar-actions')
    <a href="{{ route('attendance.index') }}" class="btn">← Back</a>
@endsection

@section('content')

{{-- Month picker --}}
<form method="GET" style="display:flex;gap:8px;align-items:center;margin-bottom:1.25rem">
    <label style="font-size:13px;color:#888780">Month:</label>
    <input type="month" name="month" value="{{ $month }}" onchange="this.form.submit()" style="width:180px">
</form>

{{-- Summary cards --}}
@php
    $present = $records->where('status','present')->count();
    $absent  = $records->where('status','absent')->count();
    $late    = $records->where('status','late')->count();
@endphp
<div class="stats-grid" style="max-width:600px">
    <div class="stat-card">
        <div class="stat-label">Rate</div>
        <div class="stat-value {{ $rate >= 80 ? 'green' : ($rate >= 60 ? 'amber' : 'red') }}">{{ $rate }}%</div>
        <div class="progress" style="margin-top:8px">
            <div class="progress-bar {{ $rate >= 80 ? 'bg-green' : ($rate >= 60 ? 'bg-amber' : 'bg-red') }}"
                 style="width:{{ $rate }}%"></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Present days</div>
        <div class="stat-value green">{{ $present }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Absent days</div>
        <div class="stat-value red">{{ $absent }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Late arrivals</div>
        <div class="stat-value amber">{{ $late }}</div>
    </div>
</div>

{{-- Calendar --}}
<div class="card">
    <div class="card-title" style="margin-bottom:1rem">{{ $start->format('F Y') }} calendar</div>

    <div class="att-calendar">
        {{-- Day headers --}}
        @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $d)
            <div style="text-align:center;font-size:10px;color:#888780;padding:4px 0">{{ $d }}</div>
        @endforeach

        {{-- Empty cells before month start --}}
        @php $startDow = $start->dayOfWeekIso - 1; @endphp
        @for($i = 0; $i < $startDow; $i++)
            <div></div>
        @endfor

        {{-- Day cells --}}
        @for($day = 1; $day <= $end->day; $day++)
            @php
                $date   = $start->copy()->setDay($day);
                $key    = $date->format('Y-m-d');
                $isWknd = $date->isWeekend();
                $rec    = $records[$key] ?? null;
                $status = $isWknd ? 'H' : ($rec ? strtoupper(substr($rec->status, 0, 1)) : '—');
                $css    = match($status) {
                    'P' => 'att-P', 'A' => 'att-A',
                    'L' => 'att-L', 'H' => 'att-H',
                    default => ''
                };
            @endphp
            <div class="att-day {{ $css }}" title="{{ $date->format('d M') }}">
                <div style="font-size:9px;margin-bottom:2px;opacity:.7">{{ $day }}</div>
                {{ $status }}
            </div>
        @endfor
    </div>

    {{-- Legend --}}
    <div style="display:flex;gap:12px;margin-top:.75rem;flex-wrap:wrap">
        <span style="font-size:12px;display:flex;align-items:center;gap:5px">
            <span class="badge badge-green">P</span> Present
        </span>
        <span style="font-size:12px;display:flex;align-items:center;gap:5px">
            <span class="badge badge-red">A</span> Absent
        </span>
        <span style="font-size:12px;display:flex;align-items:center;gap:5px">
            <span class="badge badge-amber">L</span> Late
        </span>
        <span style="font-size:12px;display:flex;align-items:center;gap:5px">
            <span class="badge badge-gray">H</span> Holiday / Weekend
        </span>
    </div>
</div>

{{-- Absent / late detail --}}
@if($records->whereIn('status', ['absent','late'])->count())
<div class="card">
    <div class="card-title" style="margin-bottom:1rem">Absences & late arrivals</div>
    <table>
        <thead>
            <tr><th>Date</th><th>Status</th><th>Note</th></tr>
        </thead>
        <tbody>
            @foreach($records->whereIn('status', ['absent','late'])->sortBy('date') as $rec)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($rec->date)->format('d M Y') }}</td>
                    <td>
                        <span class="badge {{ $rec->status === 'absent' ? 'badge-red' : 'badge-amber' }}">
                            {{ ucfirst($rec->status) }}
                        </span>
                    </td>
                    <td style="color:#888780">{{ $rec->note ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
