<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends User
{
    use HasFactory;

    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('teacher', fn ($q) => $q->where('type', 'teacher'));
    }
}