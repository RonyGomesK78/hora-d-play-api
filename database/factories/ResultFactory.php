<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'home_team_id' => Team::factory(),
            'away_team_id' => Team::factory(),
            'home_score' => fake()->numberBetween(0,5),
            'away_score' => fake()->numberBetween(0,5),
        ];
    }
}
