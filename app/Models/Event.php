<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    public $timestamps = true;

    protected $fillable = [
        'slug', 'title_en', 'title_fr', 'short_description_en', 'short_description_fr',
        'content_en', 'content_fr', 'cover_image', 'video_url', 'location','view_count',
        'start_date', 'start_time', 'end_date', 'end_time', 'is_published', 'created_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function images()
    {
        return $this->hasMany(EventImage::class, 'event_id');
    }

    public function translations()
    {
        return $this->hasMany(EventTranslation::class, 'event_id');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())->orderBy('start_date');
    }

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' ? $this->title_fr : $this->title_en;
    }

    public function getShortDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'fr' ? $this->short_description_fr : $this->short_description_en;
    }
}