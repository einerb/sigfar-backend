<?php

namespace App\Http\Controllers;

use App\DetailsOrder;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Product;
use Validator;
use Illuminate\Http\Request;

class DetailsOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $orders = DetailsOrder::with('product')->get();

            $response = [
                'success' => true,
                'data' => $orders,
                'message' => 'Successful orders listing!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    public function indexOrder($id)
    {
        try {

            $orders = Order::select('id')->first();

            return $orders->id;
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
            'description' => 'string',
            'quantity' => 'integer',
            'price'  => 'required',
            'product_id' => 'required|integer'
        ]);

        if ($v->fails()) return response()->json(["errors" => $v->errors()], 400);

        $orders = Order::select('id')->first();
        try {
            $detailsOrder = new DetailsOrder([
                'description' => $request->description,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'order_id' => $orders->id,
                'product_id' => $request->product_id
            ]);

            $product = Product::find($request->product_id);
            if (!$product) return jsend_error('Producto no existe!');

            $detailsOrder->save();

            $response = [
                'success' => true,
                'data' => $detailsOrder,
                'message' => 'Successfully created order!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailsOrder  $detailsOrder
     * @return \Illuminate\Http\Response
     */
    public function show(DetailsOrder $detailsOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailsOrder  $detailsOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailsOrder $detailsOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailsOrder  $detailsOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailsOrder $detailsOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailsOrder  $detailsOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailsOrder $detailsOrder)
    {
        //
    }
}
