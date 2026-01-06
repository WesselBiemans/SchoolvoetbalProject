<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function teams()
    {
        return $this->belongsToMany(Teams::class, 'teams_tournaments', 'tournament_id', 'team_id');
    }

    public function matches()
    {
        return $this->hasMany(Matches::class, 'tournament_id');
    }
}
