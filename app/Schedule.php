<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'description',
        'date_start',
        'time_start',
        'time_end',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
