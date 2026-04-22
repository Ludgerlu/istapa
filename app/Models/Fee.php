<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $table = 'fees';
    public $timestamps = false;

    protected $fillable = ['class_id', 'academic_year_id', 'fee_category_id', 'amount', 'due_date', 'description'];

    protected $casts = [
        'amount' => 'float',
        'due_date' => 'date',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function category()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id');
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class, 'fee_id');
    }
}