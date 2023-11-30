<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('user')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh-token', [AuthController::class, 'refresh']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('product')->group(function () {
        Route::post('create', [ProductController::class, 'create']);
        Route::put('update/{product_id}', [ProductController::class, 'update'])
            ->where('product_id', '[0-9]+');
        Route::delete('delete/{product_id}', [ProductController::class, 'delete'])
            ->where('product_id', '[0-9]+');
        Route::get('list', [ProductController::class, 'getList']);
    });

    Route::prefix('user-products')->group(function () {
        Route::post('create', [UserProductController::class, 'create']);
        Route::delete('delete/{user_product_id}', [UserProductController::class, 'delete'])
            ->where('user_product_id', '[0-9]+');
        Route::get('list', [UserProductController::class, 'getList']);
    });
});
