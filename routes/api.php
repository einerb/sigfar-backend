<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');
    Route::post('signup', 'UserController@store');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
    Route::apiResource('products', 'ProductController');
    Route::put('products/destroy/{id}', 'ProductController@destroy');
    Route::get('products/byInventory', 'ProductController@indexByInventory');
    Route::apiResource('permissions', 'PermissionController');
    Route::put('permissions/acceptDeny/{id}', 'PermissionController@acceptDeny');
    Route::get('permissions/byUser/{id}', 'PermissionController@indexByUser');
    Route::apiResource('schedules', 'ScheduleController');
    Route::get('schedules/byUser/{id}', 'ScheduleController@indexByUser');
    Route::apiResource('inventories', 'InventoryController');
    Route::put('inventories/destroy/{id}', 'InventoryController@destroy');
    Route::apiResource('users', 'UserController');
    Route::get('users/byuser/{id}', "UserController@indexByRole");
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('orders', 'OrderController');
    Route::get('orders/byUser/{id}', 'OrderController@indexByUser');
    Route::apiResource('detailsOrder', 'DetailsOrderController');
    Route::get('detailsOrder/exist/{id}', 'DetailsOrderController@indexOrder');
    /* Route::apiResource('suppliers', 'SupplierController');
        Route::apiResource('product-supliers', 'ProductSupplierController'); */
});
