<?php

namespace Database\Seeders;

use App\Models\Competition;
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
        Competition::factory()->create();

        $season = Season::factory()->create();
        
        Team::factory()->count(5)->create();
        // For each team, create 20 players
        Team::all()->each(function (Team $team) use ($season){
            Player::factory()->count(20)->create([
                'team_id' => $team->id,
            ]);

            SeasonCompetition::factory()->count(1)->create([
                'team_id' => $team->id,
                'season_id' => $season->id,
            ]);
        });

        Game::factory()->count(4)->create();

        Game::all()->each(function (Game $game) {
            // Get two random teams for this game
            $teams = Team::inRandomOrder()->take(2)->get();
        
            // Assign players from both teams to the game
            $teams->each(function (Team $team) use ($game) {
                // For each player in the team, assign them to the game
                $team->players->each(function (Player $player) use ($game) {
                    PlayerGame::factory()->create([
                        'game_id' => $game->id,
                        'player_id' => $player->id,
                    ]);
                });
            });
        });

        Result::factory()->count(2)->create();
    }
}
