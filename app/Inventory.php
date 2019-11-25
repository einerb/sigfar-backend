<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'code',
        'date_start',
        'date_end',
        'quantity_start',
        'quantity_end',
        'price_start',
        'price_end',
        'stock',
        'product_id',
        'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
