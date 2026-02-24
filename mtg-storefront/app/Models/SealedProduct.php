<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SealedProduct extends Product
{
    /** @use HasFactory<\Database\Factories\SealedProductFactory> */
    use HasFactory;
}
