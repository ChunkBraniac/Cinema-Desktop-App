<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Top10;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{
    //
    public function fetchMovies()
    {
        $client = new Client();

        $response = $client->request('GET', 'https://imdb188.p.rapidapi.com/api/v1/getWeekTop10', [
            'headers' => [
                'X-RapidAPI-Host' => 'imdb188.p.rapidapi.com',
                'X-RapidAPI-Key' => '5db32b6427msh63a3feac22d80eep1c836bjsn20a1f588f218',
            ],
        ]);

        $movieData = json_decode($response->getBody(), true);

        $moviesToSave = [];

        if (isset($movieData['data'])) {
            foreach ($movieData['data'] as $movie) {
                $existingMovie = Top10::where('movieId', $movie['id'])->first();
                $carbon = Carbon::createFromTimestamp($movie['titleRuntime']['seconds'] ?? 0);

                if (!$existingMovie) {
                    $movieToSave = [
                        'movieId' => $movie['id'],
                        'originalTitleText' => $movie['originalTitleText']['text'],
                        'isAdult' => $movie['isAdult'],
                        'isRatable' => $movie['canRateTitle']['isRatable'],
                        'imageUrl' => $movie['primaryImage']['imageUrl'],
                        'aggregateRating' => $movie['ratingsSummary']['aggregateRating'] ?? 0,
                        'releaseYear' => $movie['releaseYear']['year'],
                        'titleType' => $movie['titleType']['text'],
                        'isSeries' => $movie['titleType']['isSeries'],
                        'plotText' => $movie['plot']['plotText']['plainText'],
                        'country' => $movie['releaseDate']['country']['text'],

                        // converting the time to a more readable format
                        'runtime' => $carbon->toTimeString(),

                        'genres' => '0',
                        'trailer' => '0',
                    ];

                    $moviesToSave[] = $movieToSave;
                }
            }
        }

        if (!empty($moviesToSave)) {
            Top10::insert($moviesToSave);

            echo "Movies fetch successfully";
        } else {
            echo "Movies already exist";
        }
    }
}
