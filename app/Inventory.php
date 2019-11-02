<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'description',
        'date_start',
        'date_end',
        'quantity_start',
        'quantity_end',
        'price_start',
        'price_end',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
