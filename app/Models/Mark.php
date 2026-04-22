<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $table = 'marks';
    public $timestamps = true;

    protected $fillable = ['exam_subject_id', 'student_id', 'mark', 'grade_id', 'comment', 'entered_by'];

    protected $casts = [
        'mark' => 'float',
    ];

    public function examSubject()
    {
        return $this->belongsTo(ExamSubject::class);
    }

    public function student()
    {
        return $this->belongsTo(StudentDetail::class, 'student_id', 'user_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }
}