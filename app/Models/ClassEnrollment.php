<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassEnrollment extends Model
{
    protected $table = 'class_enrollments';
    public $timestamps = false;

    protected $fillable = ['student_id', 'class_id', 'enrolled_at', 'status'];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(StudentDetail::class, 'student_id', 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}