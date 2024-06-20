<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemoveFavoriteTvShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:remove-favorite-tv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all favorite TV shows from TMDb';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apiKey = env('TMDB_API_KEY');
        $sessionId = env('TMDB_SESSION_ID');

        if (! $apiKey || ! $sessionId) {
            $this->error('TMDB_API_KEY or TMDB_SESSION_ID is not set in the .env file.');

            return 1;
        }

        // Step 1: Get Account Details
        $accountId = $this->getAccountId($apiKey, $sessionId);
        if (! $accountId) {
            $this->error('Failed to get account ID.');

            return 1;
        }

        // Step 2: Get and Remove Favorite TV Shows
        $favoriteTvShows = $this->getFavoriteTvShows($accountId, $apiKey, $sessionId);
        if ($favoriteTvShows) {
            foreach ($favoriteTvShows as $tvShow) {
                $this->removeFavoriteTvShow($accountId, $tvShow->id, $apiKey, $sessionId);
            }
            $this->info('All favorite TV shows have been removed.');
        } else {
            $this->info('No favorite TV shows found.');
        }

        return 0;
    }

    private function getAccountId($apiKey, $sessionId)
    {
        $url = "https://api.themoviedb.org/3/account?api_key={$apiKey}&session_id={$sessionId}";

        $response = $this->curlGet($url);

        return $response->id ?? null;
    }

    private function getFavoriteTvShows($accountId, $apiKey, $sessionId)
    {
        $url = "https://api.themoviedb.org/3/account/{$accountId}/favorite/tv?api_key={$apiKey}&session_id={$sessionId}";

        $response = $this->curlGet($url);

        return $response->results ?? [];
    }

    private function removeFavoriteTvShow($accountId, $tvShowId, $apiKey, $sessionId)
    {
        $url = "https://api.themoviedb.org/3/account/{$accountId}/favorite?api_key={$apiKey}&session_id={$sessionId}";

        $data = json_encode([
            'media_type' => 'tv',
            'media_id' => $tvShowId,
            'favorite' => false,
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
