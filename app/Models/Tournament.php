<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'type',
        'edition_year',
        'host_country',
        'start_date',
        'end_date',
        'logo_url',
        'is_active',
        'confederation_id',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'is_active'   => 'boolean',
        'edition_year'=> 'integer',
    ];

    // Relación inversa: un torneo pertenece a una confederación (puede ser null para el mundial)
    public function confederation(): BelongsTo
    {
        return $this->belongsTo(Confederation::class);
    }

    // Relación: un torneo tiene muchos grupos
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    // Relación: un torneo tiene muchos partidos
    public function matches(): HasMany
    {
        return $this->hasMany(Match::class);
    }
}
