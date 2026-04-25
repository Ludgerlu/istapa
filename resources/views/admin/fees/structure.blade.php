@extends('layouts.app')

@section('title', 'Fee Structure')
@section('page-title', 'Fee Structure')

@section('topbar-actions')
    <a href="{{ route('fees.index') }}" class="btn">← Back</a>
@endsection

@section('content')

<form method="POST" action="{{ route('fees.update-structure') }}">
    @csrf @method('PUT')

    <div class="card">
        <div class="card-header">
            <span class="card-title">Academic year {{ config('school.academic_year', '2025/2026') }}</span>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Tuition (FCFA)</th>
                        <th>Dev levy (FCFA)</th>
                        <th>Exam fees (FCFA)</th>
                        <th>PTA (FCFA)</th>
                        <th>Total (FCFA)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($structures as $i => $struct)
                        <input type="hidden" name="structures[{{ $i }}][id]" value="{{ $struct->id }}">
                        <tr>
                            <td style="font-weight:500">{{ $struct->class_level }}</td>
                            <td>
                                <input type="number" name="structures[{{ $i }}][tuition]"
                                       value="{{ $struct->tuition }}" min="0"
                                       style="width:120px" onchange="recalcTotal({{ $i }})">
                            </td>
                            <td>
                                <input type="number" name="structures[{{ $i }}][dev_levy]"
                                       value="{{ $struct->dev_levy }}" min="0"
                                       style="width:120px" onchange="recalcTotal({{ $i }})">
                            </td>
                            <td>
                                <input type="number" name="structures[{{ $i }}][exam_fees]"
                                       value="{{ $struct->exam_fees }}" min="0"
                                       style="width:120px" onchange="recalcTotal({{ $i }})">
                            </td>
                            <td>
                                <input type="number" name="structures[{{ $i }}][pta]"
                                       value="{{ $struct->pta }}" min="0"
                                       style="width:100px" onchange="recalcTotal({{ $i }})">
                            </td>
                            <td>
                                <span id="total-{{ $i }}" style="font-weight:500">
                                    {{ number_format($struct->total) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Instalment deadlines --}}
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem">Payment instalments</div>
        <table style="max-width:500px">
            <thead>
                <tr><th>Instalment</th><th>Percentage</th><th>Deadline</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>1st instalment</td>
                    <td><span class="badge badge-blue">50%</span></td>
                    <td style="color:#888780">15 September 2025</td>
                </tr>
                <tr>
                    <td>2nd instalment</td>
                    <td><span class="badge badge-blue">30%</span></td>
                    <td style="color:#888780">15 January 2026</td>
                </tr>
                <tr>
                    <td>Balance</td>
                    <td><span class="badge badge-blue">20%</span></td>
                    <td style="color:#888780">30 March 2026</td>
                </tr>
            </tbody>
        </table>
    </div>
</form>

<script>
function recalcTotal(i) {
    const get = name => parseFloat(document.querySelector(`input[name="structures[${i}][${name}]"]`).value) || 0;
    const total = get('tuition') + get('dev_levy') + get('exam_fees') + get('pta');
    document.getElementById('total-' + i).textContent = total.toLocaleString();
}
</script>

@endsection
