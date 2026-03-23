<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sale_id',
        'product_id',
        'product_name',
        'product_code',
        'quantity',
        'unit_price',
        'discount_percent',
        'subtotal'
    ];
    
    /**
     * Get the sale that owns the item.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    
    /**
     * Get the product associated with the item.
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
} 