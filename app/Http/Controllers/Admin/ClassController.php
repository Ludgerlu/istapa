<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Program;
use App\Models\AcademicYear;
use App\Models\TeacherDetail;
use App\Models\ClassEnrollment; // assume this model exists
use App\Models\Subject;
use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = Classes::with(['program', 'academicYear', 'headTeacher']);

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $classes = $query->paginate(15);
        $programs = Program::all();
        $academicYears = AcademicYear::all();

        return view('admin.classes.index', compact('classes', 'programs', 'academicYears'));
    }

    public function create()
    {
        $programs = Program::all();
        $academicYears = AcademicYear::all();
        $teachers = TeacherDetail::with('user')->get();
        return view('admin.classes.create', compact('programs', 'academicYears', 'teachers'));
    }

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

    public function show(Classes $class)
    {
        // Load relationships
        $class->load(['program', 'academicYear', 'headTeacher.user']);

        // Students enrolled in this class (via ClassEnrollment)
        $students = ClassEnrollment::with('student.user')
            ->where('class_id', $class->id)
            ->where('status', 'active')
            ->get();

        // Subjects taught in this class
        $subjects = Subject::with('teacher.user')
            ->where('class_id', $class->id)
            ->get();

        // Attendance sessions for this class (with subject and takenBy)
        $attendanceSessions = AttendanceSession::with(['subject', 'takenBy'])
            ->where('class_id', $class->id)
            ->orderBy('session_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('admin.classes.show', compact('class', 'students', 'subjects', 'attendanceSessions'));
    }


    public function showPresence(AttendanceSession $session)
    {
        // Load session with relationships
        $session->load(['class', 'subject', 'takenBy']);

        // Get all active students in the class
        $students = ClassEnrollment::with('student.user')
            ->where('class_id', $session->class_id)
            ->where('status', 'active')
            ->get();

        // Get attendance details for this session
        $attendanceDetails = AttendanceDetail::where('attendance_session_id', $session->id)
            ->get()
            ->keyBy('student_id');

        // Prepare presence list with status for each student
        $presenceList = [];
        foreach ($students as $enrollment) {
            $student = $enrollment->student;
            $detail = $attendanceDetails->get($student->user_id);
            $presenceList[] = [
                'student' => $student,
                'status' => $detail ? $detail->status : 'not_taken',
                'comment' => $detail ? $detail->comment : null,
            ];
        }

        return view('admin.classes.presence', compact('session', 'presenceList'));
    }

    public function edit(Classes $class)
    {
        $programs = Program::all();
        $academicYears = AcademicYear::all();
        $teachers = TeacherDetail::with('user')->get();
        return view('admin.classes.edit', compact('class', 'programs', 'academicYears', 'teachers'));
    }

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

    public function destroy(Classes $class)
    {
        // Check if any enrollments, subjects, attendance sessions exist
        if ($class->classEnrollments()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des élèves sont inscrits.');
        }
        if ($class->subjects()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des matières sont liées.');
        }
        if ($class->attendanceSessions()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des sessions de présence existent.');
        }
        $class->delete();
        return redirect()->route('admin.classes.index')
                         ->with('success', 'Classe supprimée.');
    }
}