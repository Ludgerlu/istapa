<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends User
{
    use HasFactory;

    protected $table = 'users';

    // Override boot method to filter only students
    protected static function booted()
    {
        static::addGlobalScope('student', function ($builder) {
            $builder->whereHas('userMeta', function($q) {
                $q->where('meta_key', 'wp_capabilities')
                  ->where('meta_value', 'like', '%student%');
            });
        });
    }

    // Student specific accessors
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

    public function getAddressAttribute()
    {
        return $this->getMeta('address');
    }

    public function getGenderAttribute()
    {
        return $this->getMeta('gender');
    }

    public function getBirthDateAttribute()
    {
        return $this->getMeta('birth_date');
    }

    public function feesPayments()
    {
        return $this->hasMany(FeesPayment::class, 'student_id', 'ID');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id', 'ID');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'student_id', 'ID');
    }

    public function leaveRequests()
    {
        return $this->hasMany(Leave::class, 'student_id', 'ID');
    }

    public function getTotalPaidAttribute()
    {
        return $this->feesPayments()->sum('fees_paid_amount');
    }

    public function getTotalFeesAttribute()
    {
        return $this->feesPayments()->sum('total_amount');
    }

    public function getBalanceAttribute()
    {
        return $this->getTotalFeesAttribute() - $this->getTotalPaidAttribute();
    }
}