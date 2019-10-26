<?php

namespace App;

use App\Supplier;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'health_registration',
        'date_dispatch',
        'expiration_date',
        'medical_specimen',
        'unity',
        'via_administration',
        'concentration',
        'pharmaceutical_form',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsToMany(Supplier::class);
    }
}
