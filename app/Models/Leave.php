<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leave';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'leave_type',
        'leave_duration',
        'start_date',
        'end_date',
        'reason',
        'status',
        'status_comment',
        'created_by',
        'created_at'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'ID');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'ID');
    }

    public function getStatusBadgeAttribute()
    {
        switch($this->status) {
            case self::STATUS_PENDING:
                return '<span class="badge bg-warning-600">En attente</span>';
            case self::STATUS_APPROVED:
                return '<span class="badge bg-success-600">Approuvé</span>';
            case self::STATUS_REJECTED:
                return '<span class="badge bg-danger-600">Refusé</span>';
            default:
                return '<span class="badge bg-secondary">Non défini</span>';
        }
    }
}