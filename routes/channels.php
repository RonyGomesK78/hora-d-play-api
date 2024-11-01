<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('games-live', function () {
    return true;
});

Broadcast::channel('game-live.{gameId}', function ($gameId) {
    return true; 
});
