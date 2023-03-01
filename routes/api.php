<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
//use App\Models\Customer;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::post('/auth/logout',[AuthController::class, 'logout']);
    Route::get('/auth/user',[AuthController::class, 'user']);

    Route::apiResource('/product', ProductController::class)->except((['index', 'show']));
    Route::apiResource('/category', CategoryController::class)->except((['index', 'show']));
    Route::apiResource('/customer', CustomerContoller::class)->except((['index', 'show']));
    Route::apiResource('/order', OrderController::class)->except((['index', 'show']));
});

Route::apiResource('/product', ProductController::class);

Route::apiResource('/category', CategoryController::class);

Route::apiResource('customer', CustomerController::class);

Route::apiResource('order', OrderController::class);
