<?php

namespace App\Interfaces;

use App\Models\Event;

interface GameRepositoryInterface
{
    public function index(string $date);
    public function get_events($game_id);
    public function create_event($event, $game_id);
}
