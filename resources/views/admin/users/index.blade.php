@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'Users')

@section('topbar-actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Add user</a>
@endsection

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Students</div>
        <div class="stat-value blue">{{ $stats['students'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Teachers</div>
        <div class="stat-value green">{{ $stats['teachers'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Admins</div>
        <div class="stat-value amber">{{ $stats['admins'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Active users</div>
        <div class="stat-value">{{ $stats['active'] }}</div>
    </div>
</div>

{{-- Filters + Table Card --}}
<div class="card">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <span class="card-title">All users</span>
        <div class="d-flex gap-2">
            {{-- Role filter (refresh page) – light and simple --}}
            <form method="GET" id="role-form" class="d-flex gap-2">
                <select name="role" class="form-select form-select-sm" style="width:130px" onchange="this.form.submit()">
                    <option value="">All roles</option>
                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if(request()->has('role') && request('role') !== '')
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">Clear</a>
                @endif
            </form>
            {{-- Real‑time search (JS) – only filters visible rows on current page --}}
            <div class="input-group input-group-sm" style="width:250px">
                <input type="text" id="liveSearch" class="form-control" placeholder="Search name / email...">
                <span class="input-group-text"><i class="ph ph-magnifying-glass"></i></span>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle" id="usersTable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Class / Dept</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    @php
                        $initials = strtoupper(substr($user->first_name ?? $user->name, 0, 1) . substr($user->last_name ?? '', 0, 1));
                        $bgColor = match($user->role) { 'student' => '#E6F1FB', 'teacher' => '#E1F5EE', default => '#FAEEDA' };
                        $textColor = match($user->role) { 'student' => '#185FA5', 'teacher' => '#0F6E56', default => '#854F0B' };
                        $roleBadge = match($user->role) { 'student' => 'bg-info bg-opacity-10 text-info', 'teacher' => 'bg-success bg-opacity-10 text-success', default => 'bg-warning bg-opacity-10 text-warning' };
                    @endphp
                    <tr data-name="{{ strtolower($user->full_name) }}" data-email="{{ strtolower($user->email) }}">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar" style="background:{{ $bgColor }};color:{{ $textColor }};width:30px;height:30px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-right:8px">{{ $initials }}</div>
                                <a href="{{ route('admin.users.show', $user) }}" style="color:inherit;text-decoration:none;font-weight:500">{{ $user->full_name }}</a>
                            </div>
                        </td>
                        <td><span class="badge {{ $roleBadge }} px-3 py-2">{{ ucfirst($user->role) }}</span></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->class_dept ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Deactivate this user?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Laravel pagination links (styled with Bootstrap) --}}
    @if($users->hasPages())
        <div class="mt-3 d-flex justify-content-end">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // Live client-side search (filters rows on current page)
    document.getElementById('liveSearch').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('#usersTable tbody tr');
        rows.forEach(row => {
            let name = row.getAttribute('data-name') || row.cells[0]?.innerText.toLowerCase() || '';
            let email = row.getAttribute('data-email') || row.cells[2]?.innerText.toLowerCase() || '';
            if (name.includes(searchValue) || email.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush