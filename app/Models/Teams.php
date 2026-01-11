<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    protected $fillable = [
        'name',
        'created_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function players()
    {
        return $this->hasMany(players::class, 'team_id');
    }

    public function tournaments()
    {
        return $this->belongsToMany(
            Tournament::class,
            'teams_tournament',
            'team_id',
            'tournament_id'
        );
    }
}
