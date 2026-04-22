<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramTranslation extends Model
{
    protected $table = 'program_translations';
    public $timestamps = false;

    protected $fillable = [
        'program_id', 
        'language_code', 
        'title', 
        'short_description', 
        'content'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}