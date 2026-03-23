<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'is_default',
        'apply_to_all_products',
        'description'
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'is_default' => 'boolean',
        'apply_to_all_products' => 'boolean'
    ];

    /**
     * Get the default tax rate.
     */
    public static function getDefault()
    {
        return self::where('is_default', true)->first() ?? self::first();
    }

    /**
     * Set this tax rate as the default and unset any other default.
     */
    public function setAsDefault()
    {
        // Unset all other defaults
        self::where('is_default', true)->update(['is_default' => false]);
        
        // Set this as default
        $this->is_default = true;
        $this->save();
        
        return $this;
    }
}
