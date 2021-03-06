<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pokemons extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url'
    ];

    public function profile()
    {
        return  $this->hasOne(PokemonProfiles::class, 'pokemon_id');
    }
}
