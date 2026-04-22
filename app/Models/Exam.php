<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';
    public $timestamps = false;

    protected $fillable = [
        'class_id', 'academic_year_id', 'name', 'term', 'exam_type',
        'passing_mark', 'total_mark', 'start_date', 'end_date', 'created_by'
    ];

    protected $casts = [
        'passing_mark' => 'float',
        'total_mark' => 'float',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class, 'exam_id');
    }
}