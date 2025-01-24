<?php

use App\Http\Controllers\v1\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::delete('/order/{id}', [OrderController::class, 'delete']);
});
