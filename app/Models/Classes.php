<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';
    public $timestamps = false;

    protected $fillable = [
        'program_id', 
        'academic_year_id', 
        'name', 
        'section', 
        'capacity', 
        'head_teacher_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function headTeacher()
    {
        return $this->belongsTo(TeacherDetail::class, 'head_teacher_id', 'user_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }

    public function classEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class, 'class_id');
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'class_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'class_id');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class, 'class_id');
    }
}