@extends('layouts.app')

@section('title', 'Class Summary')
@section('page-title', 'Class Summary')

@section('topbar-actions')
    <a href="{{ route('attendance.index') }}" class="btn">← Back</a>
@endsection

@section('content')

<form method="GET" style="display:flex;gap:8px;align-items:center;margin-bottom:1.25rem">
    <label style="font-size:13px;color:#888780">Month:</label>
    <input type="month" name="month" value="{{ $month }}" onchange="this.form.submit()" style="width:180px">
</form>

<div class="card">
    <div class="card-title" style="margin-bottom:1rem">
        Attendance by class — {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Students</th>
                    <th>Avg rate</th>
                    <th style="min-width:160px">Progress</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Trend</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summary as $row)
                    @php
                        $rate   = $row['rate'];
                        $color  = $rate >= 85 ? 'green' : ($rate >= 70 ? 'amber' : 'red');
                        $barCls = 'bg-' . $color;
                        $badgeCls = 'badge-' . $color;
                    @endphp
                    <tr>
                        <td style="font-weight:500">{{ $row['class']->name }}</td>
                        <td>{{ $row['class']->students_count }}</td>
                        <td><span class="badge {{ $badgeCls }}">{{ $rate }}%</span></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar {{ $barCls }}" style="width:{{ $rate }}%"></div>
                            </div>
                        </td>
                        <td style="color:#3B6D11">{{ $row['present'] }}</td>
                        <td style="color:#A32D2D">{{ $row['absent'] }}</td>
                        <td>
                            @if($rate >= 85)
                                <span style="color:#3B6D11">↑ Good</span>
                            @elseif($rate >= 70)
                                <span style="color:#854F0B">→ Watch</span>
                            @else
                                <span style="color:#A32D2D">↓ Alert</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
