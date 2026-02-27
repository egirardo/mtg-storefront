<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleProduct extends Product
{
    /** @use HasFactory<\Database\Factories\SingleProductFactory> */
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'singles_products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'rarity',
        'color',
        'number',
        'set_name_single',
    ];
}
