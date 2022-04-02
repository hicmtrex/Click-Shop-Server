<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//protected routes


Route::group(['middleware' => ['auth:sanctum']], function () {
    //orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::get('/orders_user', [OrderController::class, 'user_orders']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders_pay/{id}', [OrderController::class, 'pay_order']);

    Route::delete('/orders_user/{id}', [OrderController::class, 'userOrder_destory']);
    Route::post('/webhook', [StripeController::class, 'webhook']);
    //admin
    Route::post('/products', [ProductController::class, 'store'])->middleware('admin');
    Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('admin');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('admin');
    Route::get('/users', [AuthController::class, 'index'])->middleware('admin');
});


//products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products_search/{name}', [ProductController::class, 'search']);
Route::get('/products_pages', [ProductController::class, 'paginate_products']);
Route::get('/products_filter/{category}', [ProductController::class, 'category']);



Route::get('/sessions/{id}', [StripeController::class, 'get_session']);

Route::get('/products_few', [ProductController::class, 'few_products']);

Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);




Route::get('/pay/{id}', [StripeController::class, 'pay']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
