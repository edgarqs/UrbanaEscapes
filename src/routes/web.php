<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HabitacionsController;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [HotelController::class, 'index'])
    ->name('hotel.selector')
    ->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/hotel/home/', [ReservasController::class, 'home'])
    ->name('hotel.home')
    ->middleware('auth');

Route::get('/create', [HotelController::class, 'create'])
    ->name('hotel.create')
    ->middleware(['auth', EnsureUserHasRole::class . ':administrador']);

Route::post('/create', [HotelController::class, 'guardarHotel'])
    ->name('hotel.store')
    ->middleware(['auth', EnsureUserHasRole::class . ':administrador']);

Route::get('/hotel/habitacions/', [ReservasController::class, 'habitacions'])
    ->name('hotel.habitacions')
    ->middleware('auth');

Route::post('/habitacions/{id}/checkin', [HabitacionsController::class, 'checkin'])
    ->name('habitacions.checkin');

Route::post('/habitacions/{id}/checkout', [HabitacionsController::class, 'checkout'])
    ->name('habitacions.checkout');
    

Route::fallback(function () {
    return 'Oooops!! ERROR 404';
});
