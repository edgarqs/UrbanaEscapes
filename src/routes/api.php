<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\UsuariController;
use App\Http\Controllers\Api\ReservesController;
use App\Http\Controllers\ApiV2\FeedbackController;
use App\Http\Controllers\Api\HabitacionsController;
use App\Http\Controllers\ApiV2\HotelsCercaController;
use App\Http\Controllers\ApiV2\NoticiesApiController;
use App\Http\Controllers\ApiV2\UsuarisCercaController;
use App\Http\Controllers\ApiV2\ReservesCercaController;
use App\Http\Controllers\ApiV2\HabitacionsCercaController;

Route::prefix('v1')->group(function () {
    Route::apiResource('/usuaris', UsuariController::class);
    Route::apiResource('/reserves', ReservesController::class);
    Route::apiResource('/hotels', HotelController::class);
    Route::apiResource('/habitacions', HabitacionsController::class);
});

Route::prefix('v2')->group(function () {
    Route::apiResource('/usuaris', UsuarisCercaController::class);
    Route::apiResource('/hotels', HotelsCercaController::class);
    Route::apiResource('/habitacions', HabitacionsCercaController::class);
    Route::apiResource('/reserves', ReservesCercaController::class);

    Route::get('/hotels/{id}/tipos-habitaciones', [HotelsCercaController::class, 'getTiposHabitaciones']);
    Route::get('/habitacions/{hotelId}/disponibles', [HabitacionsCercaController::class, 'buscarHabitacionsDisponibles']);

    Route::post("/feedback/submit", [FeedbackController::class, 'enviarFeedback']);
    Route::get('/feedback/{token}', [FeedbackController::class, 'verificarToken']);
    Route::get('/feedbacks/{hotelId}', [FeedbackController::class, 'getFeedbacksByHotel']);

    Route::get('/noticies', [NoticiesApiController::class, 'index']);
    Route::get('/noticies/latest/{hotel}', [NoticiesApiController::class, 'latest']);
    Route::get('/noticies/{id_hotel}', [NoticiesApiController::class, 'show']);
});
