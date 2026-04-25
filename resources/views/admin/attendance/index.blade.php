@extends('layouts.admin')

@section('title', 'Attendance')
@section('page-title', 'Attendance')

@section('topbar-actions')
    <a href="{{ route('admin.attendance.class-summary') }}" class="btn">Class summary</a>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Present today</div>
        <div class="stat-value green">{{ $stats['present'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Absent today</div>
        <div class="stat-value red">{{ $stats['absent'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Late today</div>
        <div class="stat-value amber">{{ $stats['late'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Monthly avg rate</div>
        <div class="stat-value">{{ $stats['rate'] }}%</div>
    </div>
</div>

{{-- Mark attendance form --}}
<div class="card">
    <div class="card-title" style="margin-bottom:1rem">Mark attendance</div>
    <form method="GET" action="{{ route('admin.attendance.mark') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end">
        <div class="form-group" style="margin:0;min-width:180px">
            <label>Class</label>
            <select name="class_id" required>
                <option value="">— Select class —</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin:0">
            <label>Date</label>
            <input type="date" name="date" value="{{ today()->format('Y-m-d') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Open register</button>
    </form>
</div>

{{-- Quick links --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
    <div class="card" style="cursor:pointer" onclick="window.location='{{ route('admin.attendance.class-summary') }}'">
        <div style="font-size:22px;margin-bottom:.5rem">📊</div>
        <div class="card-title">Class summary</div>
        <div style="font-size:12px;color:#888780;margin-top:4px">Monthly rates per class</div>
    </div>
    <div class="card">
        <div style="font-size:22px;margin-bottom:.5rem">🔍</div>
        <div class="card-title">Student report</div>
        <div style="font-size:12px;color:#888780;margin-top:4px;margin-bottom:.75rem">Individual attendance calendar</div>
        <form method="GET" action="#" style="display:flex;gap:8px">
            <select name="student_id" style="flex:1">
                @foreach(\App\Models\User::where('role','student')->where('is_active',1)->orderBy('first_name')->get() as $student)
                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm">View</button>
        </form>
    </div>
</div>

@endsection
