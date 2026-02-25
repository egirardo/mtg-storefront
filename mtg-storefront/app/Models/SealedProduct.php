<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SealedProduct extends Product
{
    /** @use HasFactory<\Database\Factories\SealedProductFactory> */
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'sealed_products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'set_name'
    ];
}
