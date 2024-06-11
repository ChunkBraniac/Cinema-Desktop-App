<?php

namespace App\Jobs;

use App\Models\Series;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class FetchSeriesData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('max_execution_time', 900); // Set the max execution time to 5 minutes
        ini_set('memory_limit', '500M');

        $pages = 1;
        $date = date('Y-m-d');

        do {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/account/20553054/favorite/tv?language=en-US&page={$pages}&sort_by=created_at.asc",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
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
                echo $err . "\n";

                break;
            }

            $data = json_decode($response, true);

            if (isset($data['results']) && is_array($data['results']) && count($data['results']) > 0) {
                foreach ($data['results'] as $result) {
                    $first_air_date = $result['first_air_date'];
                    $year = substr($first_air_date, 0, 4); // Extract the first four characters
                    $full_name = $result['name'];

                    $id = $result['id'];

                    // Check if the series is already in the db
                    $fetch = Series::where('movieId', $id)->first();

                    if (!$fetch) {
                        $adult = isset($result['adult']) ? $result['adult'] : false;
                        $backdrop_path = isset($result['backdrop_path']) ? $result['backdrop_path'] : 'false';
                        $country = isset($result['origin_country'][0]) ? $result['origin_country'][0] : null;
                        $language = strtoupper($result['original_language']);
                        $overview = $result['overview'];
                        $poster_path = $result['poster_path'];
                        $vote_average = $result['vote_average'];

                        $base_url = 'https://image.tmdb.org/t/p/w780' . $poster_path;

                        $formatted_name = str_replace(' ', '-', $result['name'] . ' ' . $year . ' download');
                        $rating = floor($vote_average * 10) / 10;

                        // Downloading the image and saving it to the storage folder
                        $url = $base_url;
                        $contents = file_get_contents($url);

                        $image_name = basename($url);
                        $path = 'public/images/' . $image_name;

                        if (Storage::exists($path)) {
                            // do nothing
                        } else {
                            Storage::put($path, $contents);
                        }

                        Series::create([
                            'movieId' => $id,
                            'isAdult' => $adult,
                            'full_name' => $full_name,
                            'originalTitleText' => $formatted_name,
                            'imageUrl' => $image_name,
                            'backdrop_path' => $backdrop_path,
                            'country' => $country,
                            'language' => $language,
                            'plotText' => $overview,
                            'releaseDate' => $first_air_date,
                            'releaseYear' => $year,
                            'aggregateRating' => $rating,
                            'titleType' => 'series',
                            'runtime' => '',
                            'genres' => '',
                            'trailer' => '',
                            'status' => 'pending',
                            'created_at' => Carbon::now(),
                        ]);

                        echo $full_name . " - has been added to database \n";
                    } else {
                        echo $full_name . " - already in database \n";
                    }
                }
            } else {
                // No more results, stop the loop
                break;
            }

            // Check if there are more pages to fetch
            if (!isset($data['total_pages']) || $pages >= $data['total_pages']) {
                break;
            }

            $pages++;
        } while (true);
    }
}
