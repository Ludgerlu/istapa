<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\AttendanceSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    /**
     * Dashboard: today's summary + class selector.
     */
    public function index(Request $request)
    {
        $today = Carbon::today();

        $stats = [
            'present' => AttendanceSession::whereDate('session_date', $today)->with('details',function($query) {
                $query->where('status', 'present');
            })->count(),
            'absent'  => AttendanceSession::whereDate('session_date', $today)->with('details',function($query) {
                $query->where('status', 'absent');
            })->count(),
            'late'    => AttendanceSession::whereDate('session_date', $today)->with('details',function($query) {
                $query->where('status', 'late');
            })->count(),
            'rate'    => $this->monthlyRate(),
        ];

        $classes = Classes::orderBy('name')->get();
        return view('admin.attendance.index', compact('stats', 'classes'));
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
     * Save (upsert) attendance records for the whole class.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id'          => 'required|exists:classes,id',
            'date'              => 'required|date',
            'attendance'        => 'required|array',
            'attendance.*.status' => 'required|in:present,absent,late',
            'attendance.*.note' => 'nullable|string|max:255',
        ]);

        $date      = Carbon::parse($request->date);
        $recordedBy = auth()->id();

        foreach ($request->attendance as $studentId => $record) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id'   => $request->class_id,
                    'date'       => $date->toDateString(),
                ],
                [
                    'status'      => $record['status'],
                    'note'        => $record['note'] ?? null,
                    'recorded_by' => $recordedBy,
                ]
            );
        }

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance saved successfully.');
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
