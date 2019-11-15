<?php

namespace App\Http\Controllers;

use App\Order;
use Validator;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $orders = Order::with(['user', 'product'])->orderBy('created_at', 'desc')->get();

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

    public function indexByUser($id)
    {
        try {
            $order = Order::with(['user', 'product'])->where("user_id", $id)->get();

            $response = [
                'success' => true,
                'data' => $order,
                'message' => 'Successfully created order!'
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
        $v = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'description' => 'string',
            'quantity' => 'integer',
            'price' => 'required',
            'product_id' => 'required|integer',
            'delivery_date' => 'required'
        ]);

        if ($v->fails()) return response()->json(["errors" => $v->errors()], 400);

        try {
            $order = new Order([
                'description' => $request->description,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'product_id' => $request->product_id,
                'delivery_date' => $request->delivery_date,
                'user_id' => $request->user_id,
            ]);
            $order->save();

            $response = [
                'success' => true,
                'data' => $order,
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $order = Order::find($id);

            if (!$order) return jsend_error('Order not found!');

            $response = [
                'success' => true,
                'data' => $order,
                'message' => 'Successful order listing!'
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $order = Order::find($id);

            if (!$order) return jsend_error('Order not found!');

            $order->status = $request->status;
            $order->save();

            $response = [
                'success' => true,
                'data' => $order,
                'message' => 'Successfully updated order!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order = Order::find($id);
            if (!$order) return jsend_error('Order not found!');

            $order->status = 4;
            $order->save();

            $response = [
                'success' => true,
                'message' => 'Order successfully removed!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
}
