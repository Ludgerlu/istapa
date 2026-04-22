<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    protected $table = 'attendance_details';
    public $timestamps = false;

    protected $fillable = ['attendance_session_id', 'student_id', 'status', 'comment'];

    public function session()
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }

    public function student()
    {
        return $this->belongsTo(StudentDetail::class, 'student_id', 'user_id');
    }
}