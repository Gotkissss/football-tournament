<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Match extends Model
{
    protected $table = 'matches'; // tabla reservada en algunos motores

    protected $fillable = [
        'tournament_id',
        'group_id',
        'home_team_id',
        'away_team_id',
        'stadium_id',
        'match_date',
        'stage',
        'home_score',
        'away_score',
        'home_score_extra',
        'away_score_extra',
        'home_score_penalties',
        'away_score_penalties',
        'status',
        'attendance',
    ];

    protected $casts = [
        'match_date'            => 'datetime',
        'home_score'            => 'integer',
        'away_score'            => 'integer',
        'home_score_extra'      => 'integer',
        'away_score_extra'      => 'integer',
        'home_score_penalties'  => 'integer',
        'away_score_penalties'  => 'integer',
        'attendance'            => 'integer',
    ];

    // Relación inversa: un partido pertenece a un torneo
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    // Relación inversa: un partido puede pertenecer a un grupo
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    // Relación inversa: equipo local
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    // Relación inversa: equipo visitante
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    // Relación inversa: estadio donde se juega
    public function stadium(): BelongsTo
    {
        return $this->belongsTo(Stadium::class);
    }

    // Relación: un partido tiene muchos goles
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    // Relación: un partido tiene muchas tarjetas
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    // Relación M:M con árbitros
    public function referees(): BelongsToMany
    {
        return $this->belongsToMany(Referee::class, 'match_referee')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
