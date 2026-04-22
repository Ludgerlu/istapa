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
    public function translations() { return $this->hasMany(TestimonialTranslation::class, 'testimonial_id'); }
}
