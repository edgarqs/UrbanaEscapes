<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Middleware\CheckHotelAccess;
use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Controllers\NoticiesController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\HabitacionsController;

// auth y EnsureUserHasRole:administrador
Route::middleware(['auth', EnsureUserHasRole::class . ':administrador'])->group(function () {
    Route::get('/', [HotelController::class, 'index'])->name('hotel.selector');
    Route::get('/create', [HotelController::class, 'create'])->name('hotel.create');
    Route::post('/create', [HotelController::class, 'guardarHotel'])->name('hotel.store');
    Route::get('/noticies', [NoticiesController::class, 'index'])->name('hotel.noticies');
    Route::get('/noticies/{id}/edit', [NoticiesController::class, 'edit'])->name('hotel.editarNoticia');
    Route::delete('/noticies/{id}', [NoticiesController::class, 'destroy'])->name('hotel.eliminarNoticia');
    Route::get('/noticies/afegir', [NoticiesController::class, 'create'])->name('hotel.afegirNoticia');
    Route::post('/noticies', [NoticiesController::class, 'store'])->name('noticies.store');
    Route::patch('/noticies/{id}/publicar', [NoticiesController::class, 'publicar'])->name('hotel.publicarNoticia');
    Route::put('/noticies/{id}', [NoticiesController::class, 'update'])->name('noticies.update');
});

// auth
Route::middleware('auth')->group(function () {
    Route::get('/hotel/home/', [ReservasController::class, 'home'])->name('hotel.home')->middleware(CheckHotelAccess::class);
    Route::get('/hotel/habitacions/', [ReservasController::class, 'habitacions'])->name('hotel.habitacions')->middleware(CheckHotelAccess::class);
    Route::post('/habitacions/{id}/checkin', [ReservasController::class, 'checkin'])->name('habitacions.checkin');
    Route::post('/habitacions/{id}/checkout', [ReservasController::class, 'checkout'])->name('habitacions.checkout');
    Route::post('/habitacions/{id}/bloquejar', [ReservasController::class, 'bloquejar'])->name('habitacions.bloquejar');
    Route::post('/habitacions/{id}/desbloquejar', [ReservasController::class, 'desbloquejar'])->name('habitacions.desbloquejar');
    Route::get('/recepcio', [HabitacionsController::class, 'showRecepcio'])->name('recepcio')->middleware(CheckHotelAccess::class);
    Route::get('/hotel/checkins/', [ReservasController::class, 'checkinsPendents'])->name('reservas.checkins')->middleware(CheckHotelAccess::class);
    Route::get('/refresh-calendar', [HabitacionsController::class, 'refreshCalendar'])->name('refresh.calendar')->middleware(CheckHotelAccess::class);
    Route::get('/reserves/afegir', [ReservasController::class, 'crearReserva'])->name('recepcio.afegirReserva');
    Route::post('/reserves/afegir', [ReservasController::class, 'guardarReserva'])->name('recepcio.guardarReserva');
    Route::get('/reserves/{habitacionId}', [ReservasController::class, 'index'])->name('reserves.index');
    Route::post('/reserves/{habitacionId}', [ReservasController::class, 'store'])->name('reserves.store');
    Route::get('/habitacions/{id}/detalls', [HabitacionsController::class, 'detalls'])->name('habitacions.detalls');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta de fallback
Route::fallback(function () {
    return 'Oooops!! ERROR 404';
});
