<?php

use App\Http\Controllers\v1\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/orders', [OrderController::class, 'list']);
    Route::get('/calculate-discount/order/{id}', [OrderController::class, 'calculateDiscount']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::delete('/order/{id}', [OrderController::class, 'delete']);
});
