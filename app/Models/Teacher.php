<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends User
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('teacher', function ($query) {
            $query->where('role', 'teacher');
        });
    }

    public function details()
    {
        return $this->hasOne(TeacherDetail::class, 'user_id');
    }
}