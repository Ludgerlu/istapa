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
        'post_author',
        'post_date',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'post_name',
        'post_modified',
        'post_type'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'post_author', 'ID');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_post_ID', 'ID');
    }
}