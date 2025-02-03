<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\HabitacionsController;

Route::get('/', [HotelsController::class, 'index'])
    ->name('landing');

Route::get('/habitacions', [HabitacionsController::class, 'index'])
    ->name('habitacionsDisponibles');

Route::get('/condicions', function () {
    return view('footer/condicions');
})->name('condicions');

Route::get('/privacitat', function () {
    return view('footer/privacitat');
})->name('privacitat');
