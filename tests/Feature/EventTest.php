<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\Game;
use App\Models\Season;
use App\Models\Team;

use App\Traits\DatabaseSeederTrait;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase, DatabaseSeederTrait;

    protected function setUp(): void {
        parent::setUp();

        // Seed the database
        $this->seed_competitions_and_teams();
    }

    #[Test]
    public function it_should_successful_create_a_game_event_without_player_id_and_team_id(): void {
        $league_id = Competition::where('name', 'Serie A')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $napoli = Team::where('name', 'Napoli')->first();
        $roma = Team::where('name', 'AS Roma')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Stadio Olimpico di Roma',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        $this->seed_players_to_game($napoli->players, $game);
        $this->seed_players_to_game($roma->players, $game);

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'initial_whistle',
                'minute' => 0,
                'team_id' => null,
                'player_id' => null
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['id']);
    }

    #[Test]
    public function it_should_successful_create_a_game_event_with_player_id_and_team_id(): void {
        $league_id = Competition::where('name', 'Serie A')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $napoli = Team::where('name', 'Napoli')->first();
        $roma = Team::where('name', 'AS Roma')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Stadio Olimpico di Roma',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        $this->seed_players_to_game($napoli->players, $game);
        $this->seed_players_to_game($roma->players, $game);

        $dybala = $game->players->firstWhere('name', 'Paulo Dybala');

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'goal',
                'minute' => 10,
                'team_id' => $roma->id,
                'player_id' => $dybala->id
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['id']);
    }

    #[Test]
    public function it_should_return_status_code_404_when_the_game_id_not_exists(): void {
        $invalid_game_id = $uuid = Str::uuid()->toString();

        $expected_response = [
            "message" => "Game's id not found"
        ];

        $response = $this->postJson(
            "/api/games/$invalid_game_id/events",
            [
                'event_type' => 'initial_whistle',
                'minute' => 0,
                'team_id' => null,
                'player_id' => null
            ]
        );

        $response
            ->assertStatus(404)
            ->assertExactJson($expected_response);
    }

    #[Test]
    public function it_should_return_status_code_422_when_the_event_type_is_null(): void {
        $league_id = Competition::where('name', 'Serie A')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $napoli = Team::where('name', 'Napoli')->first();
        $roma = Team::where('name', 'AS Roma')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Stadio Olimpico di Roma',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        $this->seed_players_to_game($napoli->players, $game);
        $this->seed_players_to_game($roma->players, $game);

        $dybala = $game->players->firstWhere('name', 'Paulo Dybala');

        $expected_response = [
            "message" => "The event type field is required."
        ];

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => null,
                'minute' => 10,
                'team_id' => $roma->id,
                'player_id' => $dybala->id
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson($expected_response);
    }

    #[Test]
    public function it_should_return_status_code_422_when_the_team_id_is_present_but_the_player_id_not(): void {
        $league_id = Competition::where('name', 'Serie A')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $napoli = Team::where('name', 'Napoli')->first();
        $roma = Team::where('name', 'AS Roma')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Stadio Olimpico di Roma',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        $this->seed_players_to_game($napoli->players, $game);
        $this->seed_players_to_game($roma->players, $game);

        $expected_response = [
            "message" => "The team_id must be null when player_id is null."
        ];

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'red card',
                'minute' => 10,
                'team_id' => $roma->id,
                'player_id' => null
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson($expected_response);
    }

    #[Test]
    public function it_should_return_status_code_422_when_the_player_id_is_present_but_the_team_id_not(): void {
        $league_id = Competition::where('name', 'Serie A')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $napoli = Team::where('name', 'Napoli')->first();
        $roma = Team::where('name', 'AS Roma')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Stadio Olimpico di Roma',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        $this->seed_players_to_game($napoli->players, $game);
        $this->seed_players_to_game($roma->players, $game);

        $dybala = $game->players->firstWhere('name', 'Paulo Dybala');

        $expected_response = [
            "message" => "The player_id must be null when team_id is null."
        ];

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'assist',
                'minute' => 10,
                'team_id' => null,
                'player_id' => $dybala->id
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson($expected_response);
    }

    #[Test]
    public function it_should_return_status_code_422_when_the_player_not_belongs_to_the_team(): void {
        $league_id = Competition::where('name', 'Serie A')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $napoli = Team::where('name', 'Napoli')->first();
        $roma = Team::where('name', 'AS Roma')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Stadio Olimpico di Roma',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        $this->seed_players_to_game($napoli->players, $game);
        $this->seed_players_to_game($roma->players, $game);

        $dybala = $game->players->firstWhere('name', 'Paulo Dybala');

        $expected_response = [
            "message" => "The selected player does not belong to the specified team."
        ];

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'yellow card',
                'minute' => 10,
                'team_id' => $napoli->id,
                'player_id' => $dybala->id
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson($expected_response);

    }
}
