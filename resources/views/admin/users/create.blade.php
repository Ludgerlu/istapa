@extends('layouts.app')

@section('title', 'Add User')
@section('page-title', 'Add User')

@section('topbar-actions')
    <a href="{{ route('users.index') }}" class="btn">← Back</a>
@endsection

@section('content')
<div style="max-width:640px">
<form method="POST" action="{{ route('users.store') }}">
    @csrf

    {{-- Role selector --}}
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem">User role</div>
        <div style="display:flex;gap:8px">
            @foreach(['student' => '🎓 Student', 'teacher' => '📚 Teacher', 'admin' => '⚙️ Admin'] as $value => $label)
                <label style="flex:1;padding:10px;border:1px solid {{ old('role', 'student') === $value ? '#185FA5' : '#E0DFD8' }};
                              border-radius:8px;cursor:pointer;text-align:center;font-size:13px;
                              background:{{ old('role', 'student') === $value ? '#E6F1FB' : '#fff' }};
                              color:{{ old('role', 'student') === $value ? '#185FA5' : '#888780' }}">
                    <input type="radio" name="role" value="{{ $value }}"
                           {{ old('role', 'student') === $value ? 'checked' : '' }}
                           style="display:none" onchange="toggleRoleFields(this.value)">
                    {{ $label }}
                </label>
            @endforeach
        </div>
        @error('role') <div class="error-msg">{{ $message }}</div> @enderror
    </div>

    {{-- Base info --}}
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem">Personal information</div>
        <div class="form-grid">
            <div class="form-group">
                <label>First name *</label>
                <input name="first_name" value="{{ old('first_name') }}" placeholder="e.g. Jean">
                @error('first_name') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Last name *</label>
                <input name="last_name" value="{{ old('last_name') }}" placeholder="e.g. Dupont">
                @error('last_name') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="jean@school.cm">
                @error('email') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input name="phone" value="{{ old('phone') }}" placeholder="+237 6XX XXX XXX">
                @error('phone') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group" style="max-width:200px">
            <label>Status</label>
            <select name="status">
                <option value="active"   {{ old('status', 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>

    {{-- Student fields --}}
    <div class="card" id="fields-student">
        <div class="card-title" style="margin-bottom:1rem">Student details</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Class *</label>
                <select name="class_id">
                    <option value="">— Select class —</option>
                    @foreach(\App\Models\SchoolClass::orderBy('name')->get() as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Date of birth *</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                @error('date_of_birth') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- Teacher fields --}}
    <div class="card" id="fields-teacher" style="display:none">
        <div class="card-title" style="margin-bottom:1rem">Teacher details</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Subject *</label>
                <input name="subject" value="{{ old('subject') }}" placeholder="e.g. Mathematics">
                @error('subject') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Department *</label>
                <input name="department" value="{{ old('department') }}" placeholder="e.g. Sciences">
                @error('department') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    {{-- Admin fields --}}
    <div class="card" id="fields-admin" style="display:none">
        <div class="card-title" style="margin-bottom:1rem">Admin details</div>
        <div class="form-group" style="max-width:300px">
            <label>Title / role *</label>
            <input name="title" value="{{ old('title') }}" placeholder="e.g. Principal">
            @error('title') <div class="error-msg">{{ $message }}</div> @enderror
        </div>
    </div>

    <div style="display:flex;gap:8px;justify-content:flex-end">
        <a href="{{ route('users.index') }}" class="btn">Cancel</a>
        <button type="submit" class="btn btn-primary">Create user</button>
    </div>
</form>
</div>

<script>
function toggleRoleFields(role) {
    ['student','teacher','admin'].forEach(r => {
        document.getElementById('fields-' + r).style.display = r === role ? 'block' : 'none';
    });
    document.querySelectorAll('input[name="role"]').forEach(input => {
        const lbl = input.closest('label');
        const selected = input.value === role;
        lbl.style.borderColor = selected ? '#185FA5' : '#E0DFD8';
        lbl.style.background  = selected ? '#E6F1FB' : '#fff';
        lbl.style.color       = selected ? '#185FA5' : '#888780';
    });
}
// Init on page load
document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="role"]:checked');
    if (checked) toggleRoleFields(checked.value);
});
</script>
@endsection
