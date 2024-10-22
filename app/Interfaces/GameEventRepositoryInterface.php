<?php

namespace App\Interfaces;

use App\Models\Event;

interface GameEventRepositoryInterface {
    public function index(string $game_id);
    public function store(Event $event, $game_id);
}
