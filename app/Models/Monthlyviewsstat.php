<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monthlyviewsstat extends Model
{
    protected $table = 'monthly_views_stats';

    protected $fillable = [
        'item_type',
        'item_id',
        'year',
        'month',
        'cumulative_views',
        'month_views',
    ];

    protected $casts = [
        'year'             => 'integer',
        'month'            => 'integer',
        'cumulative_views' => 'integer',
        'month_views'      => 'integer',
    ];
}
