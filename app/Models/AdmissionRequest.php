<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionRequest extends Model
{
    protected $table = 'admission_requests';
    public $timestamps = true;

    protected $fillable = [
        'reference_code', 'first_name', 'last_name', 'email', 'phone', 'birth_date',
        'gender', 'address', 'city', 'country', 'program_id', 'previous_school',
        'previous_diploma', 'motivation', 'status', 'status_comment', 'reviewed_by',
        'reviewed_at', 'converted_user_id'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function convertedUser()
    {
        return $this->belongsTo(User::class, 'converted_user_id');
    }

    public function documents()
    {
        return $this->hasMany(AdmissionDocument::class, 'admission_request_id');
    }
}