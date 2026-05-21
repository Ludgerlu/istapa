<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\TeacherDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects.
     */
    public function index(Request $request)
    {
        $query = Subject::with(['class', 'teacher.user']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $subjects = $query->orderBy('name')->paginate(20);
        $classes = Classes::all();
        $teachers = TeacherDetail::with('user')->get();

        return view('admin.subjects.index', compact('subjects', 'classes', 'teachers'));
    }

    /**
     * Show form to create a new subject.
     */
    public function create(Request $request)
    {
        
        $classes = Classes::all();
        $classId = $request->query('class_id') ?? null;
        $teachers = TeacherDetail::with('user')->get();
        return view('admin.subjects.create', compact('classes', 'teachers', 'classId'));
    }

    /**
     * Store a newly created subject.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'nullable|exists:teacher_details,user_id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:subjects,code',
            'coefficient' => 'nullable|numeric|min:0|max:20',
            'hours_per_week' => 'nullable|numeric|min:0|max:40',
            'description' => 'nullable|string',
        ]);

        Subject::create($validated);

        return redirect()->route('admin.subjects.index')
                         ->with('success', 'Matière créée avec succès.');
    }

    /**
     * Display the specified subject with exams and attendance.
     */
    public function show(Subject $subject)
    {
        $subject->load(['class', 'teacher.user']);

        // Exams that include this subject (via exam_subjects)
        $exams = $subject->examSubjects()->with('exam')->get()->map(function($examSubject) {
            return $examSubject->exam;
        })->unique('id');

        // Attendance sessions for this subject
        $attendanceSessions = $subject->attendanceSessions()
            ->with(['class', 'takenBy'])
            ->orderBy('session_date', 'desc')
            ->paginate(10);

        return view('admin.subjects.show', compact('subject', 'exams', 'attendanceSessions'));
    }

    /**
     * Show form to edit a subject.
     */
    public function edit(Subject $subject)
    {
        $classes = Classes::all();
        $teachers = TeacherDetail::with('user')->get();
        return view('admin.subjects.edit', compact('subject', 'classes', 'teachers'));
    }

    /**
     * Update the specified subject.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'nullable|exists:teacher_details,user_id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:subjects,code,' . $subject->id,
            'coefficient' => 'nullable|numeric|min:0|max:20',
            'hours_per_week' => 'nullable|numeric|min:0|max:40',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);

        return redirect()->route('admin.subjects.show', $subject)
                         ->with('success', 'Matière mise à jour.');
    }

    /**
     * Remove the specified subject (with checks).
     */
    public function destroy(Subject $subject)
    {
        // Check for related records
        if ($subject->examSubjects()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : cette matière est utilisée dans des examens.');
        }
        if ($subject->attendanceSessions()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des séances de présence existent pour cette matière.');
        }

        $subject->delete();
        return redirect()->route('admin.subjects.index')
                         ->with('success', 'Matière supprimée.');
    }
}