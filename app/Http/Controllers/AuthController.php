<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
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
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at
            )
                ->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' =>
        'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    
    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => 'Activation token is invalid!'], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }
}
