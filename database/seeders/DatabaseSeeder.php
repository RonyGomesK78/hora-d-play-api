<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\PlayerGame;
use App\Models\Result;
use App\Models\Season;
use App\Models\SeasonCompetition;
use App\Models\Team;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

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
                "Sporting CP",
                "Braga",
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

        $season = Season::create([
            "year" => "24/25"
        ]);

        Game::factory()->count(10)->create();

        // Create competitions and teams, and link them
        foreach (array_keys($competition_teams) as $competition_name) {
            // Create a competition
            $competition = Competition::create(['name' => $competition_name]);

            foreach ($competition_teams[$competition_name] as $team_name) {
                // Create or get the team by name to prevent duplication
                $team = Team::firstOrCreate(['name' => $team_name], [
                    'founded' => fake()->date(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Now create the SeasonCompetition relationship
                // Assuming you have a season with ID 1, or you can create one as needed
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

        // Populate the result table with 10 games
        $games = Game::all();

        foreach ($games as $game) {
            // Select a competition
            $competition = SeasonCompetition::inRandomOrder()->first();

            // Get two random teams from the same competition
            $teams = SeasonCompetition::where('competition_id', $competition->competition_id)
                ->where('season_id', $competition->season_id)
                ->inRandomOrder()
                ->take(2)
                ->get();

            $home_team = $teams->first();
            $away_team = $teams->last();

            $home_team_players = Team::where('id', $home_team->team_id)->first()->players;
            $away_team_players = Team::where('id', $away_team->team_id)->first()->players;

            // add players to the game
            foreach ($home_team_players as $player) {
                PlayerGame::create([
                    'game_id' => $game->id,
                    'player_id' => $player->id
                ]);

            }
            foreach ($away_team_players as $player) {
                PlayerGame::create([
                    'game_id' => $game->id,
                    'player_id' => $player->id
                ]);
            }

            $home_team_player = $home_team_players->first();

            if ($home_team_player) {
                $events = ["foul", "yellow card", "red card", "Injury"];
                Event::create([
                    'game_id' => $game->id,
                    'player_id' => $home_team_player->id,
                    'team_id' => $home_team->team_id,
                    'event_type' => $events[array_rand($events)],
                    'minute' => random_int(1, 90),
                ]);
            } else {
                $events = ["start", "interval", "end", "cancelled"];
                // Optionally, insert an event without a player
                Event::create([
                    'game_id' => $game->id,
                    'player_id' => null,
                    'team_id' => null,
                    'event_type' => $events[array_rand($events)],
                ]);
            }

            $away_team_player = $away_team_players->first();

            if ($away_team_player) {
                $events = ["foul", "yellow card", "red card", "Injury"];
                Event::create([
                    'game_id' => $game->id,
                    'player_id' => $away_team_player->id,
                    'team_id' => $away_team->team_id,
                    'event_type' => $events[array_rand($events)],
                    'minute' => random_int(1, 90),
                ]);

                Event::create([
                    'game_id' => $game->id,
                    'player_id' => $away_team_player->id,
                    'team_id' => $away_team->team_id,
                    'event_type' => $events[array_rand($events)],
                    'minute' => random_int(1, 90),
                ]);
            } else {
                $events = ["start", "interval", "end", "cancelled"];
                // Optionally, insert an event without a player
                Event::create([
                    'game_id' => $game->id,
                    'player_id' => null,
                    'team_id' => null,
                    'event_type' => $events[array_rand($events)],
                ]);
            }

            $home_score = rand(0, 5);
            $away_score = rand(0, 5);

            // Create a result for this game
            Result::create([
                'game_id' => $game->id,
                'home_team_id' => $home_team->team_id,
                'away_team_id' => $away_team->team_id,
                'home_score' => $home_score,
                'away_score' => $away_score,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
