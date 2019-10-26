<?php

namespace App\Http\Controllers;

use App\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $products = Product::all();

            $response = [
                'success' => true,
                'data' => $products,
                'message' => 'Successful product listing!'
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
                'name' => 'required|string',
                'description' => 'required|string',
                'health_registration' => 'required|string',
                'date_dispatch' => 'required',
                'expiration_date' => 'required',
                'medical_specimen' => 'boolean',
                'unity' => 'required|string',
                'via_administration' => 'required|string',
                'concentration' => 'required|string',
                'pharmaceutical_form' => 'required|string'
            ]);
            $product = new Product([
                'name'     => $request->name,
                'description'     => $request->description,
                'health_registration'     => $request->health_registration,
                'date_dispatch'     => $request->date_dispatch,
                'expiration_date'     => $request->expiration_date,
                'medical_specimen'     => $request->medical_specimen,
                'unity'     => $request->unity,
                'via_administration'     => $request->via_administration,
                'concentration' => $request->concentration,
                'pharmaceutical_form' => $request->pharmaceutical_form
            ]);
            $product->save();

            $response = [
                'success' => true,
                'data' => $product,
                'message' => 'Successfully created product!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) return jsend_error('Product not found!');

            $response = [
                'success' => true,
                'data' => $product,
                'message' => 'Successful product listing!'
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) return jsend_error('Product not found!');

            $product->name    = $request->name;
            $product->description   = $request->description;
            $product->health_registration    = $request->health_registration;
            $product->date_dispatch    = $request->date_dispatch;
            $product->expiration_date     = $request->expiration_date;
            $product->medical_specimen     = $request->medical_specimen;
            $product->unity   = $request->unity;
            $product->via_administration     = $request->via_administration;
            $product->concentration = $request->concentration;
            $product->pharmaceutical_form = $request->pharmaceutical_form;
            $product->save();

            $response = [
                'success' => true,
                'data' => $product,
                'message' => 'Successfully updated product!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) return jsend_error('Product not found!');

            $product->delete();

            $response = [
                'success' => true,
                'message' => 'Product successfully removed!'
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return jsend_error('Error: ' . $e->getMessage());
        }
    }
}
