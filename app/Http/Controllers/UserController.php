<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string',
                'lastname' => 'required|string',
                'email'    => 'required|string|email|unique:users',
                'password' => 'required|string',
                'role_id'  => 'integer',
                'birthdate' => 'string',
                'address'  => 'string',
                'phone'    => 'string',
                'status'   => 'boolean',
            ]);
            $user = new User([
                'name'     => $request->name,
                'lastname' => $request->lastname,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => $request->status,
                'activation_token'  => Str::random(60),
            ]);
            $user->save();
            /* $user->notify(new SignupActivate($user)); */

            return response()->json(['message' => 'User created successfully!'], 201);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
}
