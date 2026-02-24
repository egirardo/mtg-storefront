<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // table we're using
    protected $table = 'products';

    // primary key for table (since it's not set to id)
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'category_id',
        'price',
        'stock',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function single()
    {
        return $this->hasOne(SingleProduct::class, 'product_id', 'product_id');
    }

    public function sealed()
    {
        return $this->hasOne(SealedProduct::class, 'product_id', 'product_id');
    }

    public function accessory()
    {
        return $this->hasOne(AccessoryProduct::class, 'product_id', 'product_id');
    }
}
