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
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6 text-center">
                    <button id="find_king" type="button" class="btn btn-dark btn-lg">
                        Find the king
                    </button>

                    <div class="alert alert-danger mt-3 d-none" role="alert" id='king-alert'>
                      The king is
                      <span id="king-name" class="text-capitalize font-weight-bold">
                      </span>
                      with a total stat values:
                      <span id="king-stats" class="font-weight-bold"></span>.
                    </div>
                </div>
            </div>

        </div>

        <script
              src="https://code.jquery.com/jquery-3.3.1.min.js"
              integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
              crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
