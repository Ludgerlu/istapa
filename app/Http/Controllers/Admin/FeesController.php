<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\User;
use Illuminate\Http\Request;

class FeesController extends Controller
{
    /**
     * Fees dashboard: overview stats + student list.
     */
    public function index(Request $request)
    {
        $query = Fee::with('student', 'student.schoolClass');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('class_id')) {
            $query->whereHas('student', fn($q) => $q->where('class_id', $request->class_id));
        }

        if ($request->filled('search')) {
            $query->whereHas('student', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $fees = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'expected'    => Fee::sum('total_amount'),
            'collected'   => FeePayment::sum('amount'),
            'outstanding' => Fee::sum('total_amount') - FeePayment::sum('amount'),
            'paid_full'   => Fee::where('status', 'paid')->count(),
        ];

        return view('fees.index', compact('fees', 'stats'));
    }

    /**
     * Show the payment recording form.
     */
    public function createPayment()
    {
        $students = User::where('role', 'student')
                        ->where('status', 'active')
                        ->with('schoolClass')
                        ->orderBy('name')
                        ->get();

        return view('fees.record-payment', compact('students'));
    }

    /**
     * Store a new payment and update the fee record status.
     */
    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'student_id'  => 'required|exists:users,id',
            'amount'      => 'required|numeric|min:1',
            'paid_at'     => 'required|date',
            'method'      => 'required|in:cash,mobile_money,bank_transfer,cheque',
            'reference'   => 'nullable|string|max:100',
            'notes'       => 'nullable|string|max:255',
        ]);

        $fee = Fee::firstOrCreate(
            ['student_id' => $validated['student_id'], 'academic_year' => config('school.academic_year')],
            ['total_amount' => FeeStructure::amountFor($validated['student_id']), 'status' => 'unpaid']
        );

        FeePayment::create([
            'fee_id'      => $fee->id,
            'student_id'  => $validated['student_id'],
            'amount'      => $validated['amount'],
            'paid_at'     => $validated['paid_at'],
            'method'      => $validated['method'],
            'reference'   => $validated['reference'],
            'notes'       => $validated['notes'],
            'recorded_by' => auth()->id(),
        ]);

        // Recalculate fee status after payment
        $totalPaid = FeePayment::where('fee_id', $fee->id)->sum('amount');

        $fee->update([
            'amount_paid' => $totalPaid,
            'status'      => match (true) {
                $totalPaid >= $fee->total_amount              => 'paid',
                $totalPaid > 0 && $totalPaid < $fee->total_amount => 'partial',
                default                                        => 'unpaid',
            },
        ]);

        return redirect()->route('fees.index')
            ->with('success', 'Payment of ' . number_format($validated['amount']) . ' FCFA recorded.');
    }

    /**
     * Show a student's full fee & payment history.
     */
    public function studentFees(User $student)
    {
        $fee      = Fee::where('student_id', $student->id)
                       ->where('academic_year', config('school.academic_year'))
                       ->with('payments')
                       ->first();

        $payments = $fee?->payments()->latest('paid_at')->get() ?? collect();

        return view('fees.student', compact('student', 'fee', 'payments'));
    }

    /**
     * Print/download receipt for a specific payment.
     */
    public function receipt(FeePayment $payment)
    {
        $payment->load('student', 'fee');
        return view('fees.receipt', compact('payment'));
    }

    /**
     * Fee structure management page.
     */
    public function structure()
    {
        $structures = FeeStructure::orderBy('class_level')->get();
        return view('fees.structure', compact('structures'));
    }

    /**
     * Update the fee structure.
     */
    public function updateStructure(Request $request)
    {
        $request->validate([
            'structures'              => 'required|array',
            'structures.*.id'         => 'required|exists:fee_structures,id',
            'structures.*.tuition'    => 'required|numeric|min:0',
            'structures.*.dev_levy'   => 'required|numeric|min:0',
            'structures.*.exam_fees'  => 'required|numeric|min:0',
            'structures.*.pta'        => 'required|numeric|min:0',
        ]);

        foreach ($request->structures as $data) {
            FeeStructure::where('id', $data['id'])->update([
                'tuition'   => $data['tuition'],
                'dev_levy'  => $data['dev_levy'],
                'exam_fees' => $data['exam_fees'],
                'pta'       => $data['pta'],
                'total'     => $data['tuition'] + $data['dev_levy'] + $data['exam_fees'] + $data['pta'],
            ]);
        }

        return redirect()->route('fees.structure')
            ->with('success', 'Fee structure updated.');
    }
}
