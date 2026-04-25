<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryAlbum extends Model
{
    use HasFactory;
    protected $table = 'gallery_albums';
    public $timestamps = false;
    protected $fillable = ['slug', 'cover_image', 'sort_order', 'created_at'];
    public function images() { return $this->hasMany(GalleryImage::class, 'album_id'); }
    public function translations() { return $this->hasMany(GalleryAlbumTranslation::class, 'album_id'); }

}
