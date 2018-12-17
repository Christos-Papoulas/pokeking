<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">


        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <style type="text/css">
            .table > tbody > tr > td {
               vertical-align: middle;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Pokemons</h1>
            <div class="row" style="width: 100%;">
                {{ $links }}
            </div>
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Base experience</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>Image</th>
                </thead>
                <tbody>
                @foreach ($pokemonProfiles as $pokemonProfile)
                    @php
                        $profile = json_decode($pokemonProfile->profile);
                    @endphp
                    <tr>
                        <td>{{ $pokemonProfile->pokemon->name }}</td>
                        <td>{{ $profile->base_experience }}</td>
                        <td>{{ $profile->height }}</td>
                        <td>{{ $profile->weight }}</td>
                        <td><img src="{{ $profile->sprites->front_default }}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
