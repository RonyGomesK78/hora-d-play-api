<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeasonCompetition>
 */
class SeasonCompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'season_id' => Season::factory(),
            'competition_id' => Competition::factory(),
            'team_id' => Team::factory(),
        ];
    }
}
