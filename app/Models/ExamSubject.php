<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model
{
    protected $table = 'exam_subjects';
    public $timestamps = false;

    protected $fillable = ['exam_id', 'subject_id', 'exam_date', 'start_time', 'end_time', 'total_mark'];

    protected $casts = [
        'exam_date' => 'date',
        'total_mark' => 'float',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'exam_subject_id');
    }
}