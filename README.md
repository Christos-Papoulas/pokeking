# PokeKing App

## How to install PokeKing App

- clone the repository
- cd pokeking
- composer install
- cp .env.example .env
- Edit the .env and add the database configuration
- Run: `php artisan migrate`

We are ready to go.

## Populate the app with data

- Run the following command to populate the pokemons table with data: 

```bash
php artisan pokemon:fetch
php artisan pokemon:fetchProfiles
```

