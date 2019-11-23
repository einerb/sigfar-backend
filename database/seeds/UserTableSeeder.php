<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Einer';
        $user->lastname = 'Bravo';
        $user->email = 'admin@sigafar.com';
        $user->password = bcrypt('12345');
        $user->status = 1;
        $user->role_id = 1;
        $user->activation_token  = Str::random(60);

        $user->save();
    }
}
