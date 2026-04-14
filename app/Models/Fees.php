<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    use HasFactory;

    protected $table = 'fees';
    protected $primaryKey = 'fees_id';
    public $timestamps = false;

    protected $fillable = [
        'fees_title_id',
        'class_id',
        'fees_amount',
        'description',
        'created_date',
        'created_by',
        'section_id'
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(ClassSection::class, 'section_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(FeesPayment::class, 'fees_id', 'fees_id');
    }
}