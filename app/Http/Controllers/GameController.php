<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', now()->toDateString());

        // Execute the query using Laravel's query builder
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

        // Format the response
        $formattedGames = array_map(function ($competition) {
            $competition->games = json_decode($competition->games); // Decode JSON string to array
            return $competition;
        }, $games);

        return response()->json($formattedGames);
    }

    public function show_events($game_id) {
        $events = DB::select("
            SELECT
                e.event_type,
                e.minute,
                p.id as player_id,
                p.name as player_name,
                t.id as team_id,
                t.name as team_name
            FROM
                events e
            JOIN
                games g ON
                e.game_id = g.id
            LEFT JOIN
                teams t ON
                e.team_id = t.id
            LEFT JOIN
                players p ON
                e.player_id  = p.id
            WHERE
                g.id = ?;
        ", [$game_id]);

        return response()->json($events);
    }
}
