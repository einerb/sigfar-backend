<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailsOrder extends Model
{
    protected $fillable = [
        'description',
        'quantity',
        'price',
        'order_id',
        'product_id',
    ];

    public function product()
    {
        return $this->hasMany(Product::class, "id", "product_id");
    }
}
