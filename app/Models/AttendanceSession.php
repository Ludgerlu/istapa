<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    protected $table = 'attendance_sessions';
    public $timestamps = false;

    protected $fillable = ['class_id', 'subject_id', 'session_date', 'start_time', 'end_time', 'taken_by', 'notes'];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function takenBy()
    {
        return $this->belongsTo(User::class, 'taken_by');
    }

    public function details()
    {
        return $this->hasMany(AttendanceDetail::class, 'attendance_session_id');
    }
}