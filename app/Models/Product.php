<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'category',
        'brand',
        'stock',
        'is_active',
        'specifications',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
            'specifications' => 'array',
        ];
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(
            fn() => $this->image
                ? asset('storage/' . $this->image)
                : asset('images/product-placeholder.png')
        );
    }
}
