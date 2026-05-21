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

        return view('admin.classes.index', compact('classes', 'programs', 'academicYears'));
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

        return view('admin.classes.show', compact('class', 'subjects', 'exams', 'students', 'attendanceSessions'));
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
}