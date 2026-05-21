<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\AcademicYear;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['class', 'academicYear', 'creator']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }
        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }

        $exams = $query->orderBy('start_date', 'desc')->paginate(15);
        $classes = Classes::all();
        $academicYears = AcademicYear::all();

        return view('admin.exams.index', compact('exams', 'classes', 'academicYears'));
    }

    public function create()
    {
        $classes = Classes::all();
        $academicYears = AcademicYear::all();
        return view('admin.exams.create', compact('classes', 'academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'term' => 'required|in:first,second,third,final',
            'exam_type' => 'required|in:midterm,final,quiz,assignment',
            'passing_mark' => 'nullable|numeric|min:0',
            'total_mark' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['created_by'] = Auth::id();
        Exam::create($validated);

        return redirect()->route('admin.exams.index')
                         ->with('success', 'Examen créé avec succès.');
    }

    public function show(Exam $exam)
    {
        $exam->load(['class', 'academicYear', 'creator', 'examSubjects.subject']);
        
        // For each exam subject, preload marks with student info
        foreach ($exam->examSubjects as $examSubject) {
            $examSubject->load(['marks.student.user', 'subject']);
        }
        
        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $classes = Classes::all();
        $academicYears = AcademicYear::all();
        return view('admin.exams.edit', compact('exam', 'classes', 'academicYears'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'term' => 'required|in:first,second,third,final',
            'exam_type' => 'required|in:midterm,final,quiz,assignment',
            'passing_mark' => 'nullable|numeric|min:0',
            'total_mark' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $exam->update($validated);
        return redirect()->route('admin.exams.show', $exam)
                         ->with('success', 'Examen mis à jour.');
    }

    public function destroy(Exam $exam)
    {
        // Delete related exam subjects and marks first
        foreach ($exam->examSubjects as $examSubject) {
            $examSubject->marks()->delete();
            $examSubject->delete();
        }
        $exam->delete();
        return redirect()->route('admin.exams.index')
                         ->with('success', 'Examen supprimé.');
    }
}