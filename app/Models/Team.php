<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'crest_url',
        'primary_color',
        'secondary_color',
        'team_type',
        'country_id',
        'stadium_id',
    ];

    // Relación inversa: un equipo pertenece a un país
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // Relación inversa: un equipo tiene su estadio local
    public function stadium(): BelongsTo
    {
        return $this->belongsTo(Stadium::class);
    }

    // Relación: un equipo tiene muchos jugadores
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    // Relación M:M con grupos (a través de group_team)
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_team')
                    ->withPivot(['played', 'won', 'drawn', 'lost', 'goals_for', 'goals_against', 'points'])
                    ->withTimestamps();
    }

    // Partidos en casa
    public function homeMatches(): HasMany
    {
        return $this->hasMany(Match::class, 'home_team_id');
    }

    // Partidos de visitante
    public function awayMatches(): HasMany
    {
        return $this->hasMany(Match::class, 'away_team_id');
    }

    // Goles anotados por el equipo
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }
}
