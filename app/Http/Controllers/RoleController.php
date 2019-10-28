<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    public function index()
    {
        try {

            $roles = Role::all();

            $response = [
                'success' => true,
                'data' => $roles,
                'message' => 'Successful roles listing!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
}
