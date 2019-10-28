<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {

            $users = User::all();

            $response = [
                'success' => true,
                'data' => $users,
                'message' => 'Successful users listing!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

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

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) return jsend_error('User not found!');

            $response = [
                'success' => true,
                'data' => $user,
                'message' => 'Successful user listing!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request,  $id)
    {
        try {
            $user = User::find($id);

            if (!$user) return jsend_error('User not found!');

            $user->name     = $request->name;
            $user->lastname = $request->lastname;
            $user->email    = $request->email;
            $user->role_id = $request->role_id;
            $user->birthdate = $request->birthdate;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->save();

            $response = [
                'success' => true,
                'data' => $user,
                'message' => 'Successfully updated user!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
}
