<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';
    public $timestamps = false;

    protected $fillable = ['slug', 'sort_order'];

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'blog_category_id');
    }

    public function translations()
    {
        return $this->hasMany(BlogCategoryTranslation::class, 'blog_category_id');
    }
}