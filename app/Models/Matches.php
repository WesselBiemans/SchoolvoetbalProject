<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{

    protected $fillable = [
        'team_1_id',
        'team_2_id',
        'tournament_id',
        'team_1_score',
        'team_2_score',
        'match_date',
    ];


    public function team1()
    {
        return $this->belongsTo(Teams::class, 'team_1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Teams::class, 'team_2_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
