<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'flag_url',
        'confederation_id',
    ];

    // Relación inversa: un país pertenece a una confederación
    public function confederation(): BelongsTo
    {
        return $this->belongsTo(Confederation::class);
    }

    // Relación: un país tiene muchos equipos
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    // Relación: un país tiene muchos jugadores (por nacionalidad)
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    // Relación: un país tiene muchos estadios
    public function stadiums(): HasMany
    {
        return $this->hasMany(Stadium::class);
    }

    // Relación: un país tiene muchos árbitros
    public function referees(): HasMany
    {
        return $this->hasMany(Referee::class);
    }
}
