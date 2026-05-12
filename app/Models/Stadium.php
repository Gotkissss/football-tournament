<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stadium extends Model
{
    protected $fillable = [
        'name',
        'city',
        'capacity',
        'latitude',
        'longitude',
        'surface',
        'year_built',
        'country_id',
    ];

    protected $casts = [
        'capacity'   => 'integer',
        'latitude'   => 'float',
        'longitude'  => 'float',
        'year_built' => 'integer',
    ];

    // Relación inversa: un estadio pertenece a un país
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // Relación: un estadio tiene muchos equipos locales
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    // Relación: un estadio alberga muchos partidos
    public function matches(): HasMany
    {
        return $this->hasMany(Match::class);
    }
}
