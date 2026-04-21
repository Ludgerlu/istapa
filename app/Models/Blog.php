<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'posts'; // Assuming WordPress-like structure
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'author_id ',
        'post_date',
        'post_content',
        'title',
        'post_excerpt',
        'status',
        'comment_status',
        'post_name',
        'post_modified',
        'post_type',
        'cover_image',
        'views',
        'created_at',
        'updated_at'
    ];

    // ─── Relationships ──────────────────────────────────────────────────────────
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_post_ID', 'ID');
    }
 
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
 
    // ─── Scopes ─────────────────────────────────────────────────────────────────
 
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->latest();
    }
 
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft')->latest();
    }
 
    // ─── Helpers ────────────────────────────────────────────────────────────────
 
    public function getExcerptOrTrimmedAttribute(): string
    {
        return $this->excerpt ?: str($this->content)->stripTags()->limit(160);
    }
 
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}