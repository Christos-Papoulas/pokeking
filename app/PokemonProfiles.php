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

    public static function findKing()
    {
        $pokemonProfiles = PokemonProfiles::all();

        $score = 0;
        $kingId = null;
        foreach ($pokemonProfiles as $pokemonProfile) {
            $total = 0;
            $jsonProfile = json_decode($pokemonProfile->profile);

            foreach ($jsonProfile->stats as $stat) {
                $total += $stat->base_stat;
            }

            if ($score < $total) {
                $score = $total;
                $kingId = $pokemonProfile->pokemon_id;
            }
        }

        if (! $kingId) {
            return null;
        }

        $king = Pokemons::find($kingId);

        return compact(['king', 'score']);
    }
}
