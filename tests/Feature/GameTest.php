<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Result;
use App\Models\Team;
use App\Traits\DatabaseSeederTrait;
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

    /** @test */
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
        $response->assertExactJson($expected_response);
    }
    // TODO: it_should_get_all_yesterday_games_grouped_by_competitions
    // TODO: it_should_get_all_tomorrow_games_grouped_by_competitions

    /** @test */
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

        $expected_response = [
            [
                'event_type' => "start",
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
                'event_type' => "interval",
                'minute' => 48,
                'player_id' => null,
                'player_name' => null,
                'team_id' => null,
                'team_name' => null,
            ],

        ];

        $response = $this->get("/api/games/$game_id/events");
        // dd($response);
        $response->assertExactJson($expected_response);
    }
}
