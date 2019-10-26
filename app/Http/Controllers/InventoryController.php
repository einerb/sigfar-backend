<?php

namespace App\Http\Controllers;

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
            $inventory = Inventory::all();

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'description' => 'string',
                'date_start' => 'required',
                'date_end' => 'required',
                'quantity_start' => 'required|integer',
                'quantity_end' => 'required|integer',
                'price_start' => 'required',
                'price_end' => 'required',
                'product_id' => 'integer',
            ]);
            $inventory = new Inventory([
                'description' => $request->description,
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'quantity_start' => $request->quantity_start,
                'quantity_end' => $request->quantity_end,
                'price_start' => $request->price_start,
                'price_end' => $request->price_end,
                'product_id' => $request->product_id,
            ]);

            $product = Product::find($request->product_id);

            if (!$product) return jsend_error('Product not found!');

            $inventory->save();

            $response = [
                'success' => true,
                'data' => $inventory,
                'message' => 'Successfully created inventory!'
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
            $inventory = Inventory::find($id);

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
    public function destroy(Inventory $inventory)
    {
        //
    }
}
