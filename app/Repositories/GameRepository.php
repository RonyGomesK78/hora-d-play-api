<?php

namespace App\Repositories;

use App\Enums\EventType;
use Illuminate\Support\Facades\DB;

use App\Interfaces\GameRepositoryInterface;

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
                        'away_score', r.away_score,
                        'started', EXISTS(
                            SELECT 1 FROM 
                            events e 
                            WHERE e.game_id = g.id AND e.event_type = '" . EventType::INITIAL_WHISTLE->value . "'
                        ),
                        'ongoing', EXISTS(
                            SELECT 1 FROM events e
                            WHERE e.game_id = g.id AND e.event_type = '" . EventType::INITIAL_WHISTLE->value . "'
                        ) AND NOT EXISTS (
                            SELECT 1 FROM events e
                            WHERE e.game_id = g.id AND e.event_type = '" . EventType::FINAL_WHISTLE->value . "'
                        ),
                        'finished', EXISTS(
                            SELECT 1 FROM events e 
                            WHERE e.game_id = g.id AND e.event_type = '" . EventType::FINAL_WHISTLE->value . "'
                        )
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

    public function get_one(string $game_id) {
        $game = collect(DB::select("
            SELECT
                c.id AS competition_id,
                c.name AS competition_name,
                g.id,
                g.date,
                g.location,
                ht.id AS home_team_id,
                ht.name AS home_team_name,
                at.id AS away_team_id,
                at.name AS away_team_name,
                r.home_score,
                r.away_score,
                EXISTS(
                    SELECT 1 FROM 
                    events e 
                    WHERE e.game_id = g.id AND e.event_type = '" . EventType::INITIAL_WHISTLE->value . "'
                ) AS started,
                EXISTS(
                    SELECT 1 FROM events e
                    WHERE e.game_id = g.id AND e.event_type = '" . EventType::INITIAL_WHISTLE->value . "'
                ) AND NOT EXISTS (
                    SELECT 1 FROM events e
                    WHERE e.game_id = g.id AND e.event_type = '" . EventType::FINAL_WHISTLE->value . "'
                ) AS ongoing,
                EXISTS(
                    SELECT 1 FROM events e 
                    WHERE e.game_id = g.id AND e.event_type = '" . EventType::FINAL_WHISTLE->value . "'
                ) AS finished
            FROM
                games g
            JOIN results r ON g.id = r.game_id
            JOIN teams ht ON r.home_team_id = ht.id
            JOIN teams at ON r.away_team_id = at.id
            JOIN season_competitions sc ON r.home_team_id = sc.team_id
            JOIN competitions c ON sc.competition_id = c.id
            WHERE
                g.id = ?;
        ", [$game_id]))->first();

        return $game;
    } 
}
