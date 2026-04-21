<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends User
{
    use HasFactory;

    protected $table = 'users';

    /**
     * Filter only students using the `type` column (replaces the old
     * WordPress wp_capabilities meta key approach).
     */
    protected static function booted(): void
    {
        static::addGlobalScope('student', fn ($q) => $q->where('type', 'student'));
    }

    // ─── Computed attributes ────────────────────────────────────────────────────

    public function getTotalPaidAttribute(): float
    {
        return $this->feesPayments()->sum('fees_paid_amount');
    }

    public function getTotalFeesAttribute(): float
    {
        return $this->feesPayments()->sum('total_amount');
    }

    public function getBalanceAttribute(): float
    {
        return $this->total_fees - $this->total_paid;
    }

    // ─── Relationships ──────────────────────────────────────────────────────────

    public function homeworks()
    {
        return $this->hasMany(StudentHomework::class, 'student_id', 'id');
    }

    public function subAttendances()
    {
        return $this->hasMany(SubAttendance::class, 'student_id', 'id');
    }

    public function examHallReceipts()
    {
        return $this->hasMany(ExamHallReceipt::class, 'student_id', 'id');
    }

    public function libraryIssues()
    {
        return $this->hasMany(LibraryBookIssue::class, 'student_id', 'id');
    }

    public function assignedBed()
    {
        return $this->hasOne(AssignBed::class, 'student_id', 'id');
    }

    public function transport()
    {
        return $this->hasOne(AssignTransport::class, 'route_user', 'id');
    }
}