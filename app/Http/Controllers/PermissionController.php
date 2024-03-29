<?php

namespace App\Http\Controllers;

use Validator;
use App\Permission;
use App\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $permission = Permission::with('user')->orderBy('created_at', 'desc')->get();

            $response = [
                'success' => true,
                'data' => $permission,
                'message' => 'Successful permission listing!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    public function indexByUser($id)
    {
        try {
            $permission = Permission::with('user')->where("user_id", $id)->orderBy('created_at', 'desc')->get();

            $response = [
                'success' => true,
                'data' => $permission,
                'message' => 'Successfully created permiss$permission!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    public function checkPermission($id)
    {
        try {
            $permission = Permission::whereRaw('status = 1 && user_id = ' . $id . ' && MONTH(created_at) = MONTH(CURRENT_DATE())')->count();
            return $permission;
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'type' => 'required|string',
            'description' => 'string',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($v->fails()) return response()->json(["errors" => $v->errors()], 400);

        $permission = new Permission([
            'type'     => $request->type,
            'description'     => $request->description,
            'date_start'     => $request->date_start,
            'date_end'     => $request->date_end,
            'user_id' => $request->user_id
        ]);

        try {
            $user = User::find($request->user_id);
            if (!$user) return jsend_error('User not found!');

            if (self::checkPermission($request->user_id) === 3) {
                return jsend_error('Límite máximo de permisos en el mes');
            } else {
                $permission->save();
            }

            $response = [
                'success' => true,
                'data' => $permission,
                'message' => 'Successfully created permission!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $permission = Permission::with('user')->where('id', $id)->get();

            if (!$permission) return jsend_error('Permission not found!');

            $response = [
                'success' => true,
                'data' => $permission,
                'message' => 'Successful permission listing!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $permission = Permission::find($id);
            if (!$permission) return jsend_error('Permission not found!');

            $permission->type    = $request->type;
            $permission->description   = $request->description;
            $permission->date_start    = $request->date_start;
            $permission->date_end    = $request->date_end;
            $permission->save();

            $response = [
                'success' => true,
                'data' => $permission,
                'message' => 'Successfully updated permission!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */

    public function acceptDeny(Request $request, $id)
    {
        try {
            $permission = Permission::find($id);
            if (!$permission) return jsend_error('Permission not found!');

            $permission->status = $request->status;
            $permission->user_id = $request->user_id;

            if (self::checkPermission($request->user_id) === 3) {
                return jsend_error('Límite máximo de permisos en el mes');
            } else {
                $permission->save();
            }
            $permission->save();

            $response = [
                'success' => true,
                'message' => 'Permission status has changed!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
}
