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
    public function it_should_get_all_today_games_grouped_by_competitions(): void {
        $pl_competition_id = Competition::where('name', 'Premier League')->first()->id;
        $lpt_competition_id = Competition::where('name', 'Liga Portuguesa')->first()->id;

        $today_lpt_game_1_id = Game::where('location', 'Estádio Municipal de Braga')->first()->id;
        $today_lpt_game_2_id = Game::where('location', 'Estádio da Luz')->first()->id;
        $today_pl_game_1_id = Game::where('location', 'Old Trafford')->first()->id;

        $man_utd = Team::where('name', 'Manchester United')->first();
        $man_city = Team::where('name', 'Manchester City')->first();
        $sporting = Team::where('name', 'Sporting')->first();
        $braga = Team::where('name', 'Sporting Braga')->first();
        $benfica = Team::where('name', 'Benfica')->first();
        $porto = Team::where('name', 'Porto')->first();

        $expected_response = [
            [
                'id' => $lpt_competition_id,
                'competition_name' => 'Liga Portuguesa',
                'games' => [
                    [
                        'id' => $today_lpt_game_1_id,
                        'date' => Carbon::today()->setTime(15, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Estádio Municipal de Braga',
                        'home_team_id' => $braga->id,
                        'home_team_name' => 'Sporting Braga',
                        'away_team_id' => $sporting->id,
                        'away_team_name' => 'Sporting',
                        'home_score' => 2,
                        'away_score' => 5,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ],
                    [
                        'id' => $today_lpt_game_2_id,
                        'date' => Carbon::today()->setTime(15, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Estádio da Luz',
                        'home_team_id' => $benfica->id,
                        'home_team_name' => 'Benfica',
                        'away_team_id' => $porto->id,
                        'away_team_name' => 'Porto',
                        'home_score' => 4,
                        'away_score' => 4,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ]
                ]
            ],
            [
                'id' => $pl_competition_id,
                'competition_name' => 'Premier League',
                'games' => [
                    [
                        'id' => $today_pl_game_1_id,
                        'date' => Carbon::today()->setTime(15, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Old Trafford',
                        'home_team_id' => $man_utd->id,
                        'home_team_name' => 'Manchester United',
                        'away_team_id' => $man_city->id,
                        'away_team_name' => 'Manchester City',
                        'home_score' => 1,
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
        $this->assertCount(2, $response_data[0]['games'], 'The number of games for Liga Portuguesa should be 2.');
        $this->assertCount(1, $response_data[1]['games'], 'The number of games for Premier League should be 1.');
        // Assert that the response matches exactly with the expected JSON
        $response
            ->assertStatus(200)
            ->assertExactJson($expected_response);
    }
    
    #[Test]
    public function it_should_get_all_yesterday_games_grouped_by_competitions(): void {
        $pl_competition_id = Competition::where('name', 'Premier League')->first()->id;
        $lpt_competition_id = Competition::where('name', 'Liga Portuguesa')->first()->id;

        $yesterday_lpt_game_1_id = Game::where('location', 'Estádio Do Dragão')->first()->id;
        $yesterday_pl_game_1_id = Game::where('location', 'Eithad Stadium')->first()->id;

        $liverpool = Team::where('name', 'Liverpool')->first();
        $man_city = Team::where('name', 'Manchester City')->first();
        $sporting = Team::where('name', 'Sporting')->first();
        $porto = Team::where('name', 'Porto')->first();

        $expected_response = [
            [
                'id' => $lpt_competition_id,
                'competition_name' => 'Liga Portuguesa',
                'games' => [
                    [
                        'id' => $yesterday_lpt_game_1_id,
                        'date' => Carbon::yesterday()->setTime(10, 30, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Estádio Do Dragão',
                        'home_team_id' => $porto->id,
                        'home_team_name' => 'Porto',
                        'away_team_id' => $sporting->id,
                        'away_team_name' => 'Sporting',
                        'home_score' => 0,
                        'away_score' => 2,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ],
                ]
            ],
            [
                'id' => $pl_competition_id,
                'competition_name' => 'Premier League',
                'games' => [
                    [
                        'id' => $yesterday_pl_game_1_id,
                        'date' => Carbon::yesterday()->setTime(10, 30, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Eithad Stadium',
                        'home_team_id' => $man_city->id,
                        'home_team_name' => 'Manchester City',
                        'away_team_id' => $liverpool->id,
                        'away_team_name' => 'Liverpool',
                        'home_score' => 2,
                        'away_score' => 2,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ]
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
        $pl_competition_id = Competition::where('name', 'Premier League')->first()->id;
        $lpt_competition_id = Competition::where('name', 'Liga Portuguesa')->first()->id;

        $liverpool = Team::where('name', 'Liverpool')->first();
        $man_utd = Team::where('name', 'Manchester United')->first();
        $braga = Team::where('name', 'Sporting Braga')->first();
        $benfica = Team::where('name', 'Benfica')->first();

        $tomorrow_lpt_game_1_id = Game::where('location', 'Estádio Municipal de Braga')
            ->where('date', Carbon::tomorrow()->setTime(9, 0, 0))
            ->first()->id;

        $tomorrow_pl_game_1_id = Game::where('location', 'Anfield')
            ->where('date', Carbon::tomorrow()->setTime(9, 0, 0))
            ->first()->id;

        $expected_response = [
            [
                'id' => $lpt_competition_id,
                'competition_name' => 'Liga Portuguesa',
                'games' => [
                    [
                        'id' => $tomorrow_lpt_game_1_id,
                        'date' => Carbon::tomorrow()->setTime(9, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Estádio Municipal de Braga',
                        'home_team_id' => $braga->id,
                        'home_team_name' => 'Sporting Braga',
                        'away_team_id' => $benfica->id,
                        'away_team_name' => 'Benfica',
                        'home_score' => null,
                        'away_score' => null,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ],
                ]
            ],
            [
                'id' => $pl_competition_id,
                'competition_name' => 'Premier League',
                'games' => [
                    [
                        'id' => $tomorrow_pl_game_1_id,
                        'date' => Carbon::tomorrow()->setTime(9, 0, 0)->format('Y-m-d\TH:i:s'),
                        'location' => 'Anfield',
                        'home_team_id' => $liverpool->id,
                        'home_team_name' => 'Liverpool',
                        'away_team_id' => $man_utd->id,
                        'away_team_name' => 'Manchester United',
                        'home_score' => null,
                        'away_score' => null,
                        'started' => false,
                        'ongoing' => false,
                        'finished' => false,
                    ]
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
        $man_utd = Team::where('name', 'Manchester United')->first();
        $man_city = Team::where('name', 'Manchester City')->first();

        $game_id = Result::where('home_team_id', $man_utd->id)
            ->where('away_team_id', $man_city->id)
            ->first()->game_id;

        $bruno_f_id = Player::where('name', 'Bruno Fernandes')->first()->id;
        $rodri_id = Player::where('name', 'Rodri')->first()->id;
        $marc_rashford_id = Player::where('name', 'Marcus Rashford')->first()->id;
        $casemiro_id = Player::where('name', 'Casemiro')->first()->id;
        $halland_id = Player::where('name', 'Erling Haaland')->first()->id;
        $ruben_dias_id = Player::where('name', 'Rúben Dias')->first()->id; 
        $de_bruyne_id = Player::where('name', 'Kevin De Bruyne')->first()->id;
        $varane_id = Player::where('name', 'Raphaël Varane')->first()->id;
        $antony_id = Player::where('name', 'Antony')->first()->id;
        $foden_id = Player::where('name', 'Phil Foden')->first()->id;

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
                'player_id' => $bruno_f_id,
                'player_name' => "Bruno Fernandes",
                'team_id' => $man_utd->id,
                'team_name' => "Manchester United",
            ],
            [
                'event_type' => "foul",
                'minute' => 19,
                'player_id' => $rodri_id,
                'player_name' => "Rodri",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "foul",
                'minute' => 22,
                'player_id' => $rodri_id,
                'player_name' => "Rodri",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "yellow card",
                'minute' => 22,
                'player_id' => $rodri_id,
                'player_name' => "Rodri",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "goal",
                'minute' => 26,
                'player_id' => $marc_rashford_id,
                'player_name' => "Marcus Rashford",
                'team_id' => $man_utd->id,
                'team_name' => "Manchester United",
            ],
            [
                'event_type' => "assist",
                'minute' => 26,
                'player_id' => $bruno_f_id,
                'player_name' => "Bruno Fernandes",
                'team_id' => $man_utd->id,
                'team_name' => "Manchester United",
            ],
            [
                'event_type' => "goal",
                'minute' => 35,
                'player_id' => $rodri_id,
                'player_name' => "Rodri",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "foul",
                'minute' => 40,
                'player_id' => $casemiro_id,
                'player_name' => "Casemiro",
                'team_id' => $man_utd->id,
                'team_name' => "Manchester United",
            ],
            [
                'event_type' => "goal",
                'minute' => 46,
                'player_id' => $halland_id,
                'player_name' => "Erling Haaland",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
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
                'player_id' => $ruben_dias_id,
                'player_name' => "Rúben Dias",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "assist",
                'minute' => 50,
                'player_id' => $de_bruyne_id,
                'player_name' => "Kevin De Bruyne",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "subbing off",
                'minute' => 60,
                'player_id' => $casemiro_id,
                'player_name' => "Casemiro",
                'team_id' => $man_utd->id,
                'team_name' => "Manchester United",
            ],
            [
                'event_type' => "subbing in",
                'minute' => 60,
                'player_id' => $antony_id,
                'player_name' => "Antony",
                'team_id' => $man_utd->id,
                'team_name' => "Manchester United",
            ],
            [
                'event_type' => "subbing off",
                'minute' => 68,
                'player_id' => $de_bruyne_id,
                'player_name' => "Kevin De Bruyne",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "subbing in",
                'minute' => 68,
                'player_id' => $foden_id,
                'player_name' => "Phil Foden",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "goal",
                'minute' => 89,
                'player_id' => $halland_id,
                'player_name' => "Erling Haaland",
                'team_id' => $man_city->id,
                'team_name' => "Manchester City",
            ],
            [
                'event_type' => "foul",
                'minute' => 90,
                'player_id' => $varane_id,
                'player_name' => "Raphaël Varane",
                'team_id' => $man_utd->id,
                'team_name' => "Manchester United",
            ],
            [
                'event_type' => "red card",
                'minute' => 90,
                'player_id' => $varane_id,
                'player_name' => "Raphaël Varane",
                'team_id' => $man_utd->id,
                'team_name' => "Manchester United",
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
