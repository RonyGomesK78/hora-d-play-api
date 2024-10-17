<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerGame extends Model
{
    /** @use HasFactory<\Database\Factories\PlayerGameFactory> */
    use HasFactory;
    
    protected $fillable = [
        'game_id',
        'player_id',
    ];

    public $incrementing = false;  // No auto-incrementing ID
    protected $primaryKey = ['game_id', 'player_id'];  // Composite primary key
}
