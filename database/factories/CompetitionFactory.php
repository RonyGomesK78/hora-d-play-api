<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competition>
 */
class CompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $competition_names = [
            "Campeonato de São Vicente",
            "Liga Portuguesa",
            "Premier League",
            "La Liga",
            "Serie A",
            "Champions League"
        ];

        return [
            "name" => fake()->unique()->randomElement($competition_names),
        ];
    }
}
