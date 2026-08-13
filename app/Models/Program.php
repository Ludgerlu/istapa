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
        'view_count',
        'is_published',
        'sort_order',
        // New fields
        'degree_code',
        'degree_name_en',
        'degree_name_fr',
        'degree_description_en',
        'degree_description_fr',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'duration_months' => 'integer',
        'view_count' => 'integer',
    ];

    // Relationships
    public function translations()
    {
        return $this->hasMany(ProgramTranslation::class);
    }

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    public function admissionRequests()
    {
        return $this->hasMany(AdmissionRequest::class);
    }

    public function images()
    {
        return $this->hasMany(ProgramImage::class)->orderBy('is_cover', 'desc')->orderBy('sort_order');
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class, 'program_certificates');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', 1)->orderBy('sort_order');
    }

    // Accessors for localized fields
    public function getTitleAttribute()
    {
        return app()->getLocale() === 'fr' ? $this->title_fr : $this->title_en;
    }

    public function getContentAttribute()
    {
        return app()->getLocale() === 'fr' ? $this->content_fr : $this->content_en;
    }

    public function getExcerptAttribute()
    {
        return app()->getLocale() === 'fr' ? $this->short_description_fr : $this->short_description_en;
    }

    public function getDegreeNameAttribute()
    {
        return app()->getLocale() === 'fr' ? $this->degree_name_fr : $this->degree_name_en;
    }

    public function getDegreeDescriptionAttribute()
    {
        return app()->getLocale() === 'fr' ? $this->degree_description_fr : $this->degree_description_en;
    }
}