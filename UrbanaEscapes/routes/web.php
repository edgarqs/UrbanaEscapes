<?php

use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HotelController::class, 'index'])
    ->name('hotel.index');

Route::get('/create', [HotelController::class, 'create'])
    ->name('hotel.create');

Route::post('/create', [HotelController::class, 'guardarHotel'])
    ->name('hotel.store');
