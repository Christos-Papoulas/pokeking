<?php

namespace App\Console\Commands;

use App\Pokemons;
use GuzzleHttp\Client;
use App\PokemonProfiles;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\ClientException;

class FetchPokemonProfiles extends Command
{
    /**
     * The client for the HTTP requests.
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * The threashold for storing the pokemon profile.
     *
     * @var int
     */
    protected $heightThreshold = 50;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pokemon:fetchProfiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches all pokemons that have height greater or equal to 50 and their sprite exists.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Fetching pokemons\' profiles...');

        $pokemons = Pokemons::all();

        foreach ($pokemons as $pokemon) {
            $profileData = $this->fetchProfileData($pokemon->url);
            $this->info('Checking '. $pokemon->name);
            if ($this->shouldBeStored($profileData)) {
                $this->info('Storing information for '. $pokemon->name);
                $this->storePokemonProfile(
                    $pokemon,
                    json_encode($profileData)
                );
            }
        }

        $this->info('Pokemons profiles fetched succesfully');
    }

    /**
     * * Fetch the profile data for the pokemon.
     *
     * @param  string $pokemonUrl The pokemon url.
     * @return stdObject
     */
    protected function fetchProfileData($pokemonUrl)
    {
        try {
            return json_decode($this->client->get($pokemonUrl)->getBody());
        } catch (ClientException $e) {
            $this->error('Error when retrieving pokemons with status:'. $e->getMessage());
            exit(1);
        }
    }

    /**
     * Check if the profile should be stored to db.
     *
     * @param  stdObject $pokemon
     * @return bool
     */
    protected function shouldBeStored($pokemon)
    {
        return $pokemon->height >= $this->heightThreshold
            && $pokemon->sprites
            && $pokemon->sprites->front_default;
    }


    /**
     * Store the pokemon profile to database
     *
     * @param  App\Pokemon $pokemon   The pokemon
     * @param  string $profile The profile of the pokemon
     * @return void
     */
    protected function storePokemonProfile($pokemon, $profile)
    {
        $pokemon->profile()->save(
            new PokemonProfiles(compact('profile'))
        );
    }
}
