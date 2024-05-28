<?php

namespace App\Http\Controllers;

use Google\Client;
use App\Models\Movies;
use App\Models\Series;
use Google\Service\YouTube;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{

    public function seriesV1()
    {

        $page = range(1, 20);
        $date = date('Y-m-d');

        foreach ($page as $pages) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/account/20553054/favorite/tv?&page={$pages}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
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
                echo $err;
            }

            $data = json_decode($response, true);

            if (isset($data['results']) && is_array($data['results'])) {
                foreach ($data['results'] as $result) {
                    $first_air_date = $result['first_air_date'];
                    $year = substr($first_air_date, 0, 4); // Extract the first four characters
                    $full_name = $result['name'];

                    if ($year >= '2017' && $first_air_date <= $date && $year <= '2024') {
                        $id = $result['id'];

                        // check if the series is already in the db

                        $fetch = Series::where('movieId', $id)->first();

                        if (!$fetch) {

                            $adult = isset($result['adult']) ? $result['adult'] : false;
                            $backdrop_path = isset($result['backdrop_path']) ? $result['backdrop_path'] : 'false';
                            $country = isset($result['origin_country'][0]) ? $result['origin_country'][0] : null;
                            $language = strtoupper($result['original_language']);
                            $full_name = $result['name'];
                            $name = $result['name'] . ' ' . $id;
                            $overview = $result['overview'];
                            $poster_path = $result['poster_path'];
                            $vote_average = $result['vote_average'];

                            $base_url = "";
                            if ($poster_path) {
                                $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
                            } else {
                                $base_url = "";
                            }

                            $formatted_name = str_replace([' '], '-', $name);
                            $rating = floor($vote_average * 10) / 10;

                            Series::create([
                                'movieId' => $id,
                                'isAdult' => $adult,
                                'full_name' => $full_name,
                                'originalTitleText' => $formatted_name,
                                'imageUrl' => $base_url,
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

                            echo $full_name . " - has been added to database" . "<br>";
                        } else {
                            echo $full_name . " - already in database" . "<br>";
                        }
                    }
                }
            } else {
                echo "No results found";
            }
        }
    }

    public function moviesV2()
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

        $page = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $minRuntime = 60; // Minimum runtime in minutes to exclude short films
        $date = date('Y-m-d');
        $origin_country = ['KR', 'US'];

        foreach ($page as $pages) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/account/20553054/favorite/movies?page={$pages}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
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
                return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch movies: ' . $err);
            }

            $data = json_decode($response, true);

            if (isset($data['results']) && is_array($data['results'])) {
                foreach ($data['results'] as $result) {
                    $release_date = isset($result['release_date']) ? $result['release_date'] : 0;
                    $year = substr($release_date, 0, 4); // Extract the first four characters
                    $full_name = $result['title'];

                    if ($year >= '2018' && $release_date <= $date && $year <= '2024') {
                        $id = $result['id'];

                        // check if the series is already in the db

                        $fetch = Movies::where('movieId', $id)->first();

                        if (!$fetch) {
                            $adult = $result['adult'];
                            $backdrop_path = isset($result['backdrop_path']) ? mysqli_real_escape_string($connection, $result['backdrop_path']) : 0;
                            $language = strtoupper($result['original_language']);
                            $full_name = mysqli_real_escape_string($connection, $result['title']);
                            $name = mysqli_real_escape_string($connection, $result['title'] . ' ' . $id);
                            $overview = mysqli_real_escape_string($connection, $result['overview']);
                            $poster_path = mysqli_real_escape_string($connection, $result['poster_path']);
                            $vote_average = mysqli_real_escape_string($connection, $result['vote_average']);

                            $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
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

                            echo $full_name . " - has been added successfully" . "<br>";
                        } else {
                            echo $full_name . " - already in database" . "<br>";
                        }
                    } else {
                        echo $full_name . " - not in range" . "<br>";
                    }
                }
            }
        }
    }

    public function updateMoviesInfo()
    {

        $fetch = Movies::where('country', '')->get();

        if (count($fetch) > 0) {
            foreach ($fetch as $movie) {
                $id = $movie->movieId;

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.themoviedb.org/3/movie/{$id}?language=en-US",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
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
                    echo "cURL Error #:" . $err;
                }

                $data = json_decode($response, true);

                $genres = '';

                if (isset($data['genres'][0]['name'])) {
                    $genres = $data['genres'][0]['name'];
                }

                if (isset($data['genres'][1]['name'])) {
                    $genres .= ', ' . $data['genres'][1]['name'];
                }

                if (isset($data['genres'][2]['name'])) {
                    $genres .= ', ' . $data['genres'][2]['name'];
                }

                $origin_country = isset($data['origin_country'][0]) ? $data['origin_country'][0] : 0;
                $runtime = isset($data['runtime']) ? $data['runtime'] : 0;

                $hours = intdiv($runtime, 60); // Integer division to get the number of hours
                $minutes = $runtime % 60; // Modulus to get the remaining minutes

                if ($hours > 1) {
                    $hour = "hours";
                } else {
                    $hour = "hour";
                }

                $runtime = '';

                if ($hour == '0' && $minutes == '0') {
                    $runtime = '';
                } else {
                    $runtime = $hours . ' ' . $hour . ' ' . $minutes . ' minutes';
                }

                // update the movie in the database
                $movie->country = $origin_country;
                $movie->runtime = $runtime;
                $movie->genres = $genres;
                $movie->save();

                echo $movie->full_name . " - updated successfully" . "<br>";
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No movie to update');
        }
    }

    public function updateSeriesInfo()
    {

        $fetch = Series::where('genres', '')->get();

        if (count($fetch) > 0) {
            foreach ($fetch as $movie) {

                $id = $movie->movieId;

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.themoviedb.org/3/tv/{$id}?language=en-US",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
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
                    echo "cURL Error #:" . $err;
                }

                $data = json_decode($response, true);

                $genres = '';

                if (isset($data['genres'][0]['name'])) {
                    $genres = $data['genres'][0]['name'];
                }

                if (isset($data['genres'][1]['name'])) {
                    $genres .= ', ' . $data['genres'][1]['name'];
                }

                if (isset($data['genres'][2]['name'])) {
                    $genres .= ', ' . $data['genres'][2]['name'];
                }

                // update the movie in the database
                $movie->genres = $genres;
                $movie->save();

                echo $movie->full_name . " updated successfully";
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No series to update');
        }
    }

    public function updateSeriesTrailer()
    {

        $getSeries = Series::where('trailer', '')->get();

        if (count($getSeries) > 0) {
            foreach ($getSeries as $movie) {
                $movie_id = $movie->movieId;

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.themoviedb.org/3/tv/{$movie_id}/videos",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
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
                    echo "cURL Error #:" . $err;
                }

                $data = json_decode($response, true);

                if (isset($data['results']) && is_array($data['results'])) {
                    foreach ($data['results'] as $video) {
                        if ($video['type'] === 'Trailer' && $video['site'] === 'YouTube') {
                            $trailer = "https://www.youtube.com/embed/" . $video['key'];

                            $movie->trailer = $trailer;
                            $movie->save();

                            echo "Trailer updated successfully for " . $movie->full_name . "<br>";
                        }
                    }
                }
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No series trailer to update');
        }
    }

    public function updateSeriesTrailerV2()
    {

        $apiKey = 'AIzaSyCUoGQhYzTPCkjEpYZvgyoFHqngLwibFiI';

        // Fetch movies that don't have trailers
        $noTrailer = Series::where('trailer', '')->get();

        if (count($noTrailer) > 0) {
            foreach ($noTrailer as $nonTrailer) {
                $movieName = $nonTrailer->full_name;

                // Set parameters for the API request
                $params = [
                    'q' => $movieName . ' trailer',
                    'type' => 'video',
                    'maxResults' => 1, // Ensures only one result is fetched
                    'key' => $apiKey
                ];
                
                // Make the API request
                $apiUrl = "https://www.googleapis.com/youtube/v3/search?" . http_build_query($params);
                $response = file_get_contents($apiUrl);
                $data = json_decode($response, true);

                // Display the results
                if (!empty($data['items'])) {
                    $videoTrailer = "https://www.youtube.com/embed/" . $data['items'][0]['id']['videoId'];

                    // Update the database with the trailer
                    $nonTrailer->trailer = $videoTrailer;
                    $nonTrailer->save();

                    echo "Trailer updated for " . $nonTrailer->full_name;
                }
            }
        } else {
            return redirect()->route('admin.dashboard')->with('error', 'No empty trailer field found');
        }
    }

    public function updateMoviesTrailer()
    {

        $getMovies = Movies::where('trailer', '')->get();

        if (count($getMovies) > 0) {
            foreach ($getMovies as $movie) {
                $movie_id = $movie->movieId;

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.themoviedb.org/3/movie/{$movie_id}/videos",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
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
                    echo "cURL Error #:" . $err;
                }

                $data = json_decode($response, true);

                if (isset($data['results']) && is_array($data['results'])) {
                    foreach ($data['results'] as $video) {
                        if (stripos($video['name'], 'Trailer') !== false && $video['site'] === 'YouTube') {
                            $trailer = "https://www.youtube.com/embed/" . $video['key'];

                            $movie->trailer = $trailer;
                            $movie->save();

                            echo "Trailer updated successfully for " . $movie->full_name . "<br>";
                        }
                    }
                }
            }
        }
    }

    public function updateMoviesTrailerV2()
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
                    $movie_name = $nonTrailer['full_name'];
                    $id = $nonTrailer['id'];

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
                        $videoTrailer = mysqli_real_escape_string($connection, "https://www.youtube.com/embed/" . $item['id']['videoId']);

                        // Update the database with the trailer
                        $updateTrailer = mysqli_query($connection, "UPDATE movies SET trailer = '$videoTrailer' WHERE id = '$id'");
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

    public function getSeasons()
    {
        $dbhost = "127.0.0.1";
        $dbus = "root";
        $dbpass = '';
        $dbname = 'cinema';

        $connection = mysqli_connect($dbhost, $dbus, $dbpass, $dbname);

        if (!$connection) {
            die('Failed to connect: ' . mysqli_connect_error());
        }

        $fetch = mysqli_query($connection, "SELECT * FROM series");
        if (!$fetch) {
            die('Error executing query: ' . mysqli_error($connection));
        }

        $seasons = range(1, 20);

        while ($data_info = mysqli_fetch_assoc($fetch)) {
            $movie_id = $data_info['movieId'];
            $movie_name = mysqli_real_escape_string($connection, $data_info['originalTitleText']);
            $movie_type = $data_info['titleType'];
            $movie_image = mysqli_real_escape_string($connection, $data_info['imageUrl']);
            $full_name = mysqli_real_escape_string($connection, $data_info['full_name']);

            foreach ($seasons as $season) {
                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.themoviedb.org/3/tv/{$movie_id}/season/{$season}?language=en-US",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
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
                    echo "cURL Error #:" . $err;
                    continue;
                }

                $data = json_decode($response, true);

                if (isset($data['episodes']) && is_array($data['episodes'])) {
                    foreach ($data['episodes'] as $episode) {
                        $air_date = $episode['air_date'];
                        $episode_number = $episode['episode_number'];
                        $season_number = $episode['season_number'];

                        $fetch_old_query = "SELECT * FROM seasons WHERE movieName = '$movie_name' AND episode_number = '$episode_number' AND season_number = '$season_number'";
                        $fetch_old = mysqli_query($connection, $fetch_old_query);

                        if (mysqli_num_rows($fetch_old) == 0) {
                            $insert_query = "INSERT INTO seasons (movieId, full_name, movieName, movieType, season_number, episode_number, air_date, imageUrl, created_at) VALUES ('$movie_id', '$full_name', '$movie_name', '$movie_type', '$season_number', '$episode_number', '$air_date', '$movie_image', NOW())";
                            $insert = mysqli_query($connection, $insert_query);

                            if ($insert) {
                                echo "Seasons added successfully";
                            } else {
                                echo "Failed to add seasons: " . mysqli_error($connection);
                            }
                        } else {
                            echo "Season already in database";
                        }
                    }
                }
            }
        }

        mysqli_close($connection);
    }
}
