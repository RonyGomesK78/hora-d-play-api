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
            "Campeonato de São Vicente" => [
                "Mindelenese",
                "Derby",
                "Academica",
                "Batuque",
                "Amarante",
            ],
            "Liga Portuguesa" => [
                "Benfica",
                "Porto",
                "Sporting",
                "Sporting Braga",
                "Belenenses",
            ],
            "Premier League" => [
                "Manchester United",
                "Liverpool",
                "Chelsea",
                "Arsenal",
                "Manchester City",
            ],
            "La Liga" => [
                "Barcelona",
                "Real Madrid",
                "Atletico Madrid",
                "Sevilla",
                "Valencia",
            ],
            "Serie A" => [
                "Juventus",
                "AC Milan",
                "Inter Milan",
                "Napoli",
                "AS Roma",
            ],
            "Champions League" => [], // Add teams here if needed
        ];

        $team_players = [
            "Benfica" => [
                ["name" => "Alexander Bah", "birthdate" => "1995-06-18"],
                ["name" => "João Mário", "birthdate" => "1993-01-19"],
                ["name" => "David Neres", "birthdate" => "1997-03-03"],
                ["name" => "Orkun Kökçü", "birthdate" => "2000-12-25"],
                ["name" => "Fredrik Aursnes", "birthdate" => "1995-12-10"],
            ],
            "Porto" => [
                ["name" => "Diogo Costa", "birthdate" => "1999-09-24"],
                ["name" => "Pepe", "birthdate" => "1982-02-26"],
                ["name" => "Otávio", "birthdate" => "1995-02-09"],
                ["name" => "Evanilson", "birthdate" => "1999-01-05"],
                ["name" => "Mateus Uribe", "birthdate" => "1991-03-21"],
            ],
            "Sporting CP" => [
                ["name" => "Antonio Adán", "birthdate" => "1987-05-13"],
                ["name" => "Sebastián Coates", "birthdate" => "1990-10-07"],
                ["name" => "Pedro Gonçalves", "birthdate" => "1998-06-28"],
                ["name" => "Paulinho", "birthdate" => "1992-11-09"],
                ["name" => "Manuel Ugarte", "birthdate" => "2001-04-11"],
            ],
            "Braga" => [
                ["name" => "Matheus Magalhães", "birthdate" => "1992-03-10"],
                ["name" => "Ricardo Horta", "birthdate" => "1994-09-15"],
                ["name" => "Al Musrati", "birthdate" => "1996-04-25"],
                ["name" => "Abel Ruiz", "birthdate" => "2000-01-28"],
                ["name" => "Sikou Niakaté", "birthdate" => "1999-07-10"],
            ],
            "Belenenses" => [
                ["name" => "João Monteiro", "birthdate" => "1997-08-15"],
                ["name" => "Sandro Semedo", "birthdate" => "1996-12-01"],
                ["name" => "Miguel Rosa", "birthdate" => "1989-01-13"],
                ["name" => "Diogo Pacheco", "birthdate" => "1995-07-04"],
                ["name" => "Gonçalo Tavares", "birthdate" => "1999-05-22"],
            ],
            "Manchester United" => [
                ["name" => "Bruno Fernandes", "birthdate" => "1994-09-08"],
                ["name" => "Marcus Rashford", "birthdate" => "1997-10-31"],
                ["name" => "Raphaël Varane", "birthdate" => "1993-04-25"],
                ["name" => "Casemiro", "birthdate" => "1992-02-23"],
                ["name" => "Antony", "birthdate" => "2000-02-24"],
            ],
            "Liverpool" => [
                ["name" => "Mohamed Salah", "birthdate" => "1992-06-15"],
                ["name" => "Alisson Becker", "birthdate" => "1992-10-02"],
                ["name" => "Virgil van Dijk", "birthdate" => "1991-07-08"],
                ["name" => "Trent Alexander-Arnold", "birthdate" => "1998-10-07"],
                ["name" => "Diogo Jota", "birthdate" => "1996-12-04"],
            ],
            "Chelsea" => [
                ["name" => "Thiago Silva", "birthdate" => "1984-09-22"],
                ["name" => "Enzo Fernández", "birthdate" => "2001-01-17"],
                ["name" => "Raheem Sterling", "birthdate" => "1994-12-08"],
                ["name" => "Reece James", "birthdate" => "1999-12-08"],
                ["name" => "Noni Madueke", "birthdate" => "2002-03-10"],
            ],
            "Arsenal" => [
                ["name" => "Bukayo Saka", "birthdate" => "2001-09-05"],
                ["name" => "Martin Ødegaard", "birthdate" => "1998-12-17"],
                ["name" => "Gabriel Jesus", "birthdate" => "1997-04-03"],
                ["name" => "Declan Rice", "birthdate" => "1999-01-14"],
                ["name" => "Aaron Ramsdale", "birthdate" => "1998-05-14"],
            ],
            "Manchester City" => [
                ["name" => "Kevin De Bruyne", "birthdate" => "1991-06-28"],
                ["name" => "Erling Haaland", "birthdate" => "2000-07-21"],
                ["name" => "Phil Foden", "birthdate" => "2000-05-28"],
                ["name" => "Rodri", "birthdate" => "1996-06-22"],
                ["name" => "Rúben Dias", "birthdate" => "1997-05-14"],
            ],
            "Barcelona" => [
                ["name" => "Robert Lewandowski", "birthdate" => "1988-08-21"],
                ["name" => "Pedri", "birthdate" => "2002-11-25"],
                ["name" => "Frenkie de Jong", "birthdate" => "1997-05-12"],
                ["name" => "Jules Koundé", "birthdate" => "1998-11-12"],
                ["name" => "Ilkay Gündogan", "birthdate" => "1990-10-24"],
            ],
            "Real Madrid" => [
                ["name" => "Vinícius Júnior", "birthdate" => "2000-07-12"],
                ["name" => "Rodrygo", "birthdate" => "2001-01-09"],
                ["name" => "Eduardo Camavinga", "birthdate" => "2002-11-10"],
                ["name" => "Aurélien Tchouaméni", "birthdate" => "2000-01-27"],
                ["name" => "David Alaba", "birthdate" => "1992-06-24"],
            ],
            "Atletico Madrid" => [
                ["name" => "Antoine Griezmann", "birthdate" => "1991-03-21"],
                ["name" => "Jan Oblak", "birthdate" => "1993-01-07"],
                ["name" => "Koke", "birthdate" => "1992-01-08"],
                ["name" => "Rodrigo de Paul", "birthdate" => "1994-05-24"],
                ["name" => "José Giménez", "birthdate" => "1995-01-20"],
            ],
            "Sevilla" => [
                ["name" => "Ivan Rakitić", "birthdate" => "1988-03-10"],
                ["name" => "Youssef En-Nesyri", "birthdate" => "1997-06-01"],
                ["name" => "Marcos Acuña", "birthdate" => "1991-10-28"],
                ["name" => "Bono", "birthdate" => "1991-04-05"],
                ["name" => "Jesús Navas", "birthdate" => "1985-11-21"],
            ],
            "Valencia" => [
                ["name" => "José Gayà", "birthdate" => "1995-05-25"],
                ["name" => "André Almeida", "birthdate" => "2000-05-30"],
                ["name" => "Thierry Correia", "birthdate" => "1999-03-09"],
                ["name" => "Hugo Duro", "birthdate" => "1999-11-10"],
                ["name" => "Javi Guerra", "birthdate" => "2003-05-13"],
            ],
            "Juventus" => [
                ["name" => "Federico Chiesa", "birthdate" => "1997-10-25"],
                ["name" => "Dusan Vlahovic", "birthdate" => "2000-01-28"],
                ["name" => "Manuel Locatelli", "birthdate" => "1998-01-08"],
                ["name" => "Wojciech Szczęsny", "birthdate" => "1990-04-18"],
                ["name" => "Paul Pogba", "birthdate" => "1993-03-15"],
            ],
            "AC Milan" => [
                ["name" => "Rafael Leão", "birthdate" => "1999-06-10"],
                ["name" => "Mike Maignan", "birthdate" => "1995-07-03"],
                ["name" => "Theo Hernández", "birthdate" => "1997-10-06"],
                ["name" => "Olivier Giroud", "birthdate" => "1986-09-30"],
                ["name" => "Sandro Tonali", "birthdate" => "2000-05-08"],
            ],
            "Inter Milan" => [
                ["name" => "Lautaro Martínez", "birthdate" => "1997-08-22"],
                ["name" => "Nicolò Barella", "birthdate" => "1997-02-07"],
                ["name" => "Alessandro Bastoni", "birthdate" => "1999-04-13"],
                ["name" => "Denzel Dumfries", "birthdate" => "1996-04-18"],
                ["name" => "André Onana", "birthdate" => "1996-04-02"],
            ],
            "Napoli" => [
                ["name" => "Victor Osimhen", "birthdate" => "1998-12-29"],
                ["name" => "Khvicha Kvaratskhelia", "birthdate" => "2001-02-12"],
                ["name" => "Piotr Zieliński", "birthdate" => "1994-05-20"],
                ["name" => "Giovanni Di Lorenzo", "birthdate" => "1993-08-04"],
                ["name" => "Stanislav Lobotka", "birthdate" => "1994-11-25"],
            ],
            "AS Roma" => [
                ["name" => "Paulo Dybala", "birthdate" => "1993-11-15"],
                ["name" => "Lorenzo Pellegrini", "birthdate" => "1996-06-19"],
                ["name" => "Tammy Abraham", "birthdate" => "1997-10-02"],
                ["name" => "Chris Smalling", "birthdate" => "1989-11-22"],
                ["name" => "Bryan Cristante", "birthdate" => "1995-03-03"],
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

        $portuguese_league_id = Competition::where('name', 'Liga Portuguesa')->first()->id;
        $premier_league_id = Competition::where('name', 'Premier League')->first()->id;

        $season_id = Season::where('year', '24/25')->first()->id;

        // get premier league teams
        $man_utd = Team::where('name', 'Manchester United')->first();
        $man_city = Team::where('name', 'Manchester City')->first();
        $liverpool = Team::where('name', 'Liverpool')->first();

        // get portuguese league teams
        $sporting = Team::where('name', 'Sporting')->first();
        $braga = Team::where('name', 'Sporting Braga')->first();
        $benfica = Team::where('name', 'Benfica')->first();
        $porto = Team::where('name', 'Porto')->first();

        $today_date = Carbon::today()->setTime(15, 0, 0);// e.g., today at 15:00
        $yesterday_date = Carbon::yesterday()->setTime(10, 30, 0);
        $tomorrow_date = Carbon::tomorrow()->setTime(9, 0, 0);

        $yesterday_pl_game_1 = Game::factory()->create([
            'date' => $yesterday_date,
            'location' => 'Eithad Stadium',
            'season_id' => $season_id,
            'competition_id' => $premier_league_id,
        ]);
        $yesterday_lpt_game_1 = Game::factory()->create([
            'date' => $yesterday_date,
            'location' => 'Estádio Do Dragão',
            'season_id' => $season_id,
            'competition_id' => $portuguese_league_id
        ]);

        $today_pl_game_1 = Game::factory()->create([
            'date' => $today_date,
            'location' => 'Old Trafford',
            'season_id' => $season_id,
            'competition_id' => $premier_league_id,
        ]);
        $today_lpt_game_1 = Game::factory()->create([
            'date' => $today_date,
            'location' => 'Estádio Municipal de Braga',
            'season_id' => $season_id,
            'competition_id' => $portuguese_league_id
        ]);
        $today_lpt_game_2 = Game::factory()->create([
            'date' => $today_date,
            'location' => 'Estádio da Luz',
            'season_id' => $season_id,
            'competition_id' => $portuguese_league_id
        ]);

        $tomorrow_pl_game_1 = Game::factory()->create([
            'date' => $tomorrow_date,
            'location' => 'Anfield',
            'season_id' => $season_id,
            'competition_id' => $premier_league_id,
        ]);
        $tomorrow_lpt_game_1 = Game::factory()->create([
            'date' => $tomorrow_date,
            'location' => 'Estádio Municipal de Braga',
            'season_id' => $season_id,
            'competition_id' => $portuguese_league_id
        ]);

        
        // add players to today_pl_game_1 --> Man Utd vs Man City
        $this->seed_players_to_game($man_utd->players, $today_pl_game_1);
        $this->seed_players_to_game($man_city->players, $today_pl_game_1);

        // events of today_pl_game_1 --> Man Utd vs Man City
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => EventType::INITIAL_WHISTLE->value,
            'minute' => 0,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $man_utd->players->where('name', 'Bruno Fernandes')->first()->id,
            'team_id' => $man_utd->id,
            'minute' => 10,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $man_city->players->where('name', 'Rodri')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 19,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $man_city->players->where('name', 'Rodri')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 22,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'yellow card',
            'player_id' => $man_city->players->where('name', 'Rodri')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 22,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $man_utd->players->where('name', 'Marcus Rashford')->first()->id,
            'team_id' => $man_utd->id,
            'minute' => 26,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'assist',
            'player_id' => $man_utd->players->where('name', 'Bruno Fernandes')->first()->id,
            'team_id' => $man_utd->id,
            'minute' => 26,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $man_city->players->where('name', 'Rodri')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 35,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $man_utd->players->where('name', 'Casemiro')->first()->id,
            'team_id' => $man_utd->id,
            'minute' => 40,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $man_city->players->where('name', 'Erling Haaland')->first()->id,
            'team_id' => $man_city->id,
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
            'player_id' => $man_city->players->where('name', 'Rúben Dias')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 50,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'assist',
            'player_id' => $man_city->players->where('name', 'Kevin De Bruyne')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 50,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'subbing off',
            'player_id' => $man_utd->players->where('name', 'Casemiro')->first()->id,
            'team_id' => $man_utd->id,
            'minute' => 60,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'subbing in',
            'player_id' => $man_utd->players->where('name', 'Antony')->first()->id,
            'team_id' => $man_utd->id,
            'minute' => 60,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'subbing off',
            'player_id' => $man_city->players->where('name', 'Kevin De Bruyne')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 68,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'subbing in',
            'player_id' => $man_city->players->where('name', 'Phil Foden')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 68,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'goal',
            'player_id' => $man_city->players->where('name', 'Erling Haaland')->first()->id,
            'team_id' => $man_city->id,
            'minute' => 89,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'foul',
            'player_id' => $man_utd->players->where('name', 'Raphaël Varane')->first()->id,
            'team_id' => $man_utd->id,
            'minute' => 90,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => 'red card',
            'player_id' => $man_utd->players->where('name', 'Raphaël Varane')->first()->id,
            'team_id' => $man_utd->id,
            'minute' => 90,
        ]);
        Event::create([
            'game_id' => $today_pl_game_1->id,
            'event_type' => EventType::FINAL_WHISTLE->value,
            'minute' => 94,
        ]);

        Result::create([
            'game_id' => $yesterday_pl_game_1->id,
            'home_team_id' => $man_city->id,
            'away_team_id' => $liverpool->id,
            'home_score' => 2,
            'away_score' => 2,
        ]);

        Result::create([
            'game_id' => $yesterday_lpt_game_1->id,
            'home_team_id' => $porto->id,
            'away_team_id' => $sporting->id,
            'home_score' => 0,
            'away_score' => 2,
        ]);

        Result::create([
            'game_id' => $today_pl_game_1->id,
            'home_team_id' => $man_utd->id,
            'away_team_id' => $man_city->id,
            'home_score' => 1,
            'away_score' => 4,
        ]);

        Result::create([
            'game_id' => $today_lpt_game_1->id,
            'home_team_id' => $braga->id,
            'away_team_id' => $sporting->id,
            'home_score' => 2,
            'away_score' => 5,
        ]);

        Result::create([
            'game_id' => $today_lpt_game_2->id,
            'home_team_id' => $benfica->id,
            'away_team_id' => $porto->id,
            'home_score' => 4,
            'away_score' => 4,
        ]);

        Result::create([
            'game_id' => $tomorrow_pl_game_1->id,
            'home_team_id' => $liverpool->id,
            'away_team_id' => $man_utd->id,
        ]);

        Result::create([
            'game_id' => $tomorrow_lpt_game_1->id,
            'home_team_id' => $braga->id,
            'away_team_id' => $benfica->id,
        ]);
    }
}
