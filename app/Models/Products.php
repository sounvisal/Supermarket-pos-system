<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 

class Products extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'price',
        'qty',
        'category',
        'status',
        'image',
        'deleted_at'
    ];
}
