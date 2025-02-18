<?php

use App\Http\Controllers\Api\HabitacionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuariController;
use App\Http\Controllers\Api\ReservesController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\ApiV2\HotelsCercaController;

Route::prefix('v1')->group(function () {
    Route::apiResource('/usuaris', UsuariController::class);
    Route::apiResource('/reserves', ReservesController::class);
    Route::apiResource('/hotels', HotelController::class);
    Route::apiResource('/habitacions', HabitacionsController::class);
});

Route::prefix('v2')->group(function () {
    Route::apiResource('/hotels', HotelsCercaController::class);
});
