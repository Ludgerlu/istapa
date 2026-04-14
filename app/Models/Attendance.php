<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendence';
    protected $primaryKey = 'attendence_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'class_id',
        'attend_by',
        'attendence_date',
        'status',
        'role_name',
        'comment',
        'attendence_type'
    ];

    const STATUS_PRESENT = 'present';
    const STATUS_ABSENT = 'absent';
    const STATUS_LATE = 'late';
    const STATUS_EXCUSED = 'excused';

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'ID');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function markedBy()
    {
        return $this->belongsTo(User::class, 'attend_by', 'ID');
    }

    public function getStatusBadgeAttribute()
    {
        switch($this->status) {
            case self::STATUS_PRESENT:
                return '<span class="badge bg-success-600">Présent</span>';
            case self::STATUS_ABSENT:
                return '<span class="badge bg-danger-600">Absent</span>';
            case self::STATUS_LATE:
                return '<span class="badge bg-warning-600">En retard</span>';
            case self::STATUS_EXCUSED:
                return '<span class="badge bg-info-600">Excusé</span>';
            default:
                return '<span class="badge bg-secondary">Non défini</span>';
        }
    }
}