<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeCategory extends Model
{
    protected $table = 'fee_categories';
    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'description', 'sort_order'];

    public function fees()
    {
        return $this->hasMany(Fee::class, 'fee_category_id');
    }
}