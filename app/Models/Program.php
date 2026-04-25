<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';
    public $timestamps = true;

    protected $fillable = [
        'slug', 
        'cover_image', 
        'duration_months', 
        'title_en', 
        'title_fr',
        'short_description_en', 
        'short_description_fr', 
        'content_en',
        'content_fr', 
        'is_published', 
        'sort_order'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'duration_months' => 'integer',
    ];

    public function translations()
    {
        return $this->hasMany(ProgramTranslation::class, 'program_id');
    }

    public function classes()
    {
        return $this->hasMany(Classes::class, 'program_id');
    }

    public function admissionRequests()
    {
        return $this->hasMany(AdmissionRequest::class, 'program_id');
    }

    public function upcomingSessions()
    {
        return $this->hasMany(UpcomingSession::class, 'program_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', 1)->orderBy('sort_order');
    }
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' ? $this->title_fr : $this->title_en;
    }

    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' ? $this->content_fr : $this->content_en;
    }

    public function getExcerptAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' ? $this->short_description_fr : $this->short_description_en;
    }
}