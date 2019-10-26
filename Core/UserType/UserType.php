<?php

namespace Core\UserType;

use Core\Base\BaseEntity;
use Illuminate\Support\Facades\Hash;

class UserType extends BaseEntity
{
    protected $fillable = [
        'name','description',
    ];
}
