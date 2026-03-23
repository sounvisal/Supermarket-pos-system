<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'invoice_number',
        'user_id',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'grand_total',
        'payment_method',
        'cashier_name',
        'customer_name',
        'notes',
        'status'
    ];
    
    /**
     * Get the items for the sale.
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
    
    /**
     * Get the user who processed the sale.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Generate a unique invoice number
     */
    public static function generateInvoiceNumber()
    {
        $prefix = 'INV-' . date('Ymd');
        $lastSale = self::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();
            
        if ($lastSale) {
            // Extract the number from the last invoice and increment
            $lastNumber = (int) substr($lastSale->invoice_number, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        // Format with leading zeros (4 digits)
        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
} 