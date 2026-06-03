<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'name',
    'sku',
    'category_id',
    'price',
    'stock',
    'status',
    'description',
    'image',
    'is_deal',
    'discount_price',
    'rating',
    'condition'
];
    public function category()
{
    return $this->belongsTo(Category::class);
}
}
