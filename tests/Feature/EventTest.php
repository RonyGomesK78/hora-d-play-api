<?php

namespace Tests\Feature;

use App\Enums\EventType;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Result;
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
        $league_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        Result::create([
            'game_id' => $game->id,
            'home_team_id' => $derby->id,
            'away_team_id' => $mindelense->id,
        ]);

        $this->seed_players_to_game($mindelense->players, $game);
        $this->seed_players_to_game($derby->players, $game);

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => EventType::INITIAL_WHISTLE->value,
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
        $league_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();

        $today_date = Carbon::today()->setTime(18, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        Result::create([
            'game_id' => $game->id,
            'home_team_id' => $derby->id,
            'away_team_id' => $mindelense->id,
        ]);

        $this->seed_players_to_game($mindelense->players, $game);
        $this->seed_players_to_game($derby->players, $game);

        $nuno_rocha = $game->players->firstWhere('name', 'Nuno Rocha');

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'goal',
                'minute' => 10,
                'team_id' => $derby->id,
                'player_id' => $nuno_rocha->id
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
                'event_type' => EventType::INITIAL_WHISTLE->value,
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
        $league_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        Result::create([
            'game_id' => $game->id,
            'home_team_id' => $derby->id,
            'away_team_id' => $mindelense->id,
        ]);

        $this->seed_players_to_game($mindelense->players, $game);
        $this->seed_players_to_game($derby->players, $game);

        $nuno_rocha = $game->players->firstWhere('name', 'Nuno Rocha');

        $expected_response = [
            "message" => "The event type field is required."
        ];

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => null,
                'minute' => 10,
                'team_id' => $derby->id,
                'player_id' => $nuno_rocha->id
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson($expected_response);
    }

    #[Test]
    public function it_should_return_status_code_422_when_the_team_id_is_present_but_the_player_id_not(): void {
        $league_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        Result::create([
            'game_id' => $game->id,
            'home_team_id' => $derby->id,
            'away_team_id' => $mindelense->id,
        ]);

        $this->seed_players_to_game($mindelense->players, $game);
        $this->seed_players_to_game($derby->players, $game);

        $expected_response = [
            "message" => "The team_id must be null when player_id is null."
        ];

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'red card',
                'minute' => 10,
                'team_id' => $derby->id,
                'player_id' => null
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson($expected_response);
    }

    #[Test]
    public function it_should_return_status_code_422_when_the_player_id_is_present_but_the_team_id_not(): void {
        $league_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        Result::create([
            'game_id' => $game->id,
            'home_team_id' => $derby->id,
            'away_team_id' => $mindelense->id,
        ]);

        $this->seed_players_to_game($mindelense->players, $game);
        $this->seed_players_to_game($derby->players, $game);

        $nuno_rocha = $game->players->firstWhere('name', 'Nuno Rocha');

        $expected_response = [
            "message" => "The player_id must be null when team_id is null."
        ];

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'assist',
                'minute' => 10,
                'team_id' => null,
                'player_id' => $nuno_rocha->id
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson($expected_response);
    }

    #[Test]
    public function it_should_return_status_code_422_when_the_player_not_belongs_to_the_team(): void {
        $league_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $season_id = Season::where('year', '24/25')->first()->id;

        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);

        $game = Game::create([
            'date' => $today_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $league_id,
        ]);

        Result::create([
            'game_id' => $game->id,
            'home_team_id' => $derby->id,
            'away_team_id' => $mindelense->id,
        ]);

        $this->seed_players_to_game($mindelense->players, $game);
        $this->seed_players_to_game($derby->players, $game);

        $nuno_rocha = $game->players->firstWhere('name', 'Nuno Rocha');

        $expected_response = [
            "message" => "The selected player does not belong to the specified team."
        ];

        $response = $this->postJson(
            "/api/games/$game->id/events",
            [
                'event_type' => 'yellow card',
                'minute' => 10,
                'team_id' => $mindelense->id,
                'player_id' => $nuno_rocha->id
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson($expected_response);

    }
}
