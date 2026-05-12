<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Referee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'role',
        'is_active',
        'country_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active'  => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Relación inversa: un árbitro pertenece a un país
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // Relación M:M con partidos
    public function matches(): BelongsToMany
    {
        return $this->belongsToMany(Match::class, 'match_referee')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
