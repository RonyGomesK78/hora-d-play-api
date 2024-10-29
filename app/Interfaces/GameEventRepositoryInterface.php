<?php

namespace App\Interfaces;

use App\Http\Requests\StoreGameEventRequest;

interface GameEventRepositoryInterface {
    public function index(string $game_id);
    public function store(StoreGameEventRequest $event, string $game_id);
}
