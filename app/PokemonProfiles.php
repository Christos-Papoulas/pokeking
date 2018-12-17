<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PokemonProfiles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pokemon_id',
        'profile'
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemons::class);
    }
}
