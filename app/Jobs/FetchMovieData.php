<?php

namespace App\Jobs;

use App\Models\Movies;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
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
                CURLOPT_URL => "https://api.themoviedb.org/3/account/20553054/favorite/movies?language=en-US&page={$page}&sort_by=created_at.desc",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxMTg4ZDY3NDI1ZmJiN2VhYjIzNWViMDM4NTQyYjY0ZiIsInN1YiI6IjY1MjU3Y2FhMDcyMTY2NDViNDAwMTVhOCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.GaTStrEdn0AWqdlwpzn75h8vo_-X5qoOxVxZEEBYJXc',
                    'accept: application/json',
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                // Handle error
                echo $err . "\n";
                break;
            }

            $data = json_decode($response, true);

            // Check if the results key exists and has more than one item
            // Check if 'results' exists in $data, is an array, and has at least one element
            if (isset($data['results']) && is_array($data['results']) && count($data['results']) > 0) {

                // Iterate over each result in 'results' array
                foreach ($data['results'] as $result) {

                    // Get the release date if it exists, otherwise default to 0
                    $release_date = isset($result['release_date']) ? $result['release_date'] : 0;

                    // Extract the year from the release date
                    $year = substr($release_date, 0, 4);

                    // Get the full name of the movie
                    $full_name = $result['title'];

                    // Get the movie ID
                    $id = $result['id'];

                    // Check if the movie is already in the database
                    $fetch = Movies::where('movieId', $id)->first();

                    // If the movie is not in the database, add it
                    if (!$fetch) {

                        // Extract and prepare movie details
                        $adult = $result['adult'];
                        $backdrop_path = isset($result['backdrop_path']) ? $result['backdrop_path'] : 0;
                        $language = strtoupper($result['original_language']);
                        $overview = $result['overview'];
                        $poster_path = $result['poster_path'];
                        $vote_average = $result['vote_average'];
                        $base_url = 'https://image.tmdb.org/t/p/w780' . $poster_path;

                        // Format the name for storage
                        $name = $result['title'] . ' ' . $year . ' download';
                        $formatted_name = preg_replace('/[^a-zA-Z0-9 ]/', '', $name);
                        $formatted_name2 = preg_replace('/\s+/', '-', $formatted_name);
                        $formatted_name3 = trim(Str::lower($formatted_name2), '-');

                        // Round the vote average to one decimal place
                        $rating = floor($vote_average * 10) / 10;

                        // Download the movie poster image
                        $url = $base_url;
                        $contents = file_get_contents($url);
                        $image_name = basename($url);
                        $path = 'public/images/' . $image_name;

                        // Check if the image already exists in storage, if not, save it
                        if (!Storage::exists($path)) {
                            Storage::put($path, $contents);
                        }

                        // Create a new movie record in the database
                        Movies::create([
                            'movieId' => $id,
                            'isAdult' => $adult,
                            'full_name' => $full_name,
                            'originalTitleText' => $formatted_name3,
                            'imageUrl' => $image_name,
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
                            'created_at' => Carbon::now()->format('Y-m-d'),
                        ]);

                        // Output a success message
                        echo $full_name . " - has been added successfully \n";

                        // Optionally, dispatch the UpdateMoviesTrailer job here
                    } else {
                        // Output a message indicating the movie is already in the database
                        echo $full_name . " - already in database \n";
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
