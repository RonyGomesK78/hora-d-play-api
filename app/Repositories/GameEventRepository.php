<?php

namespace App\Repositories;

use App\Models\Event;

use App\Interfaces\GameEventRepositoryInterface;

class GameEventRepository implements GameEventRepositoryInterface
{
    public function index($game_id) {
        $events = Event::with(['team', 'player'])
            ->where('game_id', $game_id)
            ->get(['event_type', 'minute', 'team_id', 'player_id']);

        return $events->map(function ($event) {
            return [
                'event_type' => $event->event_type,
                'minute' => $event->minute,
                'player_id' => $event->player ? $event->player->id : null,
                'player_name' => $event->player ? $event->player->name : null,
                'team_id' => $event->team ? $event->team->id : null,
                'team_name' => $event->team ? $event->team->name : null,
            ];
        });
    }

    public function store($event, $game_id) {
        $game_event = Event::create([
            'game_id' => $game_id,
            'team_id' => $event->team_id,
            'player_id' => $event->player_id,
            'event_type' => $event->event_type,
            'minute' => $event->minute,
        ]);

        return [
            "id" => $game_event->id
        ];
    }
}
