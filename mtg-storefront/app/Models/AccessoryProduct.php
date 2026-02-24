<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryProduct extends Product
{
    /** @use HasFactory<\Database\Factories\AccessoryProductFactory> */
    use HasFactory;

    protected $table = 'accessories_products';

    protected $fillable = [
        'product_type'
    ];
}
