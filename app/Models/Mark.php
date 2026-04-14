<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $table = 'marks';
    protected $primaryKey = 'mark_id';
    public $timestamps = false;

    protected $fillable = [
        'exam_id',
        'class_id',
        'subject_id',
        'marks',
        'class_marks',
        'contributions',
        'attendance',
        'grade_id',
        'student_id',
        'marks_comment',
        'created_date',
        'modified_date',
        'created_by',
        'section_id'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'exam_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subid');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'ID');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }
}