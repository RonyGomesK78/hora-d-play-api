<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuid;

class Player extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerFactory> */
    use HasFactory, Uuid;

    protected $fillable = [
        'name',
        'birthdate',
        'team_id',
    ];

    public function games() {
        return $this->belongsToMany(Game::class, 'player_games', 'player_id', 'game_id');
    }
}
