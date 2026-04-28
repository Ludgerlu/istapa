<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\AttendanceSession;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassEnrollment;
use App\Models\AttendanceDetail;

class AttendanceController extends Controller
{
    /**
     * Dashboard: today's summary + class selector.
     */
    public function index(Request $request)
    {
        $query = AttendanceSession::with(['class', 'subject', 'takenBy']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('date_from')) {
            $query->where('session_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('session_date', '<=', $request->date_to);
        }

        $sessions = $query->orderBy('session_date', 'desc')
                          ->orderBy('start_time', 'desc')
                          ->paginate(20);

        $classes = Classes::all();
        $subjects = Subject::all();

        return view('admin.attendances.index', compact('sessions', 'classes', 'subjects'));
    }


    /**
     * Show form to create a new attendance session.
     */
    public function create()
    {
        $classes = Classes::all();
        return view('admin.attendances.create', compact('classes'));
    }

    /**
     * Get subjects for a given class via AJAX (depends on your relationships)
     */
    public function getSubjectsByClass($classId)
    {
        $subjects = Subject::where('class_id', $classId)->get();
        return response()->json($subjects);
    }

    /**
     * Get students for a given class via AJAX
     */
    public function getStudentsByClass($classId)
    {
        $students = ClassEnrollment::with('student.user')
            ->where('class_id', $classId)
            ->where('status', 'active')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'id' => $enrollment->student->user_id,
                    'name' => $enrollment->student->user->first_name . ' ' . $enrollment->student->user->last_name,
                    'matricule' => $enrollment->student->matricule,
                ];
            });
        return response()->json($students);
    }

    /**
     * Store a new attendance session with details.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'session_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string',
            'students' => 'required|array',
            'students.*.id' => 'required|exists:students,user_id',
            'students.*.status' => 'required|in:present,absent,late,excused',
            'students.*.comment' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create session
            $session = AttendanceSession::create([
                'class_id' => $validated['class_id'],
                'subject_id' => $validated['subject_id'],
                'session_date' => $validated['session_date'],
                'start_time' => $validated['start_time'] ?? null,
                'end_time' => $validated['end_time'] ?? null,
                'taken_by' => Auth::id(),
                'notes' => $validated['notes'],
            ]);

            // Create attendance details
            foreach ($validated['students'] as $studentData) {
                AttendanceDetail::create([
                    'attendance_session_id' => $session->id,
                    'student_id' => $studentData['id'],
                    'status' => $studentData['status'],
                    'comment' => $studentData['comment'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.attendances.show', $session)
                             ->with('success', 'Présence enregistrée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified attendance session with list of students & status.
     */
    public function show(AttendanceSession $attendance)
    {
        // Load relationships
        $attendance->load(['class', 'subject', 'takenBy']);
        
        // Get all active students in the class
        $students = ClassEnrollment::with('student.user')
            ->where('class_id', $attendance->class_id)
            ->where('status', 'active')
            ->get();

        // Get attendance details for this session
        $details = AttendanceDetail::where('attendance_session_id', $attendance->id)
            ->get()
            ->keyBy('student_id');

        // Build presence list
        $presenceList = [];
        foreach ($students as $enrollment) {
            $student = $enrollment->student;
            $detail = $details->get($student->user_id);
            $presenceList[] = (object)[
                'student' => $student,
                'status' => $detail ? $detail->status : 'not_taken',
                'comment' => $detail ? $detail->comment : null,
            ];
        }

        return view('admin.attendances.show', compact('attendance', 'presenceList'));
    }

    /**
     * Show form to edit an existing attendance session.
     */
    public function edit(AttendanceSession $attendance)
    {
        $attendance->load(['class', 'subject']);
        $classes = Classes::all();
        $subjects = Subject::where('class_id', $attendance->class_id)->get();

        // Get students with current status
        $students = ClassEnrollment::with('student.user')
            ->where('class_id', $attendance->class_id)
            ->where('status', 'active')
            ->get();

        $details = AttendanceDetail::where('attendance_session_id', $attendance->id)
            ->get()
            ->keyBy('student_id');

        $presenceList = [];
        foreach ($students as $enrollment) {
            $student = $enrollment->student;
            $detail = $details->get($student->user_id);
            $presenceList[] = (object)[
                'id' => $student->user_id,
                'name' => $student->user->first_name . ' ' . $student->user->last_name,
                'matricule' => $student->matricule,
                'status' => $detail ? $detail->status : 'absent',
                'comment' => $detail ? $detail->comment : '',
            ];
        }

        return view('admin.attendances.edit', compact('attendance', 'classes', 'subjects', 'presenceList'));
    }

    /**
     * Update the specified attendance session.
     */
    public function update(Request $request, AttendanceSession $attendance)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'session_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string',
            'students' => 'required|array',
            'students.*.id' => 'required|exists:students,user_id',
            'students.*.status' => 'required|in:present,absent,late,excused',
            'students.*.comment' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update session
            $attendance->update([
                'class_id' => $validated['class_id'],
                'subject_id' => $validated['subject_id'],
                'session_date' => $validated['session_date'],
                'start_time' => $validated['start_time'] ?? null,
                'end_time' => $validated['end_time'] ?? null,
                'notes' => $validated['notes'],
            ]);

            // Delete old details and recreate
            AttendanceDetail::where('attendance_session_id', $attendance->id)->delete();
            foreach ($validated['students'] as $studentData) {
                AttendanceDetail::create([
                    'attendance_session_id' => $attendance->id,
                    'student_id' => $studentData['id'],
                    'status' => $studentData['status'],
                    'comment' => $studentData['comment'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.attendances.show', $attendance)
                             ->with('success', 'Présence mise à jour.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified attendance session.
     */
    public function destroy(AttendanceSession $attendance)
    {
        AttendanceDetail::where('attendance_session_id', $attendance->id)->delete();
        $attendance->delete();
        return redirect()->route('admin.attendances.index')
                         ->with('success', 'Session de présence supprimée.');
    }

    // AJAX endpoints for dynamic forms
    public function getSubjectsByClassJson($classId)
    {
        $subjects = Subject::where('class_id', $classId)->get(['id', 'name']);
        return response()->json($subjects);
    }

    public function getStudentsByClassJson($classId)
    {
        $students = ClassEnrollment::with('student.user')
            ->where('class_id', $classId)
            ->where('status', 'active')
            ->get()
            ->map(function ($enrollment) {
                $student = $enrollment->student;
                return [
                    'id' => $student->user_id,
                    'name' => $student->user->first_name . ' ' . $student->user->last_name,
                    'matricule' => $student->matricule,
                ];
            });
        return response()->json($students);
    }

    /**
     * Show the mark-attendance form for a class on a given date.
     */
    public function mark(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date'     => 'required|date',
        ]);

        $class    = Classes::findOrFail($request->class_id);
        $date     = Carbon::parse($request->date);
        $students = User::where('role', 'student')
                        ->where('class_id', $class->id)
                        ->where('status', 'active')
                        ->orderBy('name')
                        ->get();

        // Pre-load any existing attendance for this date
        $existing = Attendance::whereDate('date', $date)
                               ->where('class_id', $class->id)
                               ->pluck('status', 'student_id');

        return view('admin.attendance.mark', compact('class', 'date', 'students', 'existing'));
    }

    /**
     * Individual student report (calendar view).
     */
    public function studentReport(Request $request, User $student)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $records = Attendance::where('student_id', $student->id)
                              ->whereBetween('date', [$start, $end])
                              ->get()
                              ->keyBy(fn($r) => Carbon::parse($r->date)->format('Y-m-d'));

        $totalDays    = $start->diffInWeekdays($end) + 1;
        $presentCount = $records->where('status', 'present')->count();
        $rate         = $totalDays > 0 ? round(($presentCount / $totalDays) * 100) : 0;

        return view('admin.attendance.student-report', compact('student', 'records', 'start', 'end', 'rate', 'month'));
    }

    /**
     * Class summary: all classes for a given month.
     */
    public function classSummary(Request $request)
    {
        $month   = $request->get('month', Carbon::now()->format('Y-m'));
        $start   = Carbon::parse($month . '-01')->startOfMonth();
        $end     = $start->copy()->endOfMonth();
        $classes = SchoolClass::withCount('students')->get();

        $summary = $classes->map(function ($class) use ($start, $end) {
            $total   = Attendance::where('class_id', $class->id)
                                  ->whereBetween('date', [$start, $end])
                                  ->count();
            $present = Attendance::where('class_id', $class->id)
                                  ->whereBetween('date', [$start, $end])
                                  ->where('status', 'present')
                                  ->count();
            $absent  = Attendance::where('class_id', $class->id)
                                  ->whereBetween('date', [$start, $end])
                                  ->where('status', 'absent')
                                  ->count();

            return [
                'class'   => $class,
                'total'   => $total,
                'present' => $present,
                'absent'  => $absent,
                'rate'    => $total > 0 ? round(($present / $total) * 100) : 0,
            ];
        });

        return view('admin.attendance.class-summary', compact('summary', 'month'));
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function monthlyRate(): float
    {
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now();

        $total   = AttendanceSession::whereBetween('session_date', [$start, $end])->count();
        $present = AttendanceSession::whereBetween('session_date', [$start, $end])
                                    ->whereHas('details', function($query) {
                                        $query->where('status', 'present');
                                    })
                                     ->count();

        return $total > 0 ? round(($present / $total) * 100, 1) : 0;
    }
}
