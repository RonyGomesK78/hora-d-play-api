<?php

namespace Tests\Feature;

use App\Enums\EventType;
use App\Models\Competition;
use App\Models\Game;
use App\Models\Player;
use App\Models\Result;
use App\Models\Team;

use App\Traits\DatabaseSeederTrait;

use PHPUnit\Framework\Attributes\Test;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase {
    use RefreshDatabase, DatabaseSeederTrait;

    protected function setUp(): void {
        parent::setUp();

        // Seed the database
        $this->seed_competitons_teams_and_results();
        $competitions = Competition::all();
    }

    #[Test]
    public function it_should_get_a_game_by_id(): void {
        $game_id = Game::where('location', 'Adérito Sena')
            ->where('date', Carbon::today()->setTime(16, 0, 0))
            ->first()->id;

        $competition_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        
        $mindelense_id = Team::where('name', 'Mindelense')->first()->id;
        $derby_id = Team::where('name', 'Derby')->first()->id;

        $expected_response = [
            "competition_id" => $competition_id,
            "competition_name" => "Campeonato de São Vicente - 1ª Divisão",
            "id" => $game_id,
            "date" => Carbon::today()->setTime(16, 0, 0)->format('Y-m-d H:i:s'),
            "location" => "Adérito Sena",
            "home_team_id" => $mindelense_id,
            "home_team_name" => "Mindelense",
            "away_team_id" => $derby_id,
            "away_team_name" => "Derby",
            "home_score" => 1,
            "away_score" => 4,
            "started" => true,
            "ongoing" => false,
            "finished" => true,
        ];

        $response = $this->get("/api/games/$game_id");
        
        $response
            ->assertStatus(200)
            ->assertExactJson($expected_response);
    }

    #[Test]
    public function it_should_return_404_when_the_id_does_not_exists(): void {
        $invalid_game_id = 'f604d182-d89b-479f-be3c-3e9e2596617c';
    
        $expected_response = [
            "message" => "Game's id not found"
        ];

        $response = $this->get("/api/games/$invalid_game_id");
        
        $response
            ->assertStatus(404)
            ->assertExactJson($expected_response);
    }

    #[Test]
    public function it_should_get_all_today_games_grouped_by_competitions(): void {
        $pl_competition_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $sl_competition_id = Competition::where('name', 'Campeonato de São Vicente - 2ª Divisão')->first()->id;

        $today_sl_game_1_id = Game::where('location', 'Adérito Sena')
            ->where('date', Carbon::today()->setTime(10, 0, 0))
            ->first()->id;
        $today_sl_game_2_id = Game::where('location', 'Adérito Sena')
            ->where('date', Carbon::today()->setTime(12, 0, 0))
            ->first()->id;
        $today_pl_game_1_id = Game::where('location', 'Adérito Sena')
            ->where('date', Carbon::today()->setTime(16, 0, 0))
            ->first()->id;

        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();
        $uni_mindelo = Team::where('name', 'Uni Mindelo')->first();
        $estoril = Team::where('name', 'Estoril')->first();
        $calhau = Team::where('name', 'Calhau')->first();
        $ponta = Team::where('name', "Ponta d'Pom")->first();

        $expected_response = [
            [
                'id' => $pl_competition_id,
                'competition_name' => 'Campeonato de São Vicente - 1ª Divisão',
                'games' => [
                    [
                        'id' => $today_pl_game_1_id,
                        'date' => Carbon::today()->setTime(16, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Adérito Sena',
                        'home_team_id' => $mindelense->id,
                        'home_team_name' => 'Mindelense',
                        'away_team_id' => $derby->id,
                        'away_team_name' => 'Derby',
                        'home_score' => 1,
                        'away_score' => 4,
                        'started' => true,
                        'ongoing' => false,
                        'finished' => true,
                    ]
                ]
            ],
            [
                'id' => $sl_competition_id,
                'competition_name' => 'Campeonato de São Vicente - 2ª Divisão',
                'games' => [
                    [
                        'id' => $today_sl_game_1_id,
                        'date' => Carbon::today()->setTime(10, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Adérito Sena',
                        'home_team_id' => $estoril->id,
                        'home_team_name' => 'Estoril',
                        'away_team_id' => $uni_mindelo->id,
                        'away_team_name' => 'Uni Mindelo',
                        'home_score' => 2,
                        'away_score' => 5,
                        'started' => true,
                        'ongoing' => false,
                        'finished' => true,
                    ],
                    [
                        'id' => $today_sl_game_2_id,
                        'date' => Carbon::today()->setTime(12, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Adérito Sena',
                        'home_team_id' => $calhau->id,
                        'home_team_name' => 'Calhau',
                        'away_team_id' => $ponta->id,
                        'away_team_name' => "Ponta d'Pom",
                        'home_score' => 4,
                        'away_score' => 4,
                        'started' => true,
                        'ongoing' => false,
                        'finished' => true,
                    ]
                ]
            ],
        ];

        $response = $this->get('/api/games');

        // Convert the response JSON to an array for inspection
        $response_data = $response->json();
        // Check the number of competitions
        $this->assertCount(2, $response_data, 'The number of competitions should be 2.');
        // Check the number of games for each competition
        $this->assertCount(1, $response_data[0]['games'], 'The number of games for Campeonato de São Vicente - 1ª Divisão should be 1.');
        $this->assertCount(2, $response_data[1]['games'], 'The number of games for Campeonato de São Vicente - 2ª Divisão should be 2.');
        // Assert that the response matches exactly with the expected JSON
        $response
            ->assertStatus(200)
            ->assertExactJson($expected_response);
    }
    
    #[Test]
    public function it_should_get_all_yesterday_games_grouped_by_competitions(): void {
        $pl_competition_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $sl_competition_id = Competition::where('name', 'Campeonato de São Vicente - 2ª Divisão')->first()->id;

        $yesterday_sl_game_1_id = Game::where('location', 'Adérito Sena')
            ->where('date', Carbon::yesterday()->setTime(12, 0, 0))
            ->first()->id;
        $yesterday_pl_game_1_id = Game::where('location', 'Adérito Sena')
            ->where('date', Carbon::yesterday()->setTime(16, 0, 0))
            ->first()->id;

        $amarante = Team::where('name', 'Amarante')->first();
        $derby = Team::where('name', 'Derby')->first();
        $uni_mindelo = Team::where('name', 'Uni Mindelo')->first();
        $ponta = Team::where('name', "Ponta d'Pom")->first();

        $expected_response = [
            [
                'id' => $pl_competition_id,
                'competition_name' => 'Campeonato de São Vicente - 1ª Divisão',
                'games' => [
                    [
                        'id' => $yesterday_pl_game_1_id,
                        'date' => Carbon::yesterday()->setTime(16, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Adérito Sena',
                        'home_team_id' => $derby->id,
                        'home_team_name' => 'Derby',
                        'away_team_id' => $amarante->id,
                        'away_team_name' => 'Amarante',
                        'home_score' => 2,
                        'away_score' => 2,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ]
                ]
            ],
            [
                'id' => $sl_competition_id,
                'competition_name' => 'Campeonato de São Vicente - 2ª Divisão',
                'games' => [
                    [
                        'id' => $yesterday_sl_game_1_id,
                        'date' => Carbon::yesterday()->setTime(12, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Adérito Sena',
                        'home_team_id' => $ponta->id,
                        'home_team_name' => "Ponta d'Pom",
                        'away_team_id' => $uni_mindelo->id,
                        'away_team_name' => 'Uni Mindelo',
                        'home_score' => 0,
                        'away_score' => 2,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ],
                ]
            ],
        ];

        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $response = $this->get("/api/games?date=$yesterday");

        $response
            ->assertStatus(200)
            ->assertExactJson($expected_response);
    }
  
    #[Test]
    public function it_should_get_all_tomorrow_games_grouped_by_competitions(): void {
        $pl_competition_id = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $sl_competition_id = Competition::where('name', 'Campeonato de São Vicente - 2ª Divisão')->first()->id;

        $amarante = Team::where('name', 'Amarante')->first();
        $mindelense = Team::where('name', 'Mindelense')->first();
        $estoril = Team::where('name', 'Estoril')->first();
        $calhau = Team::where('name', 'Calhau')->first();

        $tomorrow_sl_game_1_id = Game::where('location', 'Adérito Sena')
            ->where('date', Carbon::tomorrow()->setTime(10, 0, 0))
            ->first()->id;

        $tomorrow_pl_game_1_id = Game::where('location', 'Adérito Sena')
            ->where('date', Carbon::tomorrow()->setTime(14, 0, 0))
            ->first()->id;

        $expected_response = [
            [
                'id' => $pl_competition_id,
                'competition_name' => 'Campeonato de São Vicente - 1ª Divisão',
                'games' => [
                    [
                        'id' => $tomorrow_pl_game_1_id,
                        'date' => Carbon::tomorrow()->setTime(14, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Adérito Sena',
                        'home_team_id' => $amarante->id,
                        'home_team_name' => 'Amarante',
                        'away_team_id' => $mindelense->id,
                        'away_team_name' => 'Mindelense',
                        'home_score' => null,
                        'away_score' => null,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ]
                ]
            ],
            [
                'id' => $sl_competition_id,
                'competition_name' => 'Campeonato de São Vicente - 2ª Divisão',
                'games' => [
                    [
                        'id' => $tomorrow_sl_game_1_id,
                        'date' => Carbon::tomorrow()->setTime(10, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Adérito Sena',
                        'home_team_id' => $estoril->id,
                        'home_team_name' => 'Estoril',
                        'away_team_id' => $calhau->id,
                        'away_team_name' => 'Calhau',
                        'home_score' => null,
                        'away_score' => null,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ],
                ]
            ],
        ];

        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        $response = $this->get("/api/games?date=$tomorrow");

        $response
            ->assertStatus(200)
            ->assertExactJson($expected_response);
    }

    #[Test]
    public function it_should_get_all_the_events_from_a_match_grouped_by_teams(): void {
        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();

        $game_id = Result::where('home_team_id', $mindelense->id)
            ->where('away_team_id', $derby->id)
            ->first()->game_id;

        $guga_id = Player::where('name', 'Guga Sousa')->first()->id;
        $n_rocha_id = Player::where('name', 'Nuno Rocha')->first()->id;
        $airton_lopes_id = Player::where('name', 'Airton Lopes')->first()->id;
        $flav_martins_id = Player::where('name', 'Flavio Martins')->first()->id;
        $day_gomes_id = Player::where('name', 'Day Gomes')->first()->id;
        $kevin_lima_id = Player::where('name', 'Kevin Lima')->first()->id; 
        $kenny_brantes_id = Player::where('name', 'Kenny Brantes')->first()->id;
        $miguel_cruz_id = Player::where('name', 'Miguel Da Cruz')->first()->id;
        $manuel_dias_id = Player::where('name', 'Manuel Dias')->first()->id;
        $kelton_silva_id = Player::where('name', 'Kelton Silva')->first()->id;

        $expected_response = [
            [
                'event_type' => EventType::INITIAL_WHISTLE->value,
                'minute' => 0,
                'player_id' => null,
                'player_name' => null,
                'team_id' => null,
                'team_name' => null,
            ],
            [
                'event_type' => "foul",
                'minute' => 10,
                'player_id' => $guga_id,
                'player_name' => "Guga Sousa",
                'team_id' => $mindelense->id,
                'team_name' => "Mindelense",
            ],
            [
                'event_type' => "foul",
                'minute' => 19,
                'player_id' => $n_rocha_id,
                'player_name' => "Nuno Rocha",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "foul",
                'minute' => 22,
                'player_id' => $n_rocha_id,
                'player_name' => "Nuno Rocha",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "yellow card",
                'minute' => 22,
                'player_id' => $n_rocha_id,
                'player_name' => "Nuno Rocha",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "goal",
                'minute' => 26,
                'player_id' => $airton_lopes_id,
                'player_name' => "Airton Lopes",
                'team_id' => $mindelense->id,
                'team_name' => "Mindelense",
            ],
            [
                'event_type' => "assist",
                'minute' => 26,
                'player_id' => $guga_id,
                'player_name' => "Guga Sousa",
                'team_id' => $mindelense->id,
                'team_name' => "Mindelense",
            ],
            [
                'event_type' => "goal",
                'minute' => 35,
                'player_id' => $n_rocha_id,
                'player_name' => "Nuno Rocha",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "foul",
                'minute' => 40,
                'player_id' => $flav_martins_id,
                'player_name' => "Flavio Martins",
                'team_id' => $mindelense->id,
                'team_name' => "Mindelense",
            ],
            [
                'event_type' => "goal",
                'minute' => 46,
                'player_id' => $day_gomes_id,
                'player_name' => "Day Gomes",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => EventType::HALF_TIME->value,
                'minute' => 48,
                'player_id' => null,
                'player_name' => null,
                'team_id' => null,
                'team_name' => null,
            ],
            [
                'event_type' => "goal",
                'minute' => 50,
                'player_id' => $kevin_lima_id,
                'player_name' => "Kevin Lima",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "assist",
                'minute' => 50,
                'player_id' => $kenny_brantes_id,
                'player_name' => "Kenny Brantes",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "subbing off",
                'minute' => 60,
                'player_id' => $flav_martins_id,
                'player_name' => "Flavio Martins",
                'team_id' => $mindelense->id,
                'team_name' => "Mindelense",
            ],
            [
                'event_type' => "subbing in",
                'minute' => 60,
                'player_id' => $manuel_dias_id,
                'player_name' => "Manuel Dias",
                'team_id' => $mindelense->id,
                'team_name' => "Mindelense",
            ],
            [
                'event_type' => "subbing off",
                'minute' => 68,
                'player_id' => $kenny_brantes_id,
                'player_name' => "Kenny Brantes",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "subbing in",
                'minute' => 68,
                'player_id' => $kelton_silva_id,
                'player_name' => "Kelton Silva",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "goal",
                'minute' => 89,
                'player_id' => $day_gomes_id,
                'player_name' => "Day Gomes",
                'team_id' => $derby->id,
                'team_name' => "Derby",
            ],
            [
                'event_type' => "foul",
                'minute' => 90,
                'player_id' => $miguel_cruz_id,
                'player_name' => "Miguel Da Cruz",
                'team_id' => $mindelense->id,
                'team_name' => "Mindelense",
            ],
            [
                'event_type' => "red card",
                'minute' => 90,
                'player_id' => $miguel_cruz_id,
                'player_name' => "Miguel Da Cruz",
                'team_id' => $mindelense->id,
                'team_name' => "Mindelense",
            ],
            [
                'event_type' => EventType::FINAL_WHISTLE->value,
                'minute' => 94,
                'player_id' => null,
                'player_name' => null,
                'team_id' => null,
                'team_name' => null,
            ],
        ];

        $response = $this->get("/api/games/$game_id/events");

        $response
            ->assertStatus(200)
            ->assertExactJson($expected_response);
    }
}
