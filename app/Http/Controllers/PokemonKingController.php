<?php

namespace App\Http\Controllers;

use App\PokemonProfiles;
use Illuminate\Http\Request;

class PokemonKingController extends Controller
{
    /**
     * Respond the pokemon king
     * @return JSON response
     */
    public function show()
    {
        $result = PokemonProfiles::findKing();

        if ($result) {
            return response()->json([
                'king' => $result['king'],
                'score' => $result['score']
            ]);
        }

        return response()->json(
            [
                'error' => 'King not found'
            ],
            404
        );
    }
}
