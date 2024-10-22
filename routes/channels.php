<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('game-live', function () {
    return true;
});
