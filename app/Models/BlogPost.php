<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';
    public $timestamps = true;

    protected $fillable = [
        'blog_category_id', 'author_id', 'slug', 'title_en', 'title_fr',
        'excerpt_en', 'excerpt_fr', 'content_en', 'content_fr',
        'meta_description_en', 'meta_description_fr', 'cover_image',
        'status', 'view_count', 'published_at'
    ];

    protected $casts = [
        'view_count' => 'integer',
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_post_id');
    }

    public function translations()
    {
        return $this->hasMany(BlogPostTranslation::class, 'blog_post_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
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