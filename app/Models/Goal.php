<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    protected $fillable = [
        'match_id',
        'player_id',
        'team_id',
        'minute',
        'extra_minute',
        'type',
        'is_extra_time',
    ];

    protected $casts = [
        'minute'        => 'integer',
        'extra_minute'  => 'integer',
        'is_extra_time' => 'boolean',
    ];

    // Relación inversa: un gol pertenece a un partido
    public function match(): BelongsTo
    {
        return $this->belongsTo(Match::class);
    }

    // Relación inversa: un gol fue anotado por un jugador
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    // Relación inversa: un gol fue anotado para un equipo
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
