<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'position',
        'jersey_number',
        'height_cm',
        'weight_kg',
        'photo_url',
        'is_active',
        'country_id',
        'team_id',
    ];

    protected $casts = [
        'birth_date'   => 'date',
        'height_cm'    => 'float',
        'weight_kg'    => 'float',
        'jersey_number'=> 'integer',
        'is_active'    => 'boolean',
    ];

    // Nombre completo como accessor
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Relación inversa: un jugador pertenece a un equipo
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    // Relación inversa: un jugador tiene una nacionalidad (país)
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // Relación: un jugador anota muchos goles
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    // Relación: un jugador recibe muchas tarjetas
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
