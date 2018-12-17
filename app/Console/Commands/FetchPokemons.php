<?php

namespace App\Console\Commands;

use App\Pokemons;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\ClientException;

class FetchPokemons extends Command
{
    /**
     * The API base url
     *
     * @var string
     */
    protected $pokemonUrl = 'http://pokeapi.co/api/v2/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pokemon:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves all pokemons and store them to database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Fetching Pokemons...');
        $this->fetchingPokemons($this->pokemonUrl. 'pokemon');
        $this->info('Pokemons stored successfully!');

    }

    /**
     * A recursive function that iterates over the pages and fetching the
     * pokemons.
     *
     * @param  string $url The Url to retrieve
     * @return void
     */
    protected function fetchingPokemons($url)
    {
        $client = new Client();
        try {
            $pokemonsResponse = json_decode($client->get($url)->getBody());
        } catch (ClientException $e) {
            $this->error('Error when retrieving pokemons with status:'. $e->getMessage());
            exit(1);
        }

        $this->info("Retrieved {$pokemonsResponse->count} pokemons!");

        foreach ($pokemonsResponse->results as $pokemon) {
            Pokemons::insert([
                'name' => $pokemon->name,
                'url' => $pokemon->url
            ]);
        }

        if ($pokemonsResponse->next) {
            $this->fetchingPokemons($pokemonsResponse->next);
        }
    }
}
