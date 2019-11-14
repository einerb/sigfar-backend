<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('role')->get();

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

    public function indexByRole($id)
    {
        try {
            $users = User::with('role')->where("role_id", $id)->get();

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

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'     => 'required|string',
            'lastname' => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string',
            'role_id'  => 'numeric',
            'address'  => 'string',
            'phone'    => 'string',
        ]);

        if ($v->fails()) return response()->json(["errors" => $v->errors()], 400);

        $user = new User([
            'name'     => $request->name,
            'lastname' => $request->lastname,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'address' => $request->address,
            'phone' => $request->phone,
            'activation_token'  => Str::random(60),
        ]);

        try {
            $user->save();
            /* $user->notify(new SignupActivate($user)); */

            return response()->json(['message' => 'User created successfully!'], 200);
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
