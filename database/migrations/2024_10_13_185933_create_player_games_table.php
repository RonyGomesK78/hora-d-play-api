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
        Schema::create('player_games', function (Blueprint $table) {
            $table->foreignUuid('game_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('player_id')->constrained()->onDelete('cascade');

            // Composite primary key using both game_id and player_id
            $table->primary(['game_id', 'player_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_games');
    }
};
