<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryProduct extends Product
{
    /** @use HasFactory<\Database\Factories\AccessoryProductFactory> */
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'accessories_products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'brand',
        'product_type',
    ];
}
