<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends User
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected static function booted()
    {
        static::addGlobalScope('student', function ($query) {
            $query->where('role', 'student');
        });
    }

    public function details()
    {
        return $this->hasOne(StudentDetail::class, 'user_id');
    }

    // Accessors for student-specific fields via details
    public function getMatriculeAttribute()
    {
        return $this->details->matricule ?? null;
    }

    public function getGuardianNameAttribute()
    {
        return $this->details->guardian_name ?? null;
    }

    // Access the extra fields stored in the students table
    public function studentDetails()
    {
        return $this->hasOne(StudentDetail::class, 'user_id');
    }

    // Or use a direct relationship to the students table (one-to-one)
    public function studentRecord()
    {
        return $this->hasOne(Student::class, 'user_id', 'id'); // careful: recursive
        // Better to have a separate model for the student extension
    }

    // The actual student-specific data is in 'students' table
    // We'll define a relationship to that table
    public function info()
    {
        return $this->hasOne(StudentInfo::class, 'user_id');
    }
}