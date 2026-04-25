<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    protected $table = 'event_images';

    public $timestamps = false; 

    protected $fillable = [
        'event_id',
        'image_path',
        'caption',
        'sort_order'
    ];

    /**
     * Get the event that owns the image.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * Scope to order images by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}