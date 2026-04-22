<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $table = 'academic_years';
    public $timestamps = false;

    protected $fillable = [
        'label', 
        'start_date', 
        'end_date', 
        'is_current'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function classes()
    {
        return $this->hasMany(Classes::class, 'academic_year_id');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class, 'academic_year_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'academic_year_id');
    }
}