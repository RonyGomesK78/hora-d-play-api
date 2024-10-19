<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('season_competitions', function (Blueprint $table) {
            $table->foreignUuid('team_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('competition_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('season_id')->constrained()->onDelete('cascade');

            $table->primary(['team_id', 'competition_id', 'season_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('season_competitions');
    }
};
