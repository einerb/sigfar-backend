<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
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

            $orders = Order::join('details_orders', "orders.id", "=", "details_orders.order_id")
                ->join('products', "details_orders.product_id", "=", "products.id")
                ->join('users', "users.id","=","orders.user_id")
                ->get();

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
            $order = Order::with('user')->where("user_id", $id)->get();

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
            'user_id' => 'required|integer'
        ]);

        if ($v->fails()) return response()->json(["errors" => $v->errors()], 400);

        try {
            $first = "00000001";
            if (Order::all()->count() > 0) {
                $increment = Order::orderBy('created_at', 'DESC')->first();
                $consecutive = str_pad($increment->id + 1, 8, "0", STR_PAD_LEFT);
            } else {
                $consecutive = $first;
            }

            $order = new Order([
                'code' => $consecutive,
                'user_id' => $request->user_id,
            ]);

            $user = User::find($request->user_id);
            if (!$user) return jsend_error('User not found!');

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
