<?php

namespace App\Http\Controllers;

use Validator;
use App\Inventory;
use App\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $inventory = Inventory::with('product')->orderBy('created_at', 'desc')->where('status', true)->get();

            $response = [
                'success' => true,
                'data' => $inventory,
                'message' => 'Successful inventory listing!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $inventory = Inventory::with('product')->where('id', $id)->get();

            if (!$inventory) return jsend_error('Inventory not found!');

            $response = [
                'success' => true,
                'data' => $inventory,
                'message' => 'Successful inventory listing!'
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
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try {
            $inventory = Inventory::find($id);

            if (!$inventory) return jsend_error('Inventory not found!');

            $inventory->description = $request->description;
            $inventory->date_start = $request->date_start;
            $inventory->date_end = $request->date_end;
            $inventory->quantity_start = $request->quantity_start;
            $inventory->quantity_end = $request->quantity_end;
            $inventory->price_start = $request->price_start;
            $inventory->price_end = $request->price_end;
            $inventory->save();

            $response = [
                'success' => true,
                'data' => $inventory,
                'message' => 'Successfully updated inventory!'
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
            $inventory = Inventory::find($id);
            if (!$inventory) return jsend_error('Inventory not found!');

            $inventory->status = false;
            $inventory->save();

            $response = [
                'success' => true,
                'message' => 'Inventory has been disabled!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
}
