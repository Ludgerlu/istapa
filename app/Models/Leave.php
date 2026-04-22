<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leave_requests';
    public $timestamps = true;

    protected $fillable = [
        'student_id', 'leave_type', 'start_date', 'end_date', 'reason',
        'attachment', 'status', 'reviewed_by', 'review_comment', 'reviewed_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(StudentDetail::class, 'student_id', 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}