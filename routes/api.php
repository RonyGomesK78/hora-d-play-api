<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GameEventController;

use Illuminate\Support\Facades\Route;

Route::get('/games', [GameController::class, 'index']);
Route::get('/games/{game_id}', [GameController::class, 'get_one']);

Route::get('/games/{game_id}/events', [GameEventController::class, 'index']);
// this route will be private
Route::post('/games/{game_id}/events', [GameEventController::class, 'store']);
