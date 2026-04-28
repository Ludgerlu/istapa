@extends('layouts.app')

@section('title', 'Mark Attendance — ' . $class->name)
@section('page-title', 'Mark Attendance')

@section('topbar-actions')
    <a href="{{ route('attendance.index') }}" class="btn">← Back</a>
@endsection

@section('content')

<div class="card" style="margin-bottom:.75rem">
    <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap">
        <div>
            <div style="font-size:11px;color:#888780">Class</div>
            <div style="font-weight:500">{{ $class->name }}</div>
        </div>
        <div style="width:1px;height:32px;background:#E0DFD8"></div>
        <div>
            <div style="font-size:11px;color:#888780">Date</div>
            <div style="font-weight:500">{{ $date->format('d F Y') }}</div>
        </div>
        <div style="width:1px;height:32px;background:#E0DFD8"></div>
        <div>
            <div style="font-size:11px;color:#888780">Students</div>
            <div style="font-weight:500">{{ $students->count() }}</div>
        </div>
        <div style="margin-left:auto;display:flex;gap:8px">
            <button type="button" class="btn btn-sm" onclick="markAll('present')">All present</button>
            <button type="button" class="btn btn-sm" onclick="markAll('absent')">All absent</button>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('attendance.store') }}">
    @csrf
    <input type="hidden" name="class_id" value="{{ $class->id }}">
    <input type="hidden" name="date" value="{{ $date->toDateString() }}">

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40%">Student</th>
                        <th style="width:15%;text-align:center">
                            <span style="color:#3B6D11">✓ Present</span>
                        </th>
                        <th style="width:15%;text-align:center">
                            <span style="color:#A32D2D">✕ Absent</span>
                        </th>
                        <th style="width:15%;text-align:center">
                            <span style="color:#854F0B">⏱ Late</span>
                        </th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        @php $current = $existing[$student->id] ?? 'present'; @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center">
                                    <div class="avatar" style="background:#E6F1FB;color:#185FA5">
                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                    </div>
                                    {{ $student->name }}
                                </div>
                            </td>
                            <td style="text-align:center">
                                <input type="radio"
                                       name="attendance[{{ $student->id }}][status]"
                                       value="present"
                                       {{ $current === 'present' ? 'checked' : '' }}>
                            </td>
                            <td style="text-align:center">
                                <input type="radio"
                                       name="attendance[{{ $student->id }}][status]"
                                       value="absent"
                                       {{ $current === 'absent' ? 'checked' : '' }}>
                            </td>
                            <td style="text-align:center">
                                <input type="radio"
                                       name="attendance[{{ $student->id }}][status]"
                                       value="late"
                                       {{ $current === 'late' ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input type="text"
                                       name="attendance[{{ $student->id }}][note]"
                                       placeholder="optional note…"
                                       style="padding:4px 8px;font-size:12px">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:8px">
        <a href="{{ route('attendance.index') }}" class="btn">Cancel</a>
        <button type="submit" class="btn btn-primary">Save attendance</button>
    </div>
</form>

<script>
function markAll(status) {
    document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(r => r.checked = true);
}
</script>
@endsection
