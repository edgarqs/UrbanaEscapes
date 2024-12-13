<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HotelController::class, 'index'])
    ->name('hotel.selector')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('auth.login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('auth.login.post');

Route::get('/logout', [LoginController::class, 'logout'])
    ->name('auth.logout');

Route::get('/hotel/home/', [ReservasController::class, 'home'])
    ->name('hotel.home')->middleware('auth');

Route::get('/create', [HotelController::class, 'create'])
    ->name('hotel.create')->middleware('auth');

Route::post('/create', [HotelController::class, 'guardarHotel'])
    ->name('hotel.store')->middleware('auth');

Route::get('/hotel/habitacions/', [ReservasController::class, 'habitacions'])
    ->name('hotel.habitacions')->middleware('auth');

Route::fallback(function () {
    return 'Oooops!! ERROR 404';
});
