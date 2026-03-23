<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active',
        'description'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'discount_percentage' => 'decimal:2'
    ];

    /**
     * Get the product associated with the discount.
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    /**
     * Scope a query to only include active discounts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->where('end_date', '>=', now()->format('Y-m-d'))
                          ->orWhereNull('end_date');
                    })
                    ->where('start_date', '<=', now()->format('Y-m-d'));
    }

    /**
     * Scope a query to only include discounts for a specific product.
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope a query to only include discounts for a specific category.
     */
    public function scopeForCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
