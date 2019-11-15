<?php

namespace App;

use App\User;
use App\Product;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'description',
        'quantity',
        'price',
        'user_id',
        'product_id',
        'delivery_date',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
