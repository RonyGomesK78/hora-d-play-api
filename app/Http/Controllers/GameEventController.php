<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Events\GameUpdated;
use App\Http\Requests\StoreGameEventRequest;
use App\Interfaces\GameEventRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameEventController extends Controller {
    private GameEventRepositoryInterface $game_event_repository_interface;

    public function __construct(GameEventRepositoryInterface $game_event_repository_interface) {
        $this->game_event_repository_interface = $game_event_repository_interface;
    }

    public function index($game_id): JsonResponse {
        $events = $this->game_event_repository_interface->index($game_id);

        return response()->json($events);
    }

    public function store(StoreGameEventRequest $request, $game_id): JsonResponse {
        $validator = Validator::make(['game_id' => $game_id], [
            'game_id' => 'required|uuid|exists:games,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => "Game's id not found"], 404);
        }

        $event = (object) $request->validated();

        $game_event = $this->game_event_repository_interface->store($event, $game_id);

        try {
            event(new GameUpdated($game_event));
        } catch (\Exception $e) {
            // Log the error without interrupting the main response
            Log::error("Broadcasting event failed: " . $e->getMessage());
            
            Log::error("Failed event data", ['game_event' => $game_event, 'game_id' => $game_id]);
        }

        return response()->json($game_event, 201);
    }
}
