<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameRepository implements GameRepositoryInterface
{
   
    public function index(string $date) {
        
        $games = DB::select("
            SELECT
                c.id,
                c.name AS competition_name,
                JSON_AGG(
                    JSON_BUILD_OBJECT(
                        'id', g.id,
                        'date', g.date,
                        'location', g.location,
                        'home_team_id', ht.id,
                        'home_team_name', ht.name,
                        'away_team_id', at.id,
                        'away_team_name', at.name,
                        'home_score', r.home_score,
                        'away_score', r.away_score
                    )
                    ORDER BY g.date
                ) AS games
            FROM
                games g
            JOIN results r ON g.id = r.game_id
            JOIN teams ht ON r.home_team_id = ht.id
            JOIN teams at ON r.away_team_id = at.id
            JOIN season_competitions sc ON r.home_team_id = sc.team_id
            JOIN competitions c ON sc.competition_id = c.id
            WHERE
                g.date::date = ?
            GROUP BY
                c.id, c.name
            ORDER BY
                c.name;
        ", [$date]);

        return $games;
    }

    public function get_events($game_id) {
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
}
