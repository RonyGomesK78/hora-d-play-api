<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonCompetition extends Model
{
    /** @use HasFactory<\Database\Factories\SeasonCompetitionFactory> */
    use HasFactory;

    protected $fillable = [
        'season_id',
        'competition_id',
        'team_id',
    ];

    public $incrementing = false;  // No auto-incrementing ID
    protected $primaryKey = ['season_id', 'competition_id', 'team_id'];  // Composite primary key
}
