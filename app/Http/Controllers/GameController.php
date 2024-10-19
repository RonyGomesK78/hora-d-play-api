<?php

namespace App\Http\Controllers;

use App\Interfaces\GameRepositoryInterface;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private GameRepositoryInterface $game_repository_interface;

    public function __construct(GameRepositoryInterface $game_repository_interface) {
        $this->game_repository_interface = $game_repository_interface;
    }

    public function index(Request $request) {
        $date = $request->query('date', now()->toDateString());

        $games = $this->game_repository_interface->index($date);
        // Format the response
        $formattedGames = array_map(function ($competition) {
            $competition->games = json_decode($competition->games); // Decode JSON string to array
            return $competition;
        }, $games);

        return response()->json($formattedGames);
    }

    public function show_events($game_id) {
        $events = $this->game_repository_interface->get_events($game_id);

        return response()->json($events);
    }
}
