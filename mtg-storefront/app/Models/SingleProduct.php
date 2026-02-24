<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleProduct extends Product
{
    /** @use HasFactory<\Database\Factories\SingleProductFactory> */
    use HasFactory;
}
