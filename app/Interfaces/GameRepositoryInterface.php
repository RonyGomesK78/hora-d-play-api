<?php

namespace App\Interfaces;

interface GameRepositoryInterface
{
    public function index(string $date);
    public function get_events($game_id);
}
