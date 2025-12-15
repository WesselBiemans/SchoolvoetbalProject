<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamsTournaments extends Model
{
    protected $fillable = [
        'team_id',
        'tournament_id'
    ];

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
