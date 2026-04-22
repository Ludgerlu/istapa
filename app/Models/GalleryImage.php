<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $table = 'gallery_images';
    public $timestamps = false;
    protected $fillable = ['album_id', 'image_path', 'caption', 'sort_order', 'uploaded_by', 'created_at'];
    public function album() { return $this->belongsTo(GalleryAlbum::class, 'album_id'); }
    public function uploader() { return $this->belongsTo(User::class, 'uploaded_by'); }
}
