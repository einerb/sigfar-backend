<?php

namespace App;

use App\DetailOrder;
use App\Supplier;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'health_registration',
        'date_dispatch',
        'expiration_date',
        'unity',
        'via_administration',
        'concentration',
        'pharmaceutical_form',
        'image',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsToMany(Supplier::class);
    }
}
