<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramImage extends Model
{
    protected $table = 'program_images';
    public $timestamps = true;

    protected $fillable = [
        'program_id',
        'image_path',
        'alt_en',
        'alt_fr',
        'is_cover',
        'sort_order',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function getAltAttribute()
    {
        return app()->getLocale() === 'fr' ? $this->alt_fr : $this->alt_en;
    }
}
