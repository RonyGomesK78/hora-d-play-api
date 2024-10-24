<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory, Uuid;

    protected $fillable = [
        'game_id',
        'player_id',
        'team_id',
        'event_type',
        'minute',
        'description'
    ];
}
