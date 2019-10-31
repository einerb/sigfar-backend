<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'type',
        'company_name',
        'representative',
        'address',
        'phone',
        'email'
    ];
}
