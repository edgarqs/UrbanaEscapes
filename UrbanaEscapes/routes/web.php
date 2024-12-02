<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservasController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HotelController::class, 'index'])
    ->name('hotel.selector');

Route::get('/hotel/home/', [ReservasController::class, 'home'])->name('hotel.home');

Route::get('/create', [HotelController::class, 'create'])
    ->name('hotel.create');

Route::post('/create', [HotelController::class, 'guardarHotel'])
    ->name('hotel.store');
