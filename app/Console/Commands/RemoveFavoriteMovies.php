<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemoveFavoriteMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-favorite-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all favorite Movies from TMDb';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $api_key = env('TMDB_API_KEY');
        $session_id = env('TMDB_SESSION_ID');

        if (!$api_key || !$session_id) {
            $this->error('TMDB_API_KEY or TMDB_SESSION_ID is not set in the .env file.');
            return 1;
        }

        // get account details
        $accountdetails = $this->getAccountId($api_key, $session_id);

        if (!$accountdetails) {
            $this->error('Failed to find account');
            return 1;
        }

        // get and remove favourite movies
        $favoriteMovies = $this->getFavoriteMovies($accountdetails, $api_key, $session_id);

        if ($favoriteMovies) {
            foreach ($favoriteMovies as $movie) {
                $this->removeFavoriteMovies($accountdetails, $movie->id, $api_key, $session_id);
            }

            $this->info('All favorite movies removed');
        } else {
            $this->info('No favorite movies found');
        }
    }

    private function getAccountId($api_key, $session_id)
    {
        $url = "https://api.themoviedb.org/3/account?api_key={$api_key}&session_id={$session_id}";

        $reponse = $this->curlGet($url);
        return $reponse->id ?? null;
    }

    private function getFavoriteMovies($accountdetails, $api_key, $session_id)
    {
        $url = "https://api.themoviedb.org/3/account/{$accountdetails}/favorite/movies?api_key={$api_key}&session_id={$session_id}";

        $response = $this->curlGet($url);
        return $response->results ?? [];
    }

    private function removeFavoriteMovies($accountdetails, $movieId, $api_key, $session_id)
    {
        $url = "https://api.themoviedb.org/3/account/{$accountdetails}/favorite?api_key={$api_key}&session_id={$session_id}";

        $data = json_encode([
            'media_type' => 'movie',
            'media_id' => $movieId,
            'favorite' => false
        ]);

        $this->curlPost($url, $data);
    }

    private function curlGet($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    private function curlPost($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
