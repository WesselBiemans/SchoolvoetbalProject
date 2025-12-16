<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\TournamentApiController;
use App\Http\Controllers\Api\MatchesApiController;
use App\Http\Controllers\Api\PlayersApiController;
use App\Http\Controllers\Api\TeamsApiController;
use App\Http\Controllers\Api\TeamsTournamentApiController;
use App\Http\Controllers\Api\UserApiController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserApiController::class);
Route::get('/users/search/query', [UserApiController::class, 'search']);
Route::apiResource('tournaments', TournamentApiController::class);
Route::apiResource('matches', MatchesApiController::class);
Route::apiResource('players', PlayersApiController::class);
Route::apiResource('teams', TeamsApiController::class);
Route::apiResource('team-tournaments', TeamsTournamentApiController::class);
