<?php

namespace App\Traits;

use App\Enums\EventType;
use App\Models\Competition;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\PlayerGame;
use App\Models\Result;
use App\Models\Season;
use App\Models\SeasonCompetition;
use App\Models\Team;
use Carbon\Carbon;

trait DatabaseSeederTrait {
    protected function seed_competitions_and_teams() {
        $competition_teams = [
            "Campeonato de São Vicente - 1ª Divisão" => [
                "Mindelense",
                "Derby",
                "Académica do Mindelo",
                "Batuque",
                "Amarante",
                "Farense",
                "Castilho",
                "Salamansa",
            ],
            "Campeonato de São Vicente - 2ª Divisão" => [
                "Corinthians",
                "Calhau",
                "Uni Mindelo",
                "Estoril",
                "São Pedro",
                "Falcões do Norte",
                "Ribeira Bote",
                "Ponta d'Pom",
            ],
           
        ];

        $team_players = [
            "Mindelense" => [
                ["name" => "Guga Sousa", "birthdate" => "1993-11-15"],
                ["name" => "Airton Lopes", "birthdate" => "1996-06-19"],
                ["name" => "Manuel Dias", "birthdate" => "1997-10-02"],
                ["name" => "Flavio Martins", "birthdate" => "1989-11-22"],
                ["name" => "Miguel Da Cruz", "birthdate" => "1995-03-03"],
            ],
            "Derby" => [
                ["name" => "Nuno Rocha", "birthdate" => "1993-11-15"],
                ["name" => "Day Gomes", "birthdate" => "1996-06-19"],
                ["name" => "Kevin Lima", "birthdate" => "1997-10-02"],
                ["name" => "Kelton Silva", "birthdate" => "1989-11-22"],
                ["name" => "Kenny Brantes", "birthdate" => "1995-03-03"],
            ],
            "Académica do Mindelo" => [
                ["name" => "Nuno Livramento", "birthdate" => "1993-11-15"],
                ["name" => "Dario Miguel", "birthdate" => "1996-06-19"],
                ["name" => "Luis CArlos", "birthdate" => "1997-10-02"],
                ["name" => "Luis Fortes", "birthdate" => "1989-11-22"],
                ["name" => "Garry Helton", "birthdate" => "1995-03-03"],
            ],
            "Batuque" => [
                ["name" => "Helton Gomes", "birthdate" => "1993-11-15"],
                ["name" => "Gilberto Dias", "birthdate" => "1996-06-19"],
                ["name" => "Waldir Rocha", "birthdate" => "1997-10-02"],
                ["name" => "Valdir Alves", "birthdate" => "1989-11-22"],
                ["name" => "Renato Lopes", "birthdate" => "1995-03-03"],
            ],
            "Amarante" => [
                ["name" => "Izneider Gomes", "birthdate" => "1993-11-15"],
                ["name" => "Jeff Preston", "birthdate" => "1996-06-19"],
                ["name" => "Ruben Tavares", "birthdate" => "1997-10-02"],
                ["name" => "Junior Felgueiras", "birthdate" => "1989-11-22"],
                ["name" => "Renato Lucio", "birthdate" => "1995-03-03"],
            ],
            "Farense" => [
                ["name" => "Lucio Diamante", "birthdate" => "1993-11-15"],
                ["name" => "Luciano Lopes", "birthdate" => "1996-06-19"],
                ["name" => "Leonardo Lima", "birthdate" => "1997-10-02"],
                ["name" => "Djo Manuel", "birthdate" => "1989-11-22"],
                ["name" => "Dji Helton", "birthdate" => "1995-03-03"],
            ],
            "Castilho" => [
                ["name" => "Vala Gomes", "birthdate" => "1993-11-15"],
                ["name" => "Austelino Felgueiras", "birthdate" => "1996-06-19"],
                ["name" => "Djack Costa", "birthdate" => "1997-10-02"],
                ["name" => "Natalino Tavares", "birthdate" => "1989-11-22"],
                ["name" => "Enrique Gomes", "birthdate" => "1995-03-03"],
            ],
            "Salamansa" => [
                ["name" => "Puntuck Alvio", "birthdate" => "1993-11-15"],
                ["name" => "Nanny Cruz", "birthdate" => "1996-06-19"],
                ["name" => "Nany Freitas", "birthdate" => "1997-10-02"],
                ["name" => "Nivaldo Pereira", "birthdate" => "1989-11-22"],
                ["name" => "Kiro Gomes", "birthdate" => "1995-03-03"],
            ],
            "Corinthians" => [
                ["name" => "Bauss Lima", "birthdate" => "1993-11-15"],
                ["name" => "Pastor Pires", "birthdate" => "1996-06-19"],
                ["name" => "Bruno Verissimo", "birthdate" => "1997-10-02"],
                ["name" => "Ediven Pires", "birthdate" => "1989-11-22"],
                ["name" => "Guta Pires", "birthdate" => "1995-03-03"],
            ],
            "Calhau" => [
                ["name" => "Rudy Rocha", "birthdate" => "1993-11-15"],
                ["name" => "Cuin Rocha", "birthdate" => "1996-06-19"],
                ["name" => "Maky Costa", "birthdate" => "1997-10-02"],
                ["name" => "Edy Cruz", "birthdate" => "1989-11-22"],
                ["name" => "Ditch Alves", "birthdate" => "1995-03-03"],
            ],
            "Uni Mindelo" => [
                ["name" => "Niny Pereira", "birthdate" => "1993-11-15"],
                ["name" => "Marcos Lopes", "birthdate" => "1996-06-19"],
                ["name" => "Marcos Silva", "birthdate" => "1997-10-02"],
                ["name" => "Walter Silva", "birthdate" => "1989-11-22"],
                ["name" => "Romario Sousa", "birthdate" => "1995-03-03"],
            ],
            "Estoril" => [
                ["name" => "Vadjoiss Silva", "birthdate" => "1993-11-15"],
                ["name" => "Miguel Luis", "birthdate" => "1996-06-19"],
                ["name" => "Maiu Gilberto", "birthdate" => "1997-10-02"],
                ["name" => "Cuk Kelton", "birthdate" => "1989-11-22"],
                ["name" => "Kevin Bruno", "birthdate" => "1995-03-03"],
            ],
            "São Pedro" => [
                ["name" => "Vadi Frederico", "birthdate" => "1993-11-15"],
                ["name" => "Gilberto Gilbratar", "birthdate" => "1996-06-19"],
                ["name" => "Bu Jorge", "birthdate" => "1997-10-02"],
                ["name" => "Dario Duarte", "birthdate" => "1989-11-22"],
                ["name" => "Kiren Hugo", "birthdate" => "1995-03-03"],
            ],
            "Falcões do Norte" => [
                ["name" => "Papy Gomes", "birthdate" => "1993-11-15"],
                ["name" => "Patrick Lopes", "birthdate" => "1996-06-19"],
                ["name" => "Jorge Reis", "birthdate" => "1997-10-02"],
                ["name" => "Juary Madureira", "birthdate" => "1989-11-22"],
                ["name" => "Bryan Costa", "birthdate" => "1995-03-03"],
            ],
            "Ribeira Bote" => [
                ["name" => "Helton Orlando", "birthdate" => "1993-11-15"],
                ["name" => "Osvaldino Queiroz", "birthdate" => "1996-06-19"],
                ["name" => "Silvio Soares", "birthdate" => "1997-10-02"],
                ["name" => "Manuel Morais", "birthdate" => "1989-11-22"],
                ["name" => "Lucas David", "birthdate" => "1995-03-03"],
            ],
            "Ponta d'Pom" => [
                ["name" => "Henry Julio", "birthdate" => "1993-11-15"],
                ["name" => "Eros David", "birthdate" => "1996-06-19"],
                ["name" => "Bryan Brito", "birthdate" => "1997-10-02"],
                ["name" => "Jandir Livramento", "birthdate" => "1989-11-22"],
                ["name" => "Mauro Faria", "birthdate" => "1995-03-03"],
            ],
        ];

        $season = Season::create([ // this can be improved to accept dynamic years
            "year" => "24/25"
        ]);

        // load competitions
        foreach (array_keys($competition_teams) as $competition_name) {
            $competition = Competition::create([
                'name' => $competition_name, 
                'type' => 'league'
            ]);

            // load teams and assigned them to competitions by season
            foreach ($competition_teams[$competition_name] as $team_name) {
                $team = Team::firstOrCreate(['name' => $team_name], [
                    'founded' => fake()->date(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                SeasonCompetition::create([
                    'season_id' => $season->id,
                    'competition_id' => $competition->id,
                    'team_id' => $team->id,
                ]);

                if (isset($team_players[$team_name])) {
                    foreach ($team_players[$team_name] as $player_data) {
                        Player::create([
                            'name' => $player_data['name'],
                            'birthdate' => $player_data['birthdate'],
                            'team_id' => $team->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }

    protected function seed_players_to_game($players, Game $game, ) {
        foreach ($players as $player) {
            if (! $player instanceof Player) {
                throw new \InvalidArgumentException('All players must be instances of Player model');
            }

            PlayerGame::create([
                'game_id' => $game->id,
                'player_id' => $player->id
            ]);
        }
    }

    protected function seed_competitons_teams_and_results() {
        $this->seed_competitions_and_teams();

        $sv_premier_league = Competition::where('name', 'Campeonato de São Vicente - 1ª Divisão')->first()->id;
        $sv_second_league = Competition::where('name', 'Campeonato de São Vicente - 2ª Divisão')->first()->id;

        $season_id = Season::where('year', '24/25')->first()->id;

        // get sv premier league teams
        $mindelense = Team::where('name', 'Mindelense')->first();
        $derby = Team::where('name', 'Derby')->first();
        $amarante = Team::where('name', 'Amarante')->first();

        // get sv second league teams
        $uni_mindelo = Team::where('name', 'Uni Mindelo')->first();
        $estoril = Team::where('name', 'Estoril')->first();
        $calhau = Team::where('name', 'Calhau')->first();
        $ponta_pom = Team::where('name', "Ponta d'Pom")->first();

        $pl_today_date = Carbon::today()->setTime(16, 0, 0);// e.g., today at 16:00
        $sl_today_date_1 = Carbon::today()->setTime(10, 0, 0); 
        $sl_today_date_2 = Carbon::today()->setTime(12, 0, 0);
        $sl_yesterday_date = Carbon::yesterday()->setTime(12, 0, 0);
        $pl_yesterday_date = Carbon::yesterday()->setTime(16, 0, 0);
        $sl_tomorrow_date_1 = Carbon::tomorrow()->setTime(10, 0, 0);
        $pl_tomorrow_date_1 = Carbon::tomorrow()->setTime(14, 0, 0);

        $yesterday_pl_game_1 = Game::factory()->create([
            'date' => $pl_yesterday_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $sv_second_league,
        ]);
        $yesterday_sl_game_1 = Game::factory()->create([
            'date' => $sl_yesterday_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $sv_premier_league
        ]);

        $today_pl_game_1 = Game::factory()->create([
            'date' => $pl_today_date,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $sv_second_league,
        ]);
        $today_sl_game_1 = Game::factory()->create([
            'date' => $sl_today_date_1,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $sv_premier_league
        ]);
        $today_sl_game_2 = Game::factory()->create([
            'date' => $sl_today_date_2,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $sv_premier_league
        ]);

        $tomorrow_pl_game_1 = Game::factory()->create([
            'date' => $pl_tomorrow_date_1,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $sv_second_league,
        ]);
        $tomorrow_sl_game_1 = Game::factory()->create([
            'date' => $sl_tomorrow_date_1,
            'location' => 'Adérito Sena',
            'season_id' => $season_id,
            'competition_id' => $sv_premier_league
        ]);

        // add players to today_pl_game_1 --> Mindelense vs Derby
        $this->seed_players_to_game($mindelense->players, $today_pl_game_1);
        $this->seed_players_to_game($derby->players, $today_pl_game_1);

        // events of today_pl_game_1 --> Mindelense vs Derby
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => EventType::INITIAL_WHISTLE->value,
            'minute' => 0,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $mindelense->players->where('name', 'Guga Sousa')->first()->id,
            'team_id' => $mindelense->id,
            'minute' => 10,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $derby->players->where('name', 'Nuno Rocha')->first()->id,
            'team_id' => $derby->id,
            'minute' => 19,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $derby->players->where('name', 'Nuno Rocha')->first()->id,
            'team_id' => $derby->id,
            'minute' => 22,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'yellow card',
            'player_id' => $derby->players->where('name', 'Nuno Rocha')->first()->id,
            'team_id' => $derby->id,
            'minute' => 22,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $mindelense->players->where('name', 'Airton Lopes')->first()->id,
            'team_id' => $mindelense->id,
            'minute' => 26,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'assist',
            'player_id' => $mindelense->players->where('name', 'Guga Sousa')->first()->id,
            'team_id' => $mindelense->id,
            'minute' => 26,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $derby->players->where('name', 'Nuno Rocha')->first()->id,
            'team_id' => $derby->id,
            'minute' => 35,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $mindelense->players->where('name', 'Flavio Martins')->first()->id,
            'team_id' => $mindelense->id,
            'minute' => 40,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $derby->players->where('name', 'Day Gomes')->first()->id,
            'team_id' => $derby->id,
            'minute' => 46,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => EventType::HALF_TIME->value,
            'minute' => 48,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $derby->players->where('name', 'Kevin Lima')->first()->id,
            'team_id' => $derby->id,
            'minute' => 50,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'assist',
            'player_id' => $derby->players->where('name', 'Kenny Brantes')->first()->id,
            'team_id' => $derby->id,
            'minute' => 50,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'subbing off',
            'player_id' => $mindelense->players->where('name', 'Flavio Martins')->first()->id,
            'team_id' => $mindelense->id,
            'minute' => 60,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'subbing in',
            'player_id' => $mindelense->players->where('name', 'Manuel Dias')->first()->id,
            'team_id' => $mindelense->id,
            'minute' => 60,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'subbing off',
            'player_id' => $derby->players->where('name', 'Kenny Brantes')->first()->id,
            'team_id' => $derby->id,
            'minute' => 68,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'subbing in',
            'player_id' => $derby->players->where('name', 'Kelton Silva')->first()->id,
            'team_id' => $derby->id,
            'minute' => 68,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $derby->players->where('name', 'Day Gomes')->first()->id,
            'team_id' => $derby->id,
            'minute' => 89,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $mindelense->players->where('name', 'Miguel Da Cruz')->first()->id,
            'team_id' => $mindelense->id,
            'minute' => 90,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'red card',
            'player_id' => $mindelense->players->where('name', 'Miguel Da Cruz')->first()->id,
            'team_id' => $mindelense->id,
            'minute' => 90,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => EventType::FINAL_WHISTLE->value,
            'minute' => 94,
        ]);

        // events of today today_sl_game_1 --> Estoril vs Uni Mindelo
        Event::create([
            'game_id' => $today_sl_game_1->id,
            'event_type' => EventType::INITIAL_WHISTLE->value,
            'minute' => 0,
        ]);
        Event::create([
            'game_id' => $today_sl_game_1->id,
            'event_type' => EventType::FINAL_WHISTLE->value,
            'minute' => 96,
        ]);

        // events of today today_sl_game_1 --> Calhau vs Ponta Pom
        Event::create([
            'game_id' => $today_sl_game_2->id,
            'event_type' => EventType::INITIAL_WHISTLE->value,
            'minute' => 0,
        ]);
        Event::create([
            'game_id' => $today_sl_game_2->id,
            'event_type' => EventType::FINAL_WHISTLE->value,
            'minute' => 93,
        ]);

        Result::create([
            'game_id' => $yesterday_pl_game_1->id,
            'home_team_id' => $derby->id,
            'away_team_id' => $amarante->id,
            'home_score' => 2,
            'away_score' => 2,
        ]);

        Result::create([
            'game_id' => $yesterday_sl_game_1->id,
            'home_team_id' => $ponta_pom->id,
            "away_team_id" => $uni_mindelo->id,
            'home_score' => 0,
            'away_score' => 2,
        ]);

        Result::create([
            'game_id' => $today_pl_game_1->id,
            'home_team_id' => $mindelense->id,
            'away_team_id' => $derby->id,
            'home_score' => 1,
            'away_score' => 4,
        ]);

        Result::create([
            'game_id' => $today_sl_game_1->id,
            'home_team_id' => $estoril->id,
            'away_team_id' => $uni_mindelo->id,
            'home_score' => 2,
            'away_score' => 5,
        ]);

        Result::create([
            'game_id' => $today_sl_game_2->id,
            'home_team_id' => $calhau->id,
            'away_team_id' => $ponta_pom->id,
            "home_score" => 4,
            'away_score' => 4,
        ]);

        Result::create([
            'game_id' => $tomorrow_pl_game_1->id,
            'home_team_id' => $amarante->id,
            'away_team_id' => $mindelense->id,
        ]);

        Result::create([
            'game_id' => $tomorrow_sl_game_1->id,
            'home_team_id' => $estoril->id,
            'away_team_id' => $calhau->id,
        ]);
    }
}
