<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuariController;
use App\Http\Controllers\Api\ReservesController;
use App\Http\Controllers\Api\HotelController;

Route::prefix('v1')->group(function () {
    Route::apiResource('/usuaris', UsuariController::class);
    Route::apiResource('/reserves', ReservesController::class);
    Route::apiResource('/hotels', HotelController::class);
});
