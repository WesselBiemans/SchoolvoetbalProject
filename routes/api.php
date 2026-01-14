<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\TournamentApiController;
use App\Http\Controllers\Api\MatchesApiController;
use App\Http\Controllers\Api\PlayersApiController;
use App\Http\Controllers\Api\TeamsApiController;
use App\Http\Controllers\Api\TeamsTournamentApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BetApiController;

// Authentication routes (public)
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Betting routes
    Route::post('/bets', [BetApiController::class, 'placeBet']);
    Route::get('/bets', [BetApiController::class, 'getUserBets']);
    Route::get('/bets/match/{matchId}', [BetApiController::class, 'getMatchBets']);
    Route::get('/matches/available-for-betting', [BetApiController::class, 'getAvailableMatches']);
    Route::post('/bets/settle/{matchId}', [BetApiController::class, 'settleBets']);
    Route::post('/bets/settle-all', [BetApiController::class, 'settleAllBets']);
});

Route::apiResource('users', UserApiController::class);
Route::get('/users/search/query', [UserApiController::class, 'search']);

Route::get('/tournaments/upcoming/list', [TournamentApiController::class, 'upcoming']);
Route::apiResource('tournaments', TournamentApiController::class);

Route::get('/matches/upcoming/list', [MatchesApiController::class, 'upcoming']);
Route::apiResource('matches', MatchesApiController::class);
Route::apiResource('players', PlayersApiController::class);
// Route::apiResource('teams', TeamsApiController::class); ff gedisabled zodat de normale Teams route gwn werkt wtf??
Route::apiResource('team-tournaments', TeamsTournamentApiController::class);
