<?php

namespace App;

use App\User;
use App\Product;
use App\DetailsOrder;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'delivery_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailsOrder()
    {
        return $this->hasMany(DetailsOrder::class);
    }
}
