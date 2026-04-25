@extends('layouts.app')

@section('title', 'Edit — ' . $user->name)
@section('page-title', 'Edit User')

@section('topbar-actions')
    <a href="{{ route('users.index') }}" class="btn">← Back</a>
@endsection

@section('content')
<div style="max-width:640px">
<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf @method('PUT')

    <div class="card">
        <div class="card-title" style="margin-bottom:.5rem">{{ $user->name }}</div>
        <div style="margin-bottom:1rem">
            @php $roleBadge = ['student'=>'badge-blue','teacher'=>'badge-green','admin'=>'badge-amber']; @endphp
            <span class="badge {{ $roleBadge[$user->role] ?? 'badge-gray' }}">{{ $user->role }}</span>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>First name *</label>
                <input name="first_name" value="{{ old('first_name', $user->first_name) }}">
                @error('first_name') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Last name *</label>
                <input name="last_name" value="{{ old('last_name', $user->last_name) }}">
                @error('last_name') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}">
                @error('email') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input name="phone" value="{{ old('phone', $user->phone) }}">
            </div>
        </div>
        <div class="form-group" style="max-width:200px">
            <label>Status</label>
            <select name="status">
                <option value="active"   {{ old('status', $user->status) === 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>

    @if($user->role === 'student')
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem">Student details</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Class</label>
                <select name="class_id">
                    @foreach(\App\Models\SchoolClass::orderBy('name')->get() as $class)
                        <option value="{{ $class->id }}" {{ old('class_id', $user->class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Date of birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}">
            </div>
        </div>
    </div>
    @endif

    @if($user->role === 'teacher')
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem">Teacher details</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Subject</label>
                <input name="subject" value="{{ old('subject', $user->subject) }}">
            </div>
            <div class="form-group">
                <label>Department</label>
                <input name="department" value="{{ old('department', $user->department) }}">
            </div>
        </div>
    </div>
    @endif

    @if($user->role === 'admin')
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem">Admin details</div>
        <div class="form-group" style="max-width:300px">
            <label>Title</label>
            <input name="title" value="{{ old('title', $user->title) }}">
        </div>
    </div>
    @endif

    <div style="display:flex;gap:8px;justify-content:flex-end">
        <a href="{{ route('users.index') }}" class="btn">Cancel</a>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
</div>
@endsection
