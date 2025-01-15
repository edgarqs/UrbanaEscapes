<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitacionsController;
use App\Http\Middleware\CheckHotelAccess;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [HotelController::class, 'index'])
    ->name('hotel.selector')
    ->middleware(['auth', EnsureUserHasRole::class . ':administrador']);

//? Página y post de login y logout
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');

//? Página de inicio del hotel
Route::get('/hotel/home/', [ReservasController::class, 'home'])
    ->name('hotel.home')
    ->middleware('auth', CheckHotelAccess::class);

//? Página de creación de hotel
Route::get('/create', [HotelController::class, 'create'])
    ->name('hotel.create')
    ->middleware(['auth', EnsureUserHasRole::class . ':administrador']);

Route::post('/create', [HotelController::class, 'guardarHotel'])
    ->name('hotel.store')
    ->middleware(['auth', EnsureUserHasRole::class . ':administrador']);

//? Página de habitacions y botones
Route::get('/hotel/habitacions/', [ReservasController::class, 'habitacions'])
    ->name('hotel.habitacions')
    ->middleware('auth', CheckHotelAccess::class);

Route::post('/habitacions/{id}/checkin', [ReservasController::class, 'checkin'])
    ->name('habitacions.checkin')
    ->middleware('auth');

Route::post('/habitacions/{id}/checkout', [ReservasController::class, 'checkout'])
    ->name('habitacions.checkout')
    ->middleware('auth');

Route::post('/habitacions/{id}/bloquejar', [ReservasController::class, 'bloquejar'])
    ->name('habitacions.bloquejar')
    ->middleware('auth');

Route::post('/habitacions/{id}/desbloquejar', [ReservasController::class, 'desbloquejar'])
    ->name('habitacions.desbloquejar')
    ->middleware('auth');

//? Página de recepcio
Route::get('/recepcio', [HabitacionsController::class, 'showRecepcio'])
    ->name('recepcio')
    ->middleware('auth', CheckHotelAccess::class);

//? Página de checkins
Route::get('/hotel/checkins/', [ReservasController::class, 'checkinsPendents'])
    ->name('reservas.checkins')
    ->middleware('auth');

//? Para la view de habitacions.blade.php
Route::get('/habitacions/{id}/detalls', [HabitacionsController::class, 'detalls'])
    ->name('habitacions.detalls');

Route::get('/refresh-calendar', [HabitacionsController::class, 'refreshCalendar'])
    ->name('refresh.calendar')
    ->middleware('auth', CheckHotelAccess::class);

//! Form de reserves

Route::get('/reserves/afegir', [ReservasController::class, 'crearReserva'])
    ->name('recepcio.afegirReserva')
    ->middleware('auth');

Route::post('/reserves/afegir', [ReservasController::class, 'guardarReserva'])
    ->name('recepcio.guardarReserva')
    ->middleware('auth');

Route::get('/reserves/{habitacionId}', [ReservasController::class, 'index'])
    ->name('reserves.index')
    ->middleware('auth');

Route::post('/reserves/{habitacionId}', [ReservasController::class, 'store'])
    ->name('reserves.store')
    ->middleware('auth');



Route::fallback(function () {
    return 'Oooops!! ERROR 404';
});
