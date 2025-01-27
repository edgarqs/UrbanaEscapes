<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelsController;

Route::get('/', [HotelsController::class, 'index'])
    ->name('landing');
