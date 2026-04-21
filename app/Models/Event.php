<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $primaryKey = 'event_id';
    public $timestamps = false;

    protected $fillable = [
        'event_title',
        'description',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'event_doc',
        'created_by',
        'created_date'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'ID');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())->orderBy('start_date');
    }
}