<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory, Uuid;

    protected $fillable = [
        'name',
        'founded'
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
