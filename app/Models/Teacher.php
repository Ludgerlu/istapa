<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends User
{
    use HasFactory;

    protected $table = 'users';

    protected static function booted()
    {
        static::addGlobalScope('teacher', function ($builder) {
            $builder->whereHas('userMeta', function($q) {
                $q->where('meta_key', 'wp_capabilities')
                  ->where('meta_value', 'like', '%teacher%');
            });
        });
    }

    public function getFullNameAttribute()
    {
        $firstName = $this->getMeta('first_name');
        $lastName = $this->getMeta('last_name');
        return trim($firstName . ' ' . $lastName);
    }

    public function getPhoneAttribute()
    {
        return $this->getMeta('mobile_number');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id', 'ID');
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'teacher_class', 'teacher_id', 'class_id', 'ID', 'class_id');
    }

    public function timetables()
    {
        return $this->hasMany(TimeTable::class, 'teacher_id', 'ID');
    }
}