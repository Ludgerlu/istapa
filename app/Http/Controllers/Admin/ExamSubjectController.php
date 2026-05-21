<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamSubjectController extends Controller
{
    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'total_mark' => 'nullable|numeric|min:0',
        ]);

        // Check if subject already added
        $exists = $exam->examSubjects()->where('subject_id', $request->subject_id)->exists();
        if ($exists) {
            return back()->with('error', 'Cette matière est déjà ajoutée à l\'examen.');
        }

        $exam->examSubjects()->create($request->only(['subject_id', 'exam_date', 'start_time', 'end_time', 'total_mark']));
        return back()->with('success', 'Matière ajoutée à l\'examen.');
    }

    public function destroy(ExamSubject $examSubject)
    {
        $examSubject->marks()->delete();
        $examSubject->delete();
        return back()->with('success', 'Matière retirée de l\'examen.');
    }
}