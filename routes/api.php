<?php
Use App\Order;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//create product (price, productType, color, size)
Route::post('product', 'ProductController@create');


//create order (Collection of products and quiantities)
Route::post('order', 'OrderController@create');

// list all Orders
Route::get('orders', function() {
    return Order::with('products')->get();
});

// list all Orders by productType - eager load with parameters
Route::get('ordersByType/{type}', function($type) {
    $orders = App\Order::with('products')
    ->whereHas('products', function($query) use ($type)
        {
            $query->where('productType', '=', $type);
        }, ">=", 1)
    ->get();
    return $orders;
});


