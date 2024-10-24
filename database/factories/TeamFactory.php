<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teams = [
            // Liga Portuguesa
            "Benfica",
            "Porto",
            "Sporting CP",
            "Braga",
            "Belenenses",

            // Premier League
            "Manchester United",
            "Liverpool",
            "Chelsea",
            "Arsenal",
            "Manchester City",

            // La Liga
            "Barcelona",
            "Real Madrid",
            "Atletico Madrid",
            "Sevilla",
            "Valencia",

            // Serie A
            "Juventus",
            "AC Milan",
            "Inter Milan",
            "Napoli",
            "AS Roma",

            // Campeonato de São Vicente
            "Mindelenese",
            "Derby",
            "Academica",
            "Batuque",
            "Amarante"
        ];

        return [
            'name' => fake()->unique()->randomElement($teams),
            'founded' => fake()->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
