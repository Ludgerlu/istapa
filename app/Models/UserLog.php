<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = 'user_log';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_login',
        'role',
        'ip_address',
        'created_at',
        'date_time',
        'deleted_status'
    ];
}