<?php

namespace App\Jobs;

use App\Models\Movies;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchMovieData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        ini_set('max_execution_time', 900); // Set the max execution time to 5 minutes
        ini_set('memory_limit', '500M');

        // Give a custom page number
        // Also give a custom date
        $page = 1;
        $date = date('Y-m-d');

        do {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/account/20553054/favorite/movies?language=en-US&page={$page}&sort_by=created_at.asc",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxMTg4ZDY3NDI1ZmJiN2VhYjIzNWViMDM4NTQyYjY0ZiIsInN1YiI6IjY1MjU3Y2FhMDcyMTY2NDViNDAwMTVhOCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.GaTStrEdn0AWqdlwpzn75h8vo_-X5qoOxVxZEEBYJXc",
                    "accept: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                // Handle error
                echo $err;
                break;
            }

            $data = json_decode($response, true);

            // Check if the results key exists and has more than one item
            if (isset($data['results']) && is_array($data['results']) && count($data['results']) > 0) {
                foreach ($data['results'] as $result) {
                    $release_date = isset($result['release_date']) ? $result['release_date'] : 0;
                    $year = substr($release_date, 0, 4); // Extract the first four characters
                    $full_name = $result['title'];

                    if ($year >= '2018' && $release_date <= $date && $year <= '2024') {
                        $id = $result['id'];

                        // Check if the movie is already in the database. If not, add it
                        $fetch = Movies::where('movieId', $id)->first();

                        if (!$fetch) {
                            $adult = $result['adult'];
                            $backdrop_path = isset($result['backdrop_path']) ? $result['backdrop_path'] : 0;
                            $language = strtoupper($result['original_language']);
                            $full_name = $result['title'];
                            $name = $result['title'] . ' ' . $year . ' download';
                            $overview = $result['overview'];
                            $poster_path = $result['poster_path'];
                            $vote_average = $result['vote_average'];

                            $base_url = $poster_path ? "https://image.tmdb.org/t/p/w780" . $poster_path : "";
                            $formatted_name = str_replace(' ', '-', $name);
                            $rating = floor($vote_average * 10) / 10;

                            Movies::create([
                                'movieId' => $id,
                                'isAdult' => $adult,
                                'full_name' => $full_name,
                                'originalTitleText' => $formatted_name,
                                'imageUrl' => $base_url,
                                'backdrop_path' => $backdrop_path,
                                'country' => '',
                                'language' => $language,
                                'plotText' => $overview,
                                'releaseDate' => $release_date,
                                'releaseYear' => $year,
                                'aggregateRating' => $rating,
                                'titleType' => 'movie',
                                'runtime' => '',
                                'genres' => '',
                                'trailer' => '',
                                'download_url' => '',
                                'status' => 'pending',
                                'created_at' => Carbon::now(),
                            ]);

                            echo $full_name . " - has been added successfully \n";

                            // Dispatch the UpdateMoviesTrailer job
                        } else {
                            echo $full_name . " - already in database \n";
                        }
                    } else {
                        echo $full_name . " - not in range \n";
                    }
                }
            } else {
                // No more results, stop the loop
                break;
            }

            // Check if there are more pages to fetch
            if (!isset($data['total_pages']) || $page >= $data['total_pages']) {
                break;
            }

            $page++;
        } while (true);
    }
}
