<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChampionshipCategoriesController;
use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\ChampionshipTeamsController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayingScheduleController;
use App\Http\Controllers\RefereeSanctionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\VocaliaController;
use App\Http\Controllers\MatchDetailsController;
use Illuminate\Http\Request;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/////////// --- 1. RUTAS PÚBLICAS (Sin token) ---
Route::post('/login', [AuthController::class, 'login']);

/////////// --- RUTAS PÚBLICAS (Añadir debajo de /login) ---
// Es recomendable que las estadísticas sean públicas para los fans de la liga
Route::get('/view-posiciones', [ViewController::class, 'posiciones']);
Route::get('/view-goleadores', [ViewController::class, 'goleadores']);
Route::get('/view-sanciones', [ViewController::class, 'sanciones']);

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

    /////////////////////////////////////////////////// *** CHAMPIONSHIPS *** ///////////////////////////////////////////////////
    Route::get('/championship', [ChampionshipController::class, 'index']);
    Route::post('/championship-create', [ChampionshipController::class, 'create']);
    Route::post('/championship-update/{championship_id}', [ChampionshipController::class, 'update']);
    Route::post('/championship-delete/{championship_id}', [ChampionshipController::class, 'destroy']);

    /////////////////////////////////////////////////// CHAMPIONSHIP CATEGORIES ///////////////////////////////////////////////////
    Route::get('/championship-category', [ChampionshipCategoriesController::class, 'index']);
    Route::post('/championship-category-create', [ChampionshipCategoriesController::class, 'create']);
    Route::post('/championship-category-update/{championship_category_id}', [ChampionshipCategoriesController::class, 'update']);
    Route::post('/championship-category-delete/{championship_category_id}', [ChampionshipCategoriesController::class, 'destroy']);

    /////////////////////////////////////////////////// CHAMPIONSHIP TEAMS ///////////////////////////////////////////////////
    Route::get('/championship-team', [ChampionshipTeamsController::class, 'index']);
    Route::post('/championship-team-create', [ChampionshipTeamsController::class, 'create']);
    Route::post('/championship-team-update/{championship_team_id}', [ChampionshipTeamsController::class, 'update']);
    Route::post('/championship-team-delete/{championship_team_id}', [ChampionshipTeamsController::class, 'destroy']);

    /////////////////////////////////////////////////// PLAYERS ///////////////////////////////////////////////////
    Route::get('/player', [PlayerController::class, 'index']);
    Route::post('/player-create', [PlayerController::class, 'create']);
    Route::post('/player-update/{player_id}', [PlayerController::class, 'update']);
    Route::post('/player-delete/{player_id}', [PlayerController::class, 'destroy']);

    /////////////////////////////////////////////////// MATCHES ///////////////////////////////////////////////////
    Route::get('/match', [MatchesController::class, 'index']);
    Route::post('/match-create', [MatchesController::class, 'create']);
    Route::post('/match-update/{match_id}', [MatchesController::class, 'update']);
    Route::post('/match-delete/{match_id}', [MatchesController::class, 'destroy']);

    /////////////////////////////////////////////////// MATCH DETAILS (Goles/Tarjetas) ///////////////////////////////////////////////////
    Route::get('/match-detail', [MatchDetailsController::class, 'index']);
    Route::post('/match-detail-create', [MatchDetailsController::class, 'create']);
    Route::post('/match-detail-update/{match_detail_id}', [MatchDetailsController::class, 'update']);
    Route::post('/match-detail-delete/{match_detail_id}', [MatchDetailsController::class, 'destroy']);
});
