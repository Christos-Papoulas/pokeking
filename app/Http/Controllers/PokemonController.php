<?php

namespace App\Http\Controllers;

use App\Pokemons;
use App\PokemonProfiles;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PokemonController extends Controller
{
    /**
     * Return a view with all pokemons that have profile.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page = 0;
        if (request()->page) {
            $page = request()->page - 1;
        }

        $count = PokemonProfiles::count();
        $perPage = 6;
        $offset = $page * $perPage + $perPage > $count ?
            $count - $page * $perPage :
            $perPage;

        // Use pagination with custom slice on the collections
        $pokemonProfiles = PokemonProfiles::with('pokemon')->get()
            ->sortByDesc(function ($item) {
                return json_decode($item->profile)->weight;
            })->slice(
                $page * $perPage,
                $offset
            );

        return view(
            'index',
            [
                'pokemonProfiles' => $pokemonProfiles,
                'links' => PokemonProfiles::paginate($perPage)->links()
            ]
        );
    }
}
