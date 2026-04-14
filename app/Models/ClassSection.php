<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    use HasFactory;

    protected $table = 'class_section';
    public $timestamps = false;

    protected $fillable = [
        'class_id',
        'section_name'
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'class_section', 'id')
                    ->whereHas('userMeta', function($q) {
                        $q->where('meta_key', 'wp_capabilities')
                          ->where('meta_value', 'like', '%student%');
                    });
    }
}