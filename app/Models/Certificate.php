<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificates';
    public $timestamps = true;

    protected $fillable = [
        'code',
        'name_en',
        'name_fr',
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_certificates');
    }

    public function getNameAttribute()
    {
        return app()->getLocale() === 'fr' ? $this->name_fr : $this->name_en;
    }
}
