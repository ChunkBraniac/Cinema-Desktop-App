<?php

namespace App\Jobs;

use App\Models\Seasons;
use App\Models\Series;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class getSeasons implements ShouldQueue
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
        ini_set('max_execution_time', 90000); // Set the max execution time to 5 minutes
        ini_set('memory_limit', '50000M');

        $fetch = Series::where('titleType', 'series')->where('status', 'approved')->get();

        $seasons = range(1, 10);

        if (count($fetch) > 0) {
            foreach ($fetch as $data_info) {
                $movie_id = $data_info->movieId;
                $movie_name = $data_info->originalTitleText;
                $movie_type = $data_info->titleType;
                $movie_image = $data_info->imageUrl;
                $full_name = $data_info->full_name;

                // foreach ($seasons as $season) {

                // }

                foreach ($seasons as $season) {
                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL => "https://api.themoviedb.org/3/tv/{$movie_id}/season/{$season}?language=en-US",
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
                        echo 'cURL Error #:'.$err;

                        continue;
                    }

                    $data = json_decode($response, true);

                    if (isset($data['episodes']) && is_array($data['episodes']) && count($data['episodes']) > 0) {

                        if ($data['air_date'] == null) {
                            echo 'Air date not available for '.$full_name."\n";
                        } else {

                            // season image
                            $poster_path = isset($data['poster_path']) ? $data['poster_path'] : null;
                            $base_url = 'https://image.tmdb.org/t/p/w780'.$poster_path;

                            // Downloading the image
                            $url = $base_url;
                            $contents = file_get_contents($url);

                            // Saving the image to the storage folder
                            $image_name = basename($url);
                            $path = 'public/uploads/'.$image_name;

                            if (Storage::exists($path)) {
                                // do nothing
                            } else {
                                Storage::put($path, $contents);
                            }

                            foreach ($data['episodes'] as $episode) {
                                $air_date = isset($episode['air_date']) ? $episode['air_date'] : 0;
                                $episode_number = $episode['episode_number'];
                                $season_number = $episode['season_number'];

                                $fetch_old = Seasons::where('movieName', $movie_name)
                                    ->where('episode_number', $episode_number)
                                    ->where('season_number', $season_number)
                                    ->first();

                                if (! $fetch_old) {
                                    Seasons::create([
                                        'movieId' => $movie_id,
                                        'full_name' => $full_name,
                                        'movieName' => $movie_name,
                                        'movieType' => $movie_type,
                                        'season_number' => $season_number,
                                        'episode_number' => $episode_number,
                                        'air_date' => $air_date,
                                        'imageUrl' => $image_name,
                                        'created_at' => Carbon::now(),
                                    ]);

                                    echo $full_name.' Season '.$season_number." Episode \n".$episode_number.' added successfully'."\n";
                                } else {
                                    echo 'Season for '.$full_name.' already in database'."\n";
                                }
                            }
                        }
                    } else {
                        // No more results, stop the loop
                        break;
                    }
                }
            }
        } else {
            echo "No approved series found in the database \n";
        }
    }
}
