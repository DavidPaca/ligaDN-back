<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\PlayingScheduleController;
use App\Http\Controllers\RefereeSanctionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\VocaliaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/////////// --- 1. RUTAS PÚBLICAS (Sin token) ---
Route::post('/login', [AuthController::class, 'login']);


/////////// --- 2. RUTAS PROTEGIDAS (Requieren Token Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    /////////////////////////////////////////////////// USUARIOS ///////////////////////////////////////////////////
    // Ruta que ya venía por defecto (útil para ver mis datos)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /////////////////////////////////////////////////// LOGOUT ///////////////////////////////////////////////////
    Route::post('/logout', [AuthController::class, 'logout']);

    /////////////////////////////////////////////////// EQUIPOS ///////////////////////////////////////////////////
    Route::get('/equipo', [EquipoController::class, 'index']);
    Route::post('/equipo-create', [EquipoController::class, 'create']);
    Route::post('/equipo-update/{equipo_id}', [EquipoController::class, 'update']);
    Route::post('/equipo-delete/{equipo_id}', [EquipoController::class, 'destroy']);



    /////////////////////////////////////////////////// ROL ///////////////////////////////////////////////////
    Route::get('/rol', [RolController::class, 'index']);
    Route::post('/rol-create', [RolController::class, 'create']);
    Route::post('/rol-update/{rol_id}', [RolController::class, 'update']);
    Route::post('/rol-delete/{rol_id}', [RolController::class, 'destroy']);

    /////////////////////////////////////////////////// VOCALIA ///////////////////////////////////////////////////
    Route::get('/vocalia', [VocaliaController::class, 'index']);
    Route::post('/vocalia-create', [VocaliaController::class, 'create']);
    Route::post('/vocalia-update/{vocalia_id}', [VocaliaController::class, 'update']);
    Route::post('/vocalia-delete/{vocalia_id}', [VocaliaController::class, 'destroy']);

    /////////////////////////////////////////////////// CATEGORIAS ///////////////////////////////////////////////////
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category-create', [CategoryController::class, 'create']);
    Route::post('/category-update/{category_id}', [CategoryController::class, 'update']);
    Route::post('/category-delete/{category_id}', [CategoryController::class, 'destroy']);

    /////////////////////////////////////////////////// PLAYING SCHEDULES ///////////////////////////////////////////////////
    Route::get('/playing-schedule', [PlayingScheduleController::class, 'index']);
    Route::post('/playing-schedule-create', [PlayingScheduleController::class, 'create']);
    Route::post('/playing-schedule-update/{playing_schedule_id}', [PlayingScheduleController::class, 'update']);
    Route::post('/playing-schedule-delete/{playing_schedule_id}', [PlayingScheduleController::class, 'destroy']);

    /////////////////////////////////////////////////// REFEREE SANCTIONS ///////////////////////////////////////////////////
    Route::get('/referee-sanction', [RefereeSanctionController::class, 'index']);
    Route::post('/referee-sanction-create', [RefereeSanctionController::class, 'create']);
    Route::post('/referee-sanction-update/{referee_sanction_id}', [RefereeSanctionController::class, 'update']);
    Route::post('/referee-sanction-delete/{referee_sanction_id}', [RefereeSanctionController::class, 'destroy']);
});
