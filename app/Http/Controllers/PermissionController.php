<?php

namespace App\Http\Controllers;

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
            $permission = Permission::with('user')->get();

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'type' => 'required|string',
                'description' => 'string',
                'date_start' => 'required',
                'date_end' => 'required',
                'user_id' => 'integer'
            ]);
            $permission = new Permission([
                'type'     => $request->type,
                'description'     => $request->description,
                'date_start'     => $request->date_start,
                'date_end'     => $request->date_end,
                'user_id' => $request->user_id
            ]);

            $user = User::find($request->user_id);

            if (!$user) return jsend_error('User not found!');

            $permission->save();

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
    public function destroy($id)
    {
        try {
            $permission = Permission::find($id);
            if (!$permission) return jsend_error('Permission not found!');

            $permission->status = false;
            $permission->save();

            $response = [
                'success' => true,
                'message' => 'Permission has been disabled!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
}
