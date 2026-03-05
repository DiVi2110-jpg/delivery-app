<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'type',
        'unit',
        'portion_weight',
        'image_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'integer',
        'portion_weight' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
