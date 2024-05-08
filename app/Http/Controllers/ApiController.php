<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\YouTube;
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
                    "X-RapidAPI-Key: 67aceb234fmshffdfd7d36c364c5p167eb3jsn92249749c17f"
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

                            if (mysqli_num_rows($fetch_movies) >= 200) {
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
                                if (mysqli_num_rows($select_movies) < 200) {

                                    // check if the fetched movies is series
                                    if ($titleType == 'tvSeries' || $titleType == 'tvMiniSeries') {

                                        // if it is series, insert it into the series table
                                        $insert = mysqli_query($connection, "INSERT INTO series (movieId, isAdult, isRatable, originalTitleText, imageUrl, aggregateRating, releaseYear, titleType, titleTypeText, isSeries, country, runtime, genres, tmdbId, trailer, plotText, created_at) VALUES ('$movie_id', '$isAdult', '$isRatable', '$originalTitleText', '$primaryImage', '$ratingsSummary', '$releaseYear', '$titleType', '$titleTypeText', '$isSeries', '0', '0', '0', '', '0', '', '$current_timestamp')");

                                        if ($insert) {
                                            echo "Movie inserted successfully";
                                        } else {
                                            // return redirect()->route('admin.dashboard')->with('error', 'Failed to add series');
                                            echo "Failed to add series";
                                        }
                                    } else {
                                        // return redirect()->route('admin.dashboard')->with('error', 'Series not inserted');
                                        echo "Series not inserted";
                                    }
                                }
                            } else {
                                // return redirect()->route('admin.dashboard')->with('error', 'Series release year is not within the specified range');
                                echo "Series release year is not within the specified range";
                            }
                        } else {
                            // return redirect()->route('admin.dashboard')->with('error', 'Series already exists');
                            echo "Series already exists";
                        }
                    }
                }
            } else {
                var_dump($data);
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
                    "X-RapidAPI-Key: 67aceb234fmshffdfd7d36c364c5p167eb3jsn92249749c17f"
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

                            if (mysqli_num_rows($fetch_movies) >= 300) {
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
                                $select_movies = mysqli_query($connection, "SELECT * FROM movies");

                                // Insert the movie into the database
                                if (mysqli_num_rows($select_movies) < 300) {

                                    // check if the fetched movies is series
                                    if ($titleType == 'movie') {

                                        // if it is series, insert it into the series table
                                        $insert = mysqli_query($connection, "INSERT INTO movies (movieId, isAdult, isRatable, originalTitleText, imageUrl, aggregateRating, releaseYear, titleType, titleTypeText, isSeries, country, runtime, genres, tmdbId, trailer, plotText, created_at) VALUES ('$movie_id', '$isAdult', '$isRatable', '$originalTitleText', '$primaryImage', '$ratingsSummary', '$releaseYear', '$titleType', '$titleTypeText', '$isSeries', '0', '0', '0', '0', '', '', '$current_timestamp')");

                                        if ($insert) {
                                            echo "Movie inserted successfully";
                                        } else {
                                            echo "Failed to add movie";
                                        }
                                    } else {
                                        echo "Movie not inserted";
                                    }
                                }
                            } else {
                                echo "Movie release year is not within the specified range";
                            }
                        } else {
                            echo "Movie already exist";
                        }
                    }
                }
            } else {
                var_dump($data);
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
        $update_type = mysqli_query($connection, "UPDATE series SET titleType = 'series'");

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
                    echo "Error fetching data for movie";
                }

                $search_results = json_decode($search_response, true);

                if (empty($search_results["results"])) {
                    // Handle case where no results were found for the movie
                    echo "No result found";
                }

                $movie_id = isset($search_results["results"][0]["id"]) ? $search_results["results"][0]["id"] : null;

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

                // return redirect()->route('admin.dashboard')->with('success', 'Series genres updated');
                if ($update_query) {
                    echo "Genre fetched successfully";
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
                    echo "Error fetching data for movie";
                }

                $search_results = json_decode($search_response, true);

                if (empty($search_results["results"])) {
                    // Handle case where no results were found for the movie
                    echo "No result found";
                }

                $movie_id = isset($search_results["results"][0]["id"]) ? $search_results["results"][0]["id"] : null;


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

                // return redirect()->route('admin.dashboard')->with('success', 'Movies genres updated');
                if ($update_query) {
                    echo 'Movies genres updated successfully';
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
        $fetchStreaming = mysqli_query($connection, "SELECT * FROM series WHERE plotText = '' OR plotText = '0'");

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
                    // return redirect()->route('admin.dashboard')->with('success', 'Series description updated successfully');
                    echo "Description updated successfully" . "<br>";
                } else {
                    // return redirect()->route('admin.dashboard')->with('error', 'Series description not updated');
                    echo "Series description not updated" . "<br>";
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
        $fetchStreaming = mysqli_query($connection, "SELECT * FROM movies WHERE plotText = '' OR plotText = '0'");

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
                    echo "Movies description updated successfully";
                } else {
                    echo "Movies not description updated";
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

        $fetch_movieId = mysqli_query($connection, "SELECT * FROM movies WHERE genres = '0' OR genres = ''");

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
                $update = mysqli_query($connection, "UPDATE movies SET genres = '$updatedGenreId' WHERE id = '$movieMainId'");

                if ($update) {
                    // return redirect()->route('admin.dashboard')->with('success', 'Movie genre has been update');
                    echo "Genres updated successfully";
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

        $fetch_movieId = mysqli_query($connection, "SELECT * FROM series WHERE genres = '0' OR genres = ''");

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
                    // return redirect()->route('admin.dashboard')->with('success', 'Series genre has been updated');
                    echo "Genres updated successfully";
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

            // Create a Google_Client
            $client = new Client();
            $client->setApplicationName('CinemaHub');
            $client->setDeveloperKey('AIzaSyCUoGQhYzTPCkjEpYZvgyoFHqngLwibFiI');

            // Create a Google_Service_YouTube instance
            $youtube = new YouTube($client);

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
                            // return redirect()->route('admin.dashboard')->with('success', 'Trailer updated');
                            echo "Trailer updated";
                        } else {
                            echo "Failed";
                        }
                    }
                }
            } else {
                return redirect()->route('admin.dashboard')->with('error', 'No empty trailer field found');
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty trailer field found');
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

        $fetch_trailer = mysqli_query($connection, "SELECT * FROM movies WHERE trailer = ''");

        if (mysqli_num_rows($fetch_trailer) > 0) {

            // Create a Google_Client
            $client = new Client();
            $client->setApplicationName('CinemaHub');
            $client->setDeveloperKey('AIzaSyCUoGQhYzTPCkjEpYZvgyoFHqngLwibFiI');

            // Create a Google_Service_YouTube instance
            $youtube = new YouTube($client);

            // Fetch movies that don't have trailers
            $noTrailer = mysqli_query($connection, "SELECT * FROM movies WHERE trailer = ''");

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
                            // return redirect()->route('admin.dashboard')->with('success', 'Trailer updated');
                            echo "Trailer updated";
                        } else {
                            echo "Failed";
                        }
                    }
                }
            } else {
                return redirect()->route('admin.dashboard')->with('error', 'No empty trailer field found');
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty trailer field found');
        }
    }

    public function getTmdbIdSeries()
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

        $imdb_ids = mysqli_query($connection, "SELECT * FROM series WHERE tmdbId = ''");

        if (mysqli_num_rows($imdb_ids) > 0) {
            while ($imdb = mysqli_fetch_assoc($imdb_ids)) {
                $id = $imdb['movieId'];
                $mainId = $imdb['id'];

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://mdblist.p.rapidapi.com/?i={$id}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: mdblist.p.rapidapi.com",
                        "X-RapidAPI-Key: 42f503244cmsh53f60704eda2911p158869jsnd555cbfa525f"
                    ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                if ($err) {
                    return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
                }

                curl_close($curl);

                $data = json_decode($response, true);

                $tmdb_id = isset($data['tmdbid']) ? mysqli_real_escape_string($connection, $data['tmdbid']) : '0';

                // update the tmdb id in the database
                $update = mysqli_query($connection, "UPDATE series SET tmdbId = '$tmdb_id' WHERE id = '$mainId'");

                if ($update) {
                    echo "TMDb ID updated successfully";
                } else {
                    echo "Error updating TMDb ID";
                }
            }
        }
    }

    public function getSeasons()
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

        $fetch_tmdbid = mysqli_query($connection, "SELECT * FROM series WHERE tmdbId != '0'");

        if (mysqli_num_rows($fetch_tmdbid) > 0) {
            while ($tmdbids = mysqli_fetch_assoc($fetch_tmdbid)) {
                $movie_id = $tmdbids['movieId'];
                $movie_name = $tmdbids['originalTitleText'];
                $movie_type = $tmdbids['titleType'];
                $movie_image = $tmdbids['imageUrl'];
                $tmdbid = $tmdbids['tmdbId'];
                $mainId = $tmdbids['id'];

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://movies-api14.p.rapidapi.com/show/{$tmdbid}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: movies-api14.p.rapidapi.com",
                        "X-RapidAPI-Key: e5a7cf5c05msh4389aff7b01c10dp1d3cd3jsn14a1371d10f6"
                    ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                if ($err) {
                    return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
                }

                curl_close($curl);

                $data = json_decode($response, true);

                if (isset($data['seasons']) && is_array($data['seasons'])) {
                    foreach ($data['seasons'] as $season) {

                        foreach ($season['episodes'] as $episode) {
                            $season_number = $episode['season_number'];
                            $episode_number = $episode['episode_number'];
                            $title = mysqli_real_escape_string($connection, $episode['title']);
                            $air_date = mysqli_real_escape_string($connection, $episode['first_aired']);

                            // now inser them into the seasons table

                            // check if the episode already exists
                            $fetch_old = mysqli_query($connection, "SELECT * FROM seasons WHERE movieName = '$movie_name' AND episode_number = '$episode_number' AND season_number = '$season_number'");

                            if (mysqli_num_rows($fetch_old) > 0) {
                                echo "Episode already in database";
                            } else {
                                $insert = mysqli_query($connection, "INSERT INTO seasons (movieId, movieName, movieType, season_number, episode_number, episode_title, air_date, imageUrl) VALUES('$movie_id', '$movie_name', '$movie_type', '$season_number', '$episode_number', '$title', '$air_date', '$movie_image')");

                                if ($insert) {
                                    echo "Seasons inserted successfully";
                                }
                            }
                        }
                    }
                }

                // var_dump($data);
            }
        }
    }

    public function getSeriesSeasons()
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
        $seasons = [1, 2, 3, 4, 5];

        foreach ($seasons as $season) {
            $fetch_series = mysqli_query($connection, "SELECT * FROM series");

            if (mysqli_num_rows($fetch_series) > 0) {
                while ($series = mysqli_fetch_assoc($fetch_series)) {
                    $movieName = mysqli_real_escape_string($connection, $series['originalTitleText']);
                    $type = $series['titleType'];
                    $imageUrl = mysqli_real_escape_string($connection, $series['imageUrl']);
                    $series_id = $series['movieId'];
                    $id = $series['id'];

                    $curl = curl_init();

                    curl_setopt_array($curl, [
                        CURLOPT_URL => "https://movies-tv-shows-database.p.rapidapi.com/?seriesid={$series_id}&season={$season}",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => [
                            "Type: get-show-season-episodes",
                            "X-RapidAPI-Host: movies-tv-shows-database.p.rapidapi.com",
                            "X-RapidAPI-Key: 85391acd3cmsh02760f9d15463d2p145d38jsn69e076280407"
                        ],
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
                    } else {
                        $data = json_decode($response, true);

                        if (isset($data['tv_episodes'])) {
                            foreach ($data['tv_episodes'] as $tv) {
                                $episode_number = mysqli_real_escape_string($connection, $tv['episode_number']);
                                $title = mysqli_real_escape_string($connection, $tv['title']);
                                $air_date = mysqli_real_escape_string($connection, $tv['air_date']);

                                // check if the episode already exists
                                $fetch_old = mysqli_query($connection, "SELECT * FROM seasons WHERE movieName = '$movieName' AND episode_number = '$episode_number'");

                                if (mysqli_num_rows($fetch_old) > 0) {
                                    echo "Episode already in database";
                                } else {
                                    $insert = mysqli_query($connection, "INSERT INTO seasons (movieId, movieName, movieType, season_number, episode_number, episode_title, air_date, imageUrl) VALUES('$series_id', '$movieName', '$type', '1', '$episode_number', '$title', '$air_date', '$imageUrl')");

                                    if (!$insert) {
                                        echo "Error inserting episode: " . mysqli_error($connection);
                                    } else {
                                        echo "Season fetched successfully" . '<br>';
                                    }
                                }
                            }
                        } else {
                            echo "No episodes found for series ID: " . $series_id;
                        }
                    }
                }
            }
        }

        var_dump($data);

    }

    public function popularMovies()
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

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://imdb188.p.rapidapi.com/api/v1/getPopularMovies",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'country' => [
                    'anyPrimaryCountries' => [
                        'IN',
                        'US',
                        'GB',
                        'CA',
                        'AU',
                        'DE',
                    ]
                ],
                'limit' => 200,
                'releaseDate' => [
                    'releaseDateRange' => [
                        'end' => '2029-12-31',
                        'start' => '2020-01-01'
                    ]
                ],
                'userRatings' => [
                    'aggregateRatingRange' => [
                        'max' => 10,
                        'min' => 6
                    ],
                    'ratingsCountRange' => [
                        'min' => 1000
                    ]
                ],
                'genre' => [
                    'allGenreIds' => [
                        'Action'
                    ]
                ],
                'runtime' => [
                    'runtimeRangeMinutes' => [
                        'max' => 120,
                        'min' => 0
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: imdb188.p.rapidapi.com",
                "X-RapidAPI-Key: 67aceb234fmshffdfd7d36c364c5p167eb3jsn92249749c17f",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
        }

        curl_close($curl);

        $data = json_decode($response, true);

        if (isset($data['data']['list']) && is_array($data['data']['list'])) {
            foreach ($data['data']['list'] as $list) {
                $movie_id = $list['title']['id'];

                // check if the movie is already in the db
                $fetch = mysqli_query($connection, "SELECT * FROM movies WHERE id = '$movie_id'");

                if (mysqli_num_rows($fetch) == 0) {

                    $fetch_movies = mysqli_query($connection, "SELECT * FROM movies");

                    if (mysqli_num_rows($fetch_movies) >= 300) {
                        // exit();
                        return redirect()->route('admin.dashboard')->with('error', 'Movie limit reached');
                    }

                    $releaseYear = isset($list['title']['releaseYear']['year']) ? mysqli_real_escape_string($connection, $list['title']['releaseYear']['year']) : 0;

                    if ($releaseYear >= '2010' && $releaseYear <= '2024') {
                        $isAdult = isset($list["title"]["isAdult"]) ? $list["title"]["isAdult"] : 0;
                        $isRatable = isset($list['title']['canRateTitle']['isRatable']) ? $list['title']['canRateTitle']['isRatable'] : false;
                        $originalTitleText = isset($list['title']['originalTitleText']['text']) ? mysqli_real_escape_string($connection, $list['title']['originalTitleText']['text']) : 'No name';
                        $primaryImage = isset($list['title']['primaryImage']['imageUrl']) ? mysqli_real_escape_string($connection, $list['title']['primaryImage']['imageUrl']) : 'No image url';
                        $ratingsSummary = isset($list['title']['ratingsSummary']['aggregateRating']) ? $list['title']['ratingsSummary']['aggregateRating'] : 0;
                        $releaseYear = isset($list['title']['releaseYear']['year']) ? mysqli_real_escape_string($connection, $list['title']['releaseYear']['year']) : 0;
                        $titleType = isset($list['title']['titleType']['id']) ? mysqli_real_escape_string($connection, $list['title']['titleType']['id']) : 0;
                        $titleTypeText = isset($list['title']['titleType']['text']) ? mysqli_real_escape_string($connection, $list['title']['titleType']['text']) : 0;
                        $canHaveEpisodes = isset($list['title']['titleType']['canHaveEpisodes']) ? $list['title']['titleType']['canHaveEpisodes'] : 0;
                        $isSeries = isset($list['title']['titleType']['isSeries']) ? $list['title']['titleType']['isSeries'] : 0;

                        $current_timestamp = date('Y-m-d H:i:s');
                        // before inserting, let us check if the movies we are adding aleardy exists
                        $fetch_all = mysqli_query($connection, "SELECT * FROM movies WHERE originalTitleText = '$originalTitleText'");

                        if (mysqli_num_rows($fetch_all) > 0) {
                            echo "movie already exists";
                        } else {

                            $num_movies = mysqli_query($connection, "SELECT * FROM movies");

                            if (mysqli_num_rows($num_movies) < 300) {

                                if ($titleType == 'movie') {
                                    // insert the movie into the db
                                    $insert = mysqli_query($connection, "INSERT INTO movies (movieId, isAdult, isRatable, originalTitleText, imageUrl, aggregateRating, releaseYear, titleType, titleTypeText, isSeries, country, runtime, genres, tmdbId, trailer, plotText, created_at) VALUES ('$movie_id', '$isAdult', '$isRatable', '$originalTitleText', '$primaryImage', '$ratingsSummary', '$releaseYear', '$titleType', '$titleTypeText', '$isSeries', '0', '0', '0', '','', '', '$current_timestamp')");

                                    if ($insert) {
                                        echo "Movie added successfully";
                                    } else {
                                        echo "Failed to add movie";
                                    }
                                }
                                else {
                                    echo "type is not movie";
                                }
                            } else{
                                echo "movie limit reached";
                            }
                        }
                    } else {
                        echo "Movie not in range";
                    }
                } else {
                    echo "Movie already exists";
                }
            }
        } else {
            var_dump($data);
        }
    }
}
