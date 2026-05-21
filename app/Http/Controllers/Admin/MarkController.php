<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSubject;
use App\Models\ClassEnrollment;
use App\Models\Grade;
use App\Models\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    public function edit(ExamSubject $examSubject)
    {
        $examSubject->load(['exam.class', 'subject']);
        $classId = $examSubject->exam->class_id;
        
        // Get all active students in the class
        $students = ClassEnrollment::with('student.user')
            ->where('class_id', $classId)
            ->where('status', 'active')
            ->get();
        
        // Get existing marks for this exam subject
        $marks = Mark::where('exam_subject_id', $examSubject->id)
            ->get()
            ->keyBy('student_id');
        
        $grades = Grade::orderBy('mark_to')->get();
        
        return view('admin.exams.marks', compact('examSubject', 'students', 'marks', 'grades'));
    }
    
    public function update(Request $request, ExamSubject $examSubject)
    {
        $request->validate([
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0|max:' . ($examSubject->total_mark ?? 100),
            'comments' => 'nullable|array',
        ]);
        
        $totalMark = $examSubject->total_mark ?? 100;
        
        foreach ($request->marks as $studentId => $markValue) {
            if ($markValue === null || $markValue === '') continue;
            
            // Determine grade based on mark
            $gradeId = null;
            if ($examSubject->exam->passing_mark && $markValue < $examSubject->exam->passing_mark) {
                // You can implement grade calculation based on your Grade model
                // $gradeId = Grade::where('min_mark', '<=', $markValue)->orderBy('min_mark', 'desc')->first()?->id;
            }
            
            Mark::updateOrCreate(
                [
                    'exam_subject_id' => $examSubject->id,
                    'student_id' => $studentId,
                ],
                [
                    'mark' => $markValue,
                    'grade_id' => $gradeId,
                    'comment' => $request->comments[$studentId] ?? null,
                    'entered_by' => Auth::id(),
                ]
            );
        }
        
        return redirect()->route('admin.exams.show', $examSubject->exam_id)
                         ->with('success', 'Notes enregistrées.');
    }
}