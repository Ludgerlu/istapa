<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'user_id'; // because user_id is PK
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'matricule', 'enrollment_date', 'guardian_name',
        'guardian_phone', 'guardian_email', 'blood_group', 'medical_notes'
    ];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classEnrollments()
    {
        return $this->hasMany(ClassEnrollment::class, 'student_id', 'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(AttendanceDetail::class, 'student_id', 'user_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'student_id', 'user_id');
    }

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class, 'student_id', 'user_id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'student_id', 'user_id');
    }
}