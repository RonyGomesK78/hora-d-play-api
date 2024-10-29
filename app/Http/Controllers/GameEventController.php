<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Events\GameUpdated;
use App\Http\Requests\StoreGameEventRequest;
use App\Interfaces\GameEventRepositoryInterface;
use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameEventController extends Controller {
    private GameEventRepositoryInterface $game_event_repository_interface;

    public function __construct(GameEventRepositoryInterface $game_event_repository_interface) {
        $this->game_event_repository_interface = $game_event_repository_interface;
    }

    public function index(string $game_id): JsonResponse {
        $events = $this->game_event_repository_interface->index($game_id);

        return response()->json($events);
    }

    public function store(StoreGameEventRequest $request, string $game_id): JsonResponse {
        $validator = Validator::make(['game_id' => $game_id], [
            'game_id' => 'required|uuid|exists:games,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => "Game's id not found"], 404);
        }

        $event = (object) $request->validated();

        DB::beginTransaction();

        try {
            $game_event = $this->game_event_repository_interface->store($event, $game_id);

            // If the event is a goal, update the result's score
            if ($event->event_type === EventType::GOAL->value) {
                $this->update_result_score($event, $game_id);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Error storing game event: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }

        try {
            event(new GameUpdated($game_event));
        } catch (\Exception $e) {
            // Log the error without interrupting the main response
            Log::error("Broadcasting event failed: " . $e->getMessage());

            Log::error("Failed event data", ['game_event' => $game_event, 'game_id' => $game_id]);
        }

        return response()->json($game_event, 201);
    }

    private function update_result_score($event, string $game_id): void {
        $result = Result::where('game_id', $game_id)->first();

        if ($event->team_id === $result->home_team_id) {
            $result->home_score += 1;
        } elseif ($event->team_id === $result->away_team_id) {
            $result->away_score += 1;
        }

        $result->save();
    }
}
