<?php
namespace Core\UserType;


use Core\Base\BaseRepo;
use Illuminate\Support\Facades\Hash;

class UserTypeRepo extends BaseRepo
{

    public function getModel()
    {
        return new UserType();
    }

}

