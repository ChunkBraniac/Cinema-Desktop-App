<?php

namespace App\Http\Controllers;

use Google\Client;
use App\Models\Top10;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{

    // function for fetching the movies
    public function fetchSeries()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        $country = ['US', 'IN', 'GB', 'CA', 'AU', 'DE', 'FR', 'JP'];

        foreach ($country as $countries) {
            $url = "https://imdb188.p.rapidapi.com/api/v1/getWhatsStreaming?country=$countries";
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: imdb188.p.rapidapi.com",
                    "X-RapidAPI-Key: 85391acd3cmsh02760f9d15463d2p145d38jsn69e076280407"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $data = json_decode($response, true);

            if ($err) {
                return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
            }

            if (isset($data['data']) && is_array($data['data'])) {
                foreach ($data['data'] as $movie) {
                    foreach ($movie['edges'] as $movie) {
                        $movie_id = mysqli_real_escape_string($connection, $movie['title']['id']);

                        // Check if the movie is already in the database
                        $fetch = mysqli_query($connection, "SELECT * FROM series WHERE movieId = '$movie_id'");

                        if (mysqli_num_rows($fetch) == 0) {

                            // check if the number of rows in the table is already up to ten
                            // if it is, break out of the loop
                            $fetch_movies = mysqli_query($connection, "SELECT * FROM series");

                            if (mysqli_num_rows($fetch_movies) >= 20) {
                                exit;
                            }

                            $releaseYear = isset($movie['title']['releaseYear']['year']) ? mysqli_real_escape_string($connection, $movie['title']['releaseYear']['year']) : 0;

                            // Check if the movie's release year is within the range of 2021 to 2024
                            if ($releaseYear >= 2010 && $releaseYear <= 2024) {
                                $isAdult = isset($movie["title"]["isAdult"]) ? $movie["title"]["isAdult"] : 0;
                                $isRatable = isset($movie['title']['canRateTitle']['isRatable']) ? $movie['title']['canRateTitle']['isRatable'] : 0;
                                $originalTitleText = isset($movie['title']['originalTitleText']['text']) ? mysqli_real_escape_string($connection, $movie['title']['originalTitleText']['text']) : 'No name';
                                $primaryImage = isset($movie['title']['primaryImage']['imageUrl']) ? mysqli_real_escape_string($connection, $movie['title']['primaryImage']['imageUrl']) : 'No image url';
                                $ratingsSummary = isset($movie['title']['ratingsSummary']['aggregateRating']) ? $movie['title']['ratingsSummary']['aggregateRating'] : 0;
                                $titleType = isset($movie['title']['titleType']['id']) ? mysqli_real_escape_string($connection, $movie['title']['titleType']['id']) : 0;
                                $titleTypeText = isset($movie['title']['titleType']['text']) ? mysqli_real_escape_string($connection, $movie['title']['titleType']['text']) : 0;
                                $canHaveEpisodes = isset($movie['title']['titleType']['canHaveEpisodes']) ? $movie['title']['titleType']['canHaveEpisodes'] : 0;
                                $isSeries = isset($movie['title']['titleType']['isSeries']) ? $movie['title']['titleType']['isSeries'] : 0;

                                $current_timestamp = date('Y-m-d H:i:s');

                                // Accept only 150 movies
                                $select_movies = mysqli_query($connection, "SELECT * FROM series");

                                // Insert the movie into the database
                                if (mysqli_num_rows($select_movies) < 20) {

                                    // check if the fetched movies is series
                                    if ($titleType == 'tvSeries' || $titleType == 'tvMiniSeries') {

                                        // if it is series, insert it into the series table
                                        $insert = mysqli_query($connection, "INSERT INTO series (movieId, isAdult, isRatable, originalTitleText, imageUrl, aggregateRating, releaseYear, titleType, titleTypeText, isSeries, country, runtime, genres, tmdbId, trailer, plotText, created_at) VALUES ('$movie_id', '$isAdult', '$isRatable', '$originalTitleText', '$primaryImage', '$ratingsSummary', '$releaseYear', '$titleType', '$titleTypeText', '$isSeries', '0', '0', '0', '', '0', '', '$current_timestamp')");

                                        if ($insert) {
                                            return redirect()->route('admin.dashboard')->with('success', 'Series fetched successfully');
                                        } else {
                                            return redirect()->route('admin.dashboard')->with('error', 'Failed to add series');
                                        }
                                    } else {
                                        return redirect()->route('admin.dashboard')->with('error', 'Series not inserted');
                                    }
                                }
                            } else {
                                return redirect()->route('admin.dashboard')->with('error', 'Series release year is not within the specified range');
                            }
                        } else {
                            return redirect()->route('admin.dashboard')->with('error', 'Series already exists');
                        }
                    }
                }
            } else {
                return redirect()->route('admin.dashboard')->with('error', var_dump($data));
            }
        }
    }

    // fetch the movies
    public function fetchMovies()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        $country = ['US', 'IN', 'GB', 'CA', 'AU', 'DE', 'FR', 'JP'];

        foreach ($country as $countries) {
            $url = "https://imdb188.p.rapidapi.com/api/v1/getWhatsStreaming?country=$countries";
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: imdb188.p.rapidapi.com",
                    "X-RapidAPI-Key: 85391acd3cmsh02760f9d15463d2p145d38jsn69e076280407"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
            }

            curl_close($curl);

            $data = json_decode($response, true);

            if (isset($data['data']) && is_array($data['data'])) {
                foreach ($data['data'] as $movie) {
                    foreach ($movie['edges'] as $movie) {
                        $movie_id = mysqli_real_escape_string($connection, $movie['title']['id']);

                        // Check if the movie is already in the database
                        $fetch = mysqli_query($connection, "SELECT * FROM movies WHERE movieId = '$movie_id'");

                        if (mysqli_num_rows($fetch) == 0) {

                            // check if the number of rows in the database is already up to ten
                            // if it is, exit the loop

                            $fetch_movies = mysqli_query($connection, "SELECT * FROM movies");

                            if (mysqli_num_rows($fetch_movies) >= 20) {
                                exit();
                            }

                            $releaseYear = isset($movie['title']['releaseYear']['year']) ? mysqli_real_escape_string($connection, $movie['title']['releaseYear']['year']) : 0;

                            // Check if the movie's release year is within the range of 2021 to 2024
                            if ($releaseYear >= 2010 && $releaseYear <= 2024) {
                                $isAdult = isset($movie["title"]["isAdult"]) ? $movie["title"]["isAdult"] : 0;
                                $isRatable = isset($movie['title']['canRateTitle']['isRatable']) ? $movie['title']['canRateTitle']['isRatable'] : 0;
                                $originalTitleText = isset($movie['title']['originalTitleText']['text']) ? mysqli_real_escape_string($connection, $movie['title']['originalTitleText']['text']) : 'No name';
                                $primaryImage = isset($movie['title']['primaryImage']['imageUrl']) ? mysqli_real_escape_string($connection, $movie['title']['primaryImage']['imageUrl']) : 'No image url';
                                $ratingsSummary = isset($movie['title']['ratingsSummary']['aggregateRating']) ? $movie['title']['ratingsSummary']['aggregateRating'] : 0;
                                $titleType = isset($movie['title']['titleType']['id']) ? mysqli_real_escape_string($connection, $movie['title']['titleType']['id']) : 0;
                                $titleTypeText = isset($movie['title']['titleType']['text']) ? mysqli_real_escape_string($connection, $movie['title']['titleType']['text']) : 0;
                                $canHaveEpisodes = isset($movie['title']['titleType']['canHaveEpisodes']) ? $movie['title']['titleType']['canHaveEpisodes'] : 0;
                                $isSeries = isset($movie['title']['titleType']['isSeries']) ? $movie['title']['titleType']['isSeries'] : 0;

                                $current_timestamp = date('Y-m-d H:i:s');

                                // Accept only 150 movies
                                $select_movies = mysqli_query($connection, "SELECT * FROM series");

                                // Insert the movie into the database
                                if (mysqli_num_rows($select_movies) < 20) {

                                    // check if the fetched movies is series
                                    if ($titleType == 'movie') {

                                        // if it is series, insert it into the series table
                                        $insert = mysqli_query($connection, "INSERT INTO movies (movieId, isAdult, isRatable, originalTitleText, imageUrl, aggregateRating, releaseYear, titleType, titleTypeText, isSeries, country, runtime, genres, trailer, plotText, created_at) VALUES ('$movie_id', '$isAdult', '$isRatable', '$originalTitleText', '$primaryImage', '$ratingsSummary', '$releaseYear', '$titleType', '$titleTypeText', '$isSeries', '0', '0', '0', '0', '', '$current_timestamp')");

                                        if ($insert) {
                                            return redirect()->route('admin.dashboard')->with('success', 'Movies fetched successfully');
                                        } else {
                                            return redirect()->route('admin.dashboard')->with('error', 'Failed to add movie');
                                        }
                                    } else {
                                        return redirect()->route('admin.dashboard')->with('error', 'Movie not inserted');
                                    }
                                }
                            } else {
                                return redirect()->route('admin.dashboard')->with('error', 'Movie release year is not within the specified range');
                            }
                        } else {
                            return redirect()->route('admin.dashboard')->with('error', 'Movie already exists');
                        }
                    }
                }
            } else {
                return redirect()->route('admin.dashboard')->with('error', var_dump($data));
            }
        }
    }

    public function updateSeriesType()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        // update the movie type
        $update_type = mysqli_query($connection, "UPDATE series SET titleType = 'series' WHERE titleType = 'tvSeries'");

        if ($update_type) {
            return redirect()->route('admin.dashboard')->with('status', 'Series type updated');
        }
    }

    public static function updateSeriesGenre()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        // setting the api key and the base url
        $api_key = "1188d67425fbb7eab235eb038542b64f";
        $base_url = "https://api.themoviedb.org/3";

        $fetch_no_genres = mysqli_query($connection, "SELECT * FROM series WHERE genres = '0'");

        if (mysqli_num_rows($fetch_no_genres) > 0) {
            while ($no_genres = mysqli_fetch_assoc($fetch_no_genres)) {
                $movieName = $no_genres['originalTitleText'];
                $movieId = $no_genres['id'];

                $movie_name = $movieName;
                $search_url = "{$base_url}/search/movie";
                $params = ["api_key" => $api_key, "query" => $movie_name];

                // Step 2: Search for a movie
                $search_response = @file_get_contents("$search_url?" . http_build_query($params));

                if ($search_response === false) {
                    // Handle error for failed API request
                    return redirect()->route('admin.dashboard')->with('error', 'Error fetching data for movie');
                }

                $search_results = json_decode($search_response, true);

                if (empty($search_results["results"])) {
                    // Handle case where no results were found for the movie
                    echo "No results found for movie: $movie_name in the Popular Movies db" . "<br>";
                    continue;
                }

                $movie_id = $search_results["results"][0]["id"];

                // Step 3: Get movie details
                $movie_url = "{$base_url}/movie/{$movie_id}";
                $params = ["api_key" => $api_key];
                $movie_response = @file_get_contents("$movie_url?" . http_build_query($params));

                if ($movie_response === false) {
                    // Handle error for failed API request
                    echo "Error fetching details for movie: $movie_name\n";
                    continue;
                }

                $movie_details = json_decode($movie_response, true);

                // Step 4: Extract genre information
                $genres = [];
                foreach ($movie_details["genres"] as $genre) {
                    $genres[] = $genre["name"];
                }

                $genres_string = implode(", ", $genres);

                // Update the database with the retrieved genres
                $update_query = "UPDATE series SET genres = '$genres_string' WHERE id = '$movieId'";
                mysqli_query($connection, $update_query);

                if ($update_query) {
                    return redirect()->route('admin.dashboard')->with('success', 'Series genres updated');
                }
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty genre field found');
        }
    }

    public static function updateMoviesGenre()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        // setting the api key and the base url
        $api_key = "1188d67425fbb7eab235eb038542b64f";
        $base_url = "https://api.themoviedb.org/3";

        $fetch_no_genres = mysqli_query($connection, "SELECT * FROM movies WHERE genres = '0'");

        if (mysqli_num_rows($fetch_no_genres) > 0) {
            while ($no_genres = mysqli_fetch_assoc($fetch_no_genres)) {
                $movieName = $no_genres['originalTitleText'];
                $movieId = $no_genres['id'];

                $movie_name = $movieName;
                $search_url = "{$base_url}/search/movie";
                $params = ["api_key" => $api_key, "query" => $movie_name];

                // Step 2: Search for a movie
                $search_response = @file_get_contents("$search_url?" . http_build_query($params));

                if ($search_response === false) {
                    // Handle error for failed API request
                    return redirect()->route('admin.dashboard')->with('error', 'Error fetching data for movie');
                }

                $search_results = json_decode($search_response, true);

                if (empty($search_results["results"])) {
                    // Handle case where no results were found for the movie
                    echo "No results found for movie: $movie_name in the Popular Movies db" . "<br>";
                    continue;
                }

                $movie_id = $search_results["results"][0]["id"];

                // Step 3: Get movie details
                $movie_url = "{$base_url}/movie/{$movie_id}";
                $params = ["api_key" => $api_key];
                $movie_response = @file_get_contents("$movie_url?" . http_build_query($params));

                if ($movie_response === false) {
                    // Handle error for failed API request
                    echo "Error fetching details for movie: $movie_name\n";
                    continue;
                }

                $movie_details = json_decode($movie_response, true);

                // Step 4: Extract genre information
                $genres = [];
                foreach ($movie_details["genres"] as $genre) {
                    $genres[] = $genre["name"];
                }

                $genres_string = implode(", ", $genres);

                // Update the database with the retrieved genres
                $update_query = "UPDATE movies SET genres = '$genres_string' WHERE id = '$movieId'";
                mysqli_query($connection, $update_query);

                if ($update_query) {
                    return redirect()->route('admin.dashboard')->with('success', 'Movies genres updated');
                }
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty genre field found');
        }
    }

    public function updateSeriesDescription()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        // fetch the movies to find description
        $fetchStreaming = mysqli_query($connection, "SELECT * FROM series WHERE plotText = ''");

        if (mysqli_num_rows($fetchStreaming) > 0) {
            while ($stream = mysqli_fetch_assoc($fetchStreaming)) {
                $id = $stream['movieId'];
                $streamId = $stream['id'];

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://imdb146.p.rapidapi.com/v1/title/?id={$id}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                            "X-RapidAPI-Host: imdb146.p.rapidapi.com",
                            "X-RapidAPI-Key: 85391acd3cmsh02760f9d15463d2p145d38jsn69e076280407"
                        ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                if ($err) {
                    return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
                }

                curl_close($curl);

                $data = json_decode($response, true);

                $newDescription = isset($data['plot']['plotText']['plainText']) ? mysqli_real_escape_string($connection, $data['plot']['plotText']['plainText']) : 0;

                // update the description
                $updateDescription = mysqli_query($connection, "UPDATE series SET plotText = '$newDescription' WHERE id = '$streamId'");

                if ($updateDescription) {
                    return redirect()->route('admin.dashboard')->with('success', 'Series description updated successfully');
                } else {
                    return redirect()->route('admin.dashboard')->with('error', 'Series description not updated');
                }
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty plotText field found');
        }
    }

    public function updateMoviesDescription()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        // fetch the movies to find description
        $fetchStreaming = mysqli_query($connection, "SELECT * FROM movies WHERE plotText = ''");

        if (mysqli_num_rows($fetchStreaming) > 0) {
            while ($stream = mysqli_fetch_assoc($fetchStreaming)) {
                $id = $stream['movieId'];
                $streamId = $stream['id'];

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://imdb146.p.rapidapi.com/v1/title/?id={$id}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                            "X-RapidAPI-Host: imdb146.p.rapidapi.com",
                            "X-RapidAPI-Key: 85391acd3cmsh02760f9d15463d2p145d38jsn69e076280407"
                        ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                if ($err) {
                    return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
                }

                curl_close($curl);

                $data = json_decode($response, true);

                $newDescription = isset($data['plot']['plotText']['plainText']) ? mysqli_real_escape_string($connection, $data['plot']['plotText']['plainText']) : 0;

                // update the description
                $updateDescription = mysqli_query($connection, "UPDATE movies SET plotText = '$newDescription' WHERE id = '$streamId'");

                if ($updateDescription) {
                    return redirect()->route('admin.dashboard')->with('success', 'Movies description updated successfully');
                } else {
                    return redirect()->route('admin.dashboard')->with('error', 'Movies description not updated');
                }
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty plotText field found');
        }
    }

    public function updateMoviesGenre2()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        $fetch_movieId = mysqli_query($connection, "SELECT * FROM movies WHERE genres = ''");

        if (mysqli_num_rows($fetch_movieId) > 0) {
            while ($ids = mysqli_fetch_assoc($fetch_movieId)) {
                $movieId = $ids['movieId'];
                $movieMainId = $ids['id'];

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://ott-details.p.rapidapi.com/gettitleDetails?imdbid={$movieId}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                            "X-RapidAPI-Host: ott-details.p.rapidapi.com",
                            "X-RapidAPI-Key: 5db32b6427msh63a3feac22d80eep1c836bjsn20a1f588f218"
                        ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                if ($err) {
                    return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
                }

                curl_close($curl);

                $data = json_decode($response, true);

                $updatedGenreId = '';

                if (isset($data['genre']['0'])) {
                    $updatedGenreId .= $data['genre']['0'];
                }

                if (isset($data['genre']['1'])) {
                    $updatedGenreId .= isset($updatedGenreId) ? '-' . $data['genre']['1'] : $data['genre']['1'];
                }

                if (isset($data['genre']['2'])) {
                    $updatedGenreId .= isset($updatedGenreId) ? '-' . $data['genre']['2'] : $data['genre']['2'];
                }

                // update the genres
                $update = mysqli_query($connection, "UPDATE streamings SET genres = '$updatedGenreId' WHERE id = '$movieMainId'");

                if ($update) {
                    return redirect()->route('admin.dashboard')->with('success', 'Movie genre has been update');
                } else {
                    return redirect()->route('admin.dashboard')->with('error', 'Something went wrong');
                }

            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty genre field found');
        }
    }

    public function updateSeriesGenre2()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        $fetch_movieId = mysqli_query($connection, "SELECT * FROM series WHERE genres = ''");

        if (mysqli_num_rows($fetch_movieId) > 0) {
            while ($ids = mysqli_fetch_assoc($fetch_movieId)) {
                $movieId = $ids['movieId'];
                $movieMainId = $ids['id'];

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://ott-details.p.rapidapi.com/gettitleDetails?imdbid={$movieId}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                            "X-RapidAPI-Host: ott-details.p.rapidapi.com",
                            "X-RapidAPI-Key: 5db32b6427msh63a3feac22d80eep1c836bjsn20a1f588f218"
                        ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                if ($err) {
                    return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
                }

                curl_close($curl);

                $data = json_decode($response, true);

                $updatedGenreId = '';

                if (isset($data['genre']['0'])) {
                    $updatedGenreId .= $data['genre']['0'];
                }

                if (isset($data['genre']['1'])) {
                    $updatedGenreId .= isset($updatedGenreId) ? '-' . $data['genre']['1'] : $data['genre']['1'];
                }

                if (isset($data['genre']['2'])) {
                    $updatedGenreId .= isset($updatedGenreId) ? '-' . $data['genre']['2'] : $data['genre']['2'];
                }

                // update the genres
                $update = mysqli_query($connection, "UPDATE series SET genres = '$updatedGenreId' WHERE id = '$movieMainId'");

                if ($update) {
                    return redirect()->route('admin.dashboard')->with('success', 'Series genre has been update');
                } else {
                    return redirect()->route('admin.dashboard')->with('error', 'Something went wrong');
                }

            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty genre field found');
        }
    }

    public function updateSeriesTrailer()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        $fetch_trailer = mysqli_query($connection, "SELECT * FROM series WHERE trailer = '0'");

        if (mysqli_num_rows($fetch_trailer) > 0) {
            require('vendor/autoload.php');

            // Create a Google_Client
            $client = new Google\Client();
            $client->setApplicationName('CinemaHub');
            $client->setDeveloperKey('AIzaSyCUoGQhYzTPCkjEpYZvgyoFHqngLwibFiI');

            // Create a Google_Service_YouTube instance
            $youtube = new Google\Service\YouTube($client);

            // Fetch movies that don't have trailers
            $noTrailer = mysqli_query($connection, "SELECT * FROM series WHERE trailer = '0'");

            if (mysqli_num_rows($noTrailer) > 0) {
                while ($nonTrailer = mysqli_fetch_assoc($noTrailer)) {
                    $movie_name = $nonTrailer['originalTitleText'];

                    // Set the movie name you want to search for
                    $movieName = mysqli_real_escape_string($connection, $movie_name); // Replace with the movie name you are interested in

                    // Set parameters for the API request
                    $params = [
                        'q' => $movieName . ' trailer',
                        'type' => 'video',
                        'maxResults' => 1, // You can adjust this based on your preference
                    ];

                    // Make the API request
                    $response = $youtube->search->listSearch('id,snippet', $params);

                    // Display the results
                    foreach ($response['items'] as $item) {
                        $videoTrailer = mysqli_real_escape_string($connection, "https://www.youtube.com/watch?v=" . $item['id']['videoId']);

                        // Update the database with the trailer
                        $updateTrailer = mysqli_query($connection, "UPDATE series SET trailer = '$videoTrailer' WHERE originalTitleText = '$movieName'");
                        if ($updateTrailer) {
                            return redirect()->route('admin.dashboard')->with('success', 'Trailer updated');
                        } else {
                            return redirect()->route('admin.dashboard')->with('error', 'Failed to update trailer');
                        }
                    }
                }
            }
            else {
                return redirect()->route('admin.dashboard')->with('error', 'No empty trailer field found');
            }
        }
    }

    public function updateMoviesTrailer()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect' . mysqli_connect_error());
        } else {
            mysqli_error($connection);
        }

        $fetch_trailer = mysqli_query($connection, "SELECT * FROM movies WHERE trailer = '0'");

        if (mysqli_num_rows($fetch_trailer) > 0) {
            require('vendor/autoload.php');

            // Create a Google_Client
            $client = new Google\Client();
            $client->setApplicationName('CinemaHub');
            $client->setDeveloperKey('AIzaSyCUoGQhYzTPCkjEpYZvgyoFHqngLwibFiI');

            // Create a Google_Service_YouTube instance
            $youtube = new Google\Service\YouTube($client);

            // Fetch movies that don't have trailers
            $noTrailer = mysqli_query($connection, "SELECT * FROM movies WHERE trailer = '0'");

            if (mysqli_num_rows($noTrailer) > 0) {
                while ($nonTrailer = mysqli_fetch_assoc($noTrailer)) {
                    $movie_name = $nonTrailer['originalTitleText'];

                    // Set the movie name you want to search for
                    $movieName = mysqli_real_escape_string($connection, $movie_name); // Replace with the movie name you are interested in

                    // Set parameters for the API request
                    $params = [
                        'q' => $movieName . ' trailer',
                        'type' => 'video',
                        'maxResults' => 1, // You can adjust this based on your preference
                    ];

                    // Make the API request
                    $response = $youtube->search->listSearch('id,snippet', $params);

                    // Display the results
                    foreach ($response['items'] as $item) {
                        $videoTrailer = mysqli_real_escape_string($connection, "https://www.youtube.com/watch?v=" . $item['id']['videoId']);

                        // Update the database with the trailer
                        $updateTrailer = mysqli_query($connection, "UPDATE movies SET trailer = '$videoTrailer' WHERE originalTitleText = '$movieName'");
                        if ($updateTrailer) {
                            return redirect()->route('admin.dashboard')->with('success', 'Trailer updated');
                        } else {
                            return redirect()->route('admin.dashboard')->with('error', 'Failed to update trailer');
                        }
                    }
                }
            }
            else {
                return redirect()->route('admin.dashboard')->with('error', 'No empty trailer field found');
            }
        }
        else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty trailer field found');
        }
    }
}
