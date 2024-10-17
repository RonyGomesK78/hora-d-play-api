<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/games', [GameController::class, 'index']);

Route::get('/games/{game_id}/events', [GameController::class, 'show_events']);
