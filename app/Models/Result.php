<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    /** @use HasFactory<\Database\Factories\ResultFactory> */
    use HasFactory, Uuid;

    protected $fillable = [
        'game_id',
        'home_team_id',
        'away_team_id',
        'home_score',
        'away_score',
    ];
}
