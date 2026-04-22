<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    public $timestamps = false;

    protected $fillable = [
        'class_id', 'teacher_id', 'name', 'code', 'coefficient', 'hours_per_week', 'description'
    ];

    protected $casts = [
        'coefficient' => 'float',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function teacher()
    {
        return $this->belongsTo(TeacherDetail::class, 'teacher_id', 'user_id');
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class, 'subject_id');
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'subject_id');
    }
}