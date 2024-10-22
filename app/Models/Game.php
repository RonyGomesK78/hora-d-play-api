<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory, Uuid;

    protected $fillable = [
        'date',
        'location',
        'season_id',
        'competition_id'
    ];

    public function players() {
        return $this->belongsToMany(Player::class, 'player_games', 'game_id', 'player_id');
    }
}
