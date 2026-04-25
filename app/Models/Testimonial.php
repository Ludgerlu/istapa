<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $table = 'testimonials';
    public $timestamps = false;
    protected $fillable = ['author_name', 'author_role', 'author_photo', 'rating', 'content_en', 'content_fr', 'is_published', 'sort_order', 'created_at'];
    
    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }
    
    public function translations() 
    { 
        return $this->hasMany(TestimonialTranslation::class, 'testimonial_id'); 
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
        return $locale === 'fr' ? $this->excerpt_fr : $this->excerpt_en;
    }
}
