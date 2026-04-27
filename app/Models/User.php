<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true; // created_at & updated_at exist

    protected $fillable = [
        'email', 
        'password_hash', 
        'role', 
        'first_name', 
        'last_name', 
        'middle_name',
        'phone', 
        'alt_phone', 
        'avatar', 
        'gender', 
        'birth_date', 
        'address', 
        'city',
        'country', 
        'preferred_language', 
        'is_active', 
        'email_verified_at',
        'last_login_at', 
        'remember_token',
    ];

    protected $hidden = [
        'password_hash', 'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'birth_date' => 'date',
    ];

    // Auth: Laravel expects 'password' field
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Role checks
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    // Relationships
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function blogComments()
    {
        return $this->hasMany(BlogComment::class, 'user_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function reviewedAdmissions()
    {
        return $this->hasMany(AdmissionRequest::class, 'reviewed_by');
    }

    public function convertedAdmissions()
    {
        return $this->hasMany(AdmissionRequest::class, 'converted_user_id');
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'taken_by');
    }

    public function attendances()
    {
        return $this->hasMany(AttendanceDetail::class, 'student_id');
    }

    public function examsCreated()
    {
        return $this->hasMany(Exam::class, 'created_by');
    }

    public function feePaymentsReceived()
    {
        return $this->hasMany(FeePayment::class, 'received_by');
    }

    public function marksEntered()
    {
        return $this->hasMany(Mark::class, 'entered_by');
    }

    public function galleryImagesUploaded()
    {
        return $this->hasMany(GalleryImage::class, 'uploaded_by');
    }

    public function leaveRequestsReviewed()
    {
        return $this->hasMany(LeaveRequest::class, 'reviewed_by');
    }

    // ─── Common scopes ─────────────────────────────────────────────────────────

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeTeachers($query)
    {
        return $query->where('role', 'teacher');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
}