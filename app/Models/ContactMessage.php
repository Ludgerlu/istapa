<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $table = 'contact_messages';
    public $timestamps = false;
    protected $fillable = ['full_name', 'email', 'phone', 'subject', 'message', 'status', 'ip_address', 'created_at'];
}
