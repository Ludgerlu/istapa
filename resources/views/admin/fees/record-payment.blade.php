@extends('layouts.app')

@section('title', 'Record Payment')
@section('page-title', 'Record Payment')

@section('topbar-actions')
    <a href="{{ route('fees.index') }}" class="btn">← Back</a>
@endsection

@section('content')
<div style="max-width:560px">
<form method="POST" action="{{ route('fees.store-payment') }}">
    @csrf

    <div class="card">
        <div class="card-title" style="margin-bottom:1rem">Payment details</div>

        <div class="form-group">
            <label>Student *</label>
            <select name="student_id" required>
                <option value="">— Select student —</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }} — {{ $student->schoolClass->name ?? '' }}
                    </option>
                @endforeach
            </select>
            @error('student_id') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Amount (FCFA) *</label>
                <input type="number" name="amount" value="{{ old('amount') }}"
                       placeholder="e.g. 50000" min="1" required>
                @error('amount') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Payment date *</label>
                <input type="date" name="paid_at" value="{{ old('paid_at', today()->format('Y-m-d')) }}" required>
                @error('paid_at') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Payment method *</label>
                <select name="method" required>
                    <option value="">— Select —</option>
                    <option value="cash"          {{ old('method') === 'cash'          ? 'selected' : '' }}>Cash</option>
                    <option value="mobile_money"  {{ old('method') === 'mobile_money'  ? 'selected' : '' }}>Mobile Money</option>
                    <option value="bank_transfer" {{ old('method') === 'bank_transfer' ? 'selected' : '' }}>Bank transfer</option>
                    <option value="cheque"        {{ old('method') === 'cheque'        ? 'selected' : '' }}>Cheque</option>
                </select>
                @error('method') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Receipt / reference no.</label>
                <input name="reference" value="{{ old('reference') }}" placeholder="e.g. REC-0042">
                @error('reference') <div class="error-msg">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Notes (optional)</label>
            <input name="notes" value="{{ old('notes') }}" placeholder="e.g. First instalment">
        </div>
    </div>

    <div style="display:flex;gap:8px;justify-content:flex-end">
        <a href="{{ route('fees.index') }}" class="btn">Cancel</a>
        <button type="submit" class="btn btn-primary">Record payment</button>
    </div>
</form>
</div>
@endsection
