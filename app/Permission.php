<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'type',
        'description',
        'date_start',
        'date_end',
        'user_id'
    ];

    public function permision()
    {
        return $this->hasMany(User::class);
    }
}
