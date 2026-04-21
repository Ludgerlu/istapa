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
    public $timestamps = false;

    protected $fillable = [
        'login',
        'password',
        'nicename',
        'email',
        'type',           // 'admin' | 'teacher' | 'student'
        'registered',
        'user_activation_key',
        'user_status',
        'display_name',
    ];

    protected $hidden = [
        'password',
        'user_activation_key',
    ];

    protected $casts = [
        'registered'  => 'datetime',
        'user_status' => 'integer',
    ];

    // ─── Auth ──────────────────────────────────────────────────────────────────

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function getAuthIdentifierName()
    {
        return 'login';
    }

    public function getAuthIdentifier()
    {
        return $this->login;
    }

    // ─── Relationships ──────────────────────────────────────────────────────────

    public function userMeta()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'id');
    }

    // ─── Meta helpers ───────────────────────────────────────────────────────────

    public function getMeta(string $key): ?string
    {
        // Use eager-loaded collection when available to avoid N+1
        if ($this->relationLoaded('userMeta')) {
            return $this->userMeta->where('meta_key', $key)->value('meta_value');
        }

        return $this->userMeta()->where('meta_key', $key)->value('meta_value');
    }

    public function setMeta(string $key, string $value): void
    {
        $this->userMeta()->updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    // ─── Role helpers (now uses the `type` column directly) ────────────────────

    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    public function isTeacher(): bool
    {
        return $this->type === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->type === 'student';
    }

    public function getRole(): string
    {
        return in_array($this->type, ['admin', 'teacher', 'student'])
            ? $this->type
            : 'subscriber';
    }

    // ─── Accessors (common profile fields stored in usermeta) ──────────────────

    public function getFirstNameAttribute(): ?string
    {
        return $this->getMeta('first_name');
    }

    public function getLastNameAttribute(): ?string
    {
        return $this->getMeta('last_name');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name) ?: $this->display_name;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->getMeta('mobile_number');
    }

    public function getAddressAttribute(): ?string
    {
        return $this->getMeta('address');
    }

    public function getGenderAttribute(): ?string
    {
        return $this->getMeta('gender');
    }

    public function getBirthDateAttribute(): ?string
    {
        return $this->getMeta('birth_date');
    }

    public function getProfilePhotoAttribute(): ?string
    {
        return $this->getMeta('profile_image');
    }

    // ─── Student-specific relationships ────────────────────────────────────────

    public function studentClass(): ?object
    {
        $classId = $this->getMeta('class_name');
        return $classId ? SchoolClass::find($classId) : null;
    }

    public function studentSection(): ?object
    {
        $sectionId = $this->getMeta('class_section');
        return $sectionId ? ClassSection::find($sectionId) : null;
    }

    public function rollId(): ?string
    {
        return $this->getMeta('roll_id');
    }

    public function feesPayments()
    {
        return $this->hasMany(FeesPayment::class, 'student_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'student_id', 'id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(Leave::class, 'student_id', 'id');
    }

    // ─── Teacher-specific relationships ────────────────────────────────────────

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id', 'id');
    }

    public function teacherClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_class', 'teacher_id', 'class_id', 'id', 'class_id');
    }

    public function teacherSubjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject', 'teacher_id', 'subject_id', 'id', 'id');
    }

    public function timetables()
    {
        return $this->hasMany(TimeTable::class, 'teacher_id', 'id');
    }

    // ─── Common scopes ─────────────────────────────────────────────────────────

    public function scopeStudents($query)
    {
        return $query->where('type', 'student');
    }

    public function scopeTeachers($query)
    {
        return $query->where('type', 'teacher');
    }

    public function scopeAdmins($query)
    {
        return $query->where('type', 'admin');
    }
}