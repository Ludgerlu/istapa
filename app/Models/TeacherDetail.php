<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherDetail extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'employee_number', 'hire_date', 'specialization', 'bio'
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id', 'user_id');
    }

    public function classesHeaded()
    {
        return $this->hasMany(Classes::class, 'head_teacher_id', 'user_id');
    }
}