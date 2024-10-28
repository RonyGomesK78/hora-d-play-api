<?php

namespace Database\Seeders;

use App\Traits\DatabaseSeederTrait;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    use DatabaseSeederTrait;

    public function run(): void
    {
        $this->seed_competitons_teams_and_results();
    }
}
