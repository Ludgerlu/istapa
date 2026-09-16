<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Program;
use App\Models\AcademicYear;
use App\Models\TeacherDetail;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\ClassEnrollment;
use App\Models\AttendanceSession;
use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    /**
     * Display a listing of classes.
     */
    public function index(Request $request)
    {
        $query = Classes::with(['program', 'academicYear', 'headTeacher.user']);

        $year_id = $request->input('academic_year_id');

        // dd(empty($request->input('academic_year_id')));
        if (empty($year_id)) {
            // Default to the current academic year 
            $currentAcademicYear = AcademicYear::where('is_current', true)->first();
            $year_id = $currentAcademicYear ? $currentAcademicYear->id : null;
            $query->where('academic_year_id', $currentAcademicYear->id);
            // dd($currentAcademicYear);

        }
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }
        
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('section', 'like', "%{$search}%");
        }

        $classes = $query->orderBy('name')->paginate(15);
        $programs = Program::all();
        $academicYears = AcademicYear::all();

        return view('admin.classes.index', compact('classes', 'programs', 'academicYears', 'year_id'));
    }

    /**
     * Show form to create a new class.
     */
    public function create()
    {
        $programs = Program::all();
        $academicYears = AcademicYear::all();
        $teachers = TeacherDetail::with('user')->get();
        return view('admin.classes.create', compact('programs', 'academicYears', 'teachers'));
    }

    /**
     * Store a newly created class.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'head_teacher_id' => 'nullable|exists:teacher_details,user_id',
        ]);

        Classes::create($validated);

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Classe créée avec succès.');
    }

    /**
     * Display the specified class with all related data.
     */
    public function show(Classes $class)
    {
        // Load basic relationships
        $class->load(['program', 'academicYear', 'headTeacher.user']);

        // Subjects
        $subjects = Subject::with('teacher.user')
            ->where('class_id', $class->id)
            ->get();

        // Exams (with exam subjects and subjects)
        $exams = Exam::with(['examSubjects.subject', 'examSubjects.marks'])
            ->where('class_id', $class->id)
            ->orderBy('start_date', 'desc')
            ->get();

        // Students (active enrollments)
        $students = ClassEnrollment::with('student.user')
            ->where('class_id', $class->id)
            ->where('status', 'active')
            ->get();
        

        // Attendance sessions (last 10)
        $attendanceSessions = AttendanceSession::with(['subject', 'takenBy'])
            ->where('class_id', $class->id)
            ->orderBy('session_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        // Get fees for this class
        $fees = Fee::where('class_id', $class->id)
                ->where('academic_year_id', $class->academic_year_id)
                ->get();
        $totalFeesAmount = $fees->sum('amount');

        // Get all payments for these fees
        $feeIds = $fees->pluck('id');
        $payments = FeePayment::whereIn('fee_id', $feeIds)
                            ->with(['student', 'fee', 'receivedBy'])
                            ->get();
        $paymentsByStudent = $payments->groupBy('student_id');

        // Build student data for the payment modal
        $studentsData = [];
        foreach ($students as $enrollment) {
            $studentId = $enrollment->student_id;
            $studentPayments = $paymentsByStudent->get($studentId, collect());
            $totalPaid = $studentPayments->sum('amount_paid');
            $balance = $totalFeesAmount - $totalPaid;
            $studentsData[] = [
                'id'          => $studentId,
                'name'        => $enrollment->student->user->full_name ?? '—',
                'matricule'   => $enrollment->student->matricule ?? '—',
                'total_fees'  => $totalFeesAmount,
                'total_paid'  => $totalPaid,
                'balance'     => $balance,
                'status'      => $balance <= 0 ? 'paid' : ($totalPaid > 0 ? 'partial' : 'unpaid'),
                'payments'    => $studentPayments->map(function ($p) {
                    return [
                        'id'          => $p->id,
                        'amount'      => $p->amount_paid,
                        'date'        => $p->paid_on ? $p->paid_on->format('d/m/Y') : '—',
                        'method'      => $p->payment_method,
                        'reference'   => $p->transaction_ref,
                        'category'    => $p->fee->category->name ?? '—',
                        'received_by' => $p->receivedBy->name ?? '—'
                    ];
                })->toArray()
            ];
        }

        $todaySessions = AttendanceSession::with(['subject', 'takenBy'])
            ->where('class_id', $class->id)
            ->whereDate('session_date', today())
            ->orderBy('session_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        return view('admin.classes.show', compact(
            'class', 'subjects', 'exams', 'students', 'attendanceSessions',
             'fees', 'studentsData', 'todaySessions'
        ));
    }

    public function attendances($class, Request $request)
    {
        $query = AttendanceSession::with(['class', 'subject', 'takenBy'])
                    ->where('class_id', $class);

     
        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('session_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('session_date', '<=', $request->date_to);
        }

        // Default order: most recent first
        $sessions = $query->orderBy('session_date', 'desc')
                        ->orderBy('start_time', 'desc')
                        ->paginate(20);

        // For filter dropdowns
        // $classes = Classes::orderBy('name')->get();
        $subjects = Subject::where('class_id', $class)->orderBy('name')->get(); // optional: you may want to restrict by class

        return view('admin.classes.attendances', compact('sessions', 'subjects', 'class'));
    }

    /**
     * Show form to edit a class.
     */
    public function edit(Classes $class)
    {
        $programs = Program::all();
        $academicYears = AcademicYear::all();
        $teachers = TeacherDetail::with('user')->get();
        return view('admin.classes.edit', compact('class', 'programs', 'academicYears', 'teachers'));
    }

    /**
     * Update the specified class.
     */
    public function update(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'head_teacher_id' => 'nullable|exists:teacher_details,user_id',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.show', $class)
                         ->with('success', 'Classe mise à jour.');
    }

    /**
     * Remove the specified class (with checks).
     */
    public function destroy(Classes $class)
    {
        // Check for related records
        if ($class->classEnrollments()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des élèves sont inscrits dans cette classe.');
        }
        if ($class->subjects()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des matières sont associées.');
        }
        if ($class->attendanceSessions()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des séances de présence existent.');
        }
        if ($class->exams()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des examens sont planifiés.');
        }
        if ($class->fees()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des frais sont associés.');
        }

        $class->delete();
        return redirect()->route('admin.classes.index')
                         ->with('success', 'Classe supprimée.');
    }

    public function attendanceSessions(Request $request, Classes $class)
    {
        $query = AttendanceSession::with(['subject', 'takenBy'])
            ->where('class_id', $class->id);

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('session_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('session_date', '<=', $request->date_to);
        }
        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $sessions = $query->orderBy('session_date', 'desc')
                        ->orderBy('start_time', 'desc')
                        ->paginate(15);

        // Build response data
        $data = [
            'sessions' => $sessions->map(function ($session) {
                return [
                    'id'          => $session->id,
                    'subject'     => $session->subject->name ?? '—',
                    'date'        => $session->session_date->format('d/m/Y'),
                    'start_time'  => $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '—',
                    'end_time'    => $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '—',
                    'taken_by'    => $session->takenBy->first_name ?? '' . ' ' . ($session->takenBy->last_name ?? ''),
                    'details_url' => route('admin.attendances.show', $session),
                ];
            }),
            'pagination' => [
                'current_page' => $sessions->currentPage(),
                'last_page'    => $sessions->lastPage(),
                'per_page'     => $sessions->perPage(),
                'total'        => $sessions->total(),
                'next_page_url' => $sessions->nextPageUrl(),
                'prev_page_url' => $sessions->previousPageUrl(),
            ]
        ];

        return response()->json($data);
    }
}