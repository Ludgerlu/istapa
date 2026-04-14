<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_log';
    public $timestamps = false;

    protected $fillable = [
        'audit_action',
        'user_id',
        'action',
        'ip_address',
        'created_by',
        'created_at',
        'date_time',
        'deleted_status',
        'updated_by',
        'updated_date',
        'module'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'ID');
    }
}