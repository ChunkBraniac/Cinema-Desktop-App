<?php

namespace App\Jobs;

use App\Models\Movies;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateMoviesTrailerV2 implements ShouldQueue
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

        $apiKey = 'AIzaSyCUoGQhYzTPCkjEpYZvgyoFHqngLwibFiI';

        // Fetch movies that don't have trailers
        $noTrailer = Movies::where('trailer', '')->get();

        if (count($noTrailer) > 0) {
            foreach ($noTrailer as $nonTrailer) {
                $movieName = $nonTrailer->full_name;
                $id = $nonTrailer['id'];

                // Set parameters for the API request
                $params = [
                    'q' => $movieName.' trailer',
                    'type' => 'video',
                    'maxResults' => 1, // Ensures only one result is fetched
                    'key' => $apiKey,
                ];

                // Make the API request
                $apiUrl = 'https://www.googleapis.com/youtube/v3/search?'.http_build_query($params);
                $response = file_get_contents($apiUrl);
                $data = json_decode($response, true);

                // Display the results
                if (! empty($data['items'])) {
                    $videoTrailer = 'https://www.youtube.com/embed/'.$data['items'][0]['id']['videoId'];

                    // Update the database with the trailer
                    $nonTrailer->trailer = $videoTrailer;
                    $nonTrailer->save();

                    echo 'Trailer updated for '.$nonTrailer->full_name."\n";
                }
            }
        } else {
            echo 'No empty trailer field found';
        }
    }
}
