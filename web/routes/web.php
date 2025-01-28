<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\HabitacionsController;

Route::get('/', [HotelsController::class, 'index'])
    ->name('landing');

Route::get('/habitacions', [HabitacionsController::class, 'index'])
    ->name('habitacionsDisponibles');
