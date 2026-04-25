@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')

@section('topbar-actions')
    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add user</a>
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

{{-- Filters --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">All users</span>
        <form method="GET" style="display:flex;gap:8px;align-items:center">
            <input name="search" placeholder="Search name / email…"
                   value="{{ request('search') }}" style="width:200px">
            <select name="role" onchange="this.form.submit()">
                <option value="">All roles</option>
                <option value="student"  {{ request('role') === 'student'  ? 'selected' : '' }}>Student</option>
                <option value="teacher"  {{ request('role') === 'teacher'  ? 'selected' : '' }}>Teacher</option>
                <option value="admin"    {{ request('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit" class="btn">Filter</button>
            @if(request()->hasAny(['role','search']))
                <a href="{{ route('users.index') }}" class="btn">Clear</a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
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
                        $avColors = ['student' => '#E6F1FB:#185FA5', 'teacher' => '#E1F5EE:#0F6E56', 'admin' => '#FAEEDA:#854F0B'];
                        [$avBg, $avFg] = explode(':', $avColors[$user->role] ?? '#F1EFE8:#5F5E5A');
                        $roleBadge = ['student' => 'badge-blue', 'teacher' => 'badge-green', 'admin' => 'badge-amber'];
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center">
                                <div class="avatar" style="background:{{ $avBg }};color:{{ $avFg }}">{{ $initials }}</div>
                                <a href="{{ route('users.show', $user) }}" style="color:inherit;text-decoration:none;font-weight:500">{{ $user->name }}</a>
                            </div>
                        </td>
                        <td><span class="badge {{ $roleBadge[$user->role] ?? 'badge-gray' }}">{{ $user->role }}</span></td>
                        <td style="color:#888780">{{ $user->email }}</td>
                        <td style="color:#888780">{{ $user->class ?? $user->subject ?? $user->title ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $user->status === 'active' ? 'badge-green' : 'badge-gray' }}">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm">Edit</a>
                                <form method="POST" action="{{ route('users.destroy', $user) }}"
                                      onsubmit="return confirm('Deactivate this user?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#888780;padding:2rem">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
        <div style="padding-top:1rem">{{ $users->links() }}</div>
    @endif
</div>

@endsection
