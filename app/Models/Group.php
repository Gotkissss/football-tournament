<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = [
        'name',
        'tournament_id',
    ];

    // Relación inversa: un grupo pertenece a un torneo
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    // Relación M:M con equipos (a través de group_team)
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'group_team')
                    ->withPivot(['played', 'won', 'drawn', 'lost', 'goals_for', 'goals_against', 'points'])
                    ->withTimestamps()
                    ->orderByPivot('points', 'desc');
    }

    // Un grupo tiene muchos partidos (fase de grupos)
    public function matches(): HasMany
    {
        return $this->hasMany(Match::class);
    }
}
