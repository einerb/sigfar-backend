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

    public function schedule()
    {
        return $this->hasMany(User::class);
    }
}
