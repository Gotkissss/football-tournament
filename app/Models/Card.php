<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $fillable = [
        'match_id',
        'player_id',
        'team_id',
        'minute',
        'card_type',
        'reason',
    ];

    protected $casts = [
        'minute' => 'integer',
    ];

    // Relación inversa: una tarjeta ocurre en un partido
    public function match(): BelongsTo
    {
        return $this->belongsTo(Match::class);
    }

    // Relación inversa: una tarjeta pertenece a un jugador
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    // Relación inversa: una tarjeta afecta a un equipo
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
