<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Confederation extends Model
{
    protected $fillable = [
        'name',
        'acronym',
        'region',
        'logo_url',
    ];

    // Relación: una confederación tiene muchos países
    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }

    // Relación: una confederación organiza muchos torneos
    public function tournaments(): HasMany
    {
        return $this->hasMany(Tournament::class);
    }
}
