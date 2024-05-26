<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\YouTube;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{

    public function seriesV1()
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

        $page = [1];
        $minRuntime = 60; // Minimum runtime in minutes to exclude short films
        $date = date('Y-m-d');

        foreach ($page as $pages) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/tv/airing_today?include_adult=false&include_video=false&language=en-US&page={$pages}&release_date.lte=$date&region=US",
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
                    $first_air_date = mysqli_real_escape_string($connection, $result['first_air_date']);
                    $year = substr($first_air_date, 0, 4); // Extract the first four characters
                    $full_name = mysqli_real_escape_string($connection, $result['name']);

                    if ($year >= '2020' && $first_air_date <= $date) {
                        $id = $result['id'];

                        // check if the series is already in the db

                        $fetch = mysqli_query($connection, "SELECT * FROM series WHERE movieId = '$id'");

                        if (mysqli_num_rows($fetch) == 0) {

                            $adult = $result['adult'];
                            $backdrop_path = isset($result['backdrop_path']) ? mysqli_real_escape_string($connection, $result['backdrop_path']) : 0;
                            $country = isset($result['origin_country'][0]) ? $result['origin_country'][0] : null;
                            $language = strtoupper($result['original_language']);
                            $full_name = mysqli_real_escape_string($connection, $result['name']);
                            $name = mysqli_real_escape_string($connection, $result['name'] . ' ' . $id);
                            $overview = mysqli_real_escape_string($connection, $result['overview']);
                            $poster_path = mysqli_real_escape_string($connection, $result['poster_path']);
                            $vote_average = mysqli_real_escape_string($connection, $result['vote_average']);

                            $base_url = "";
                            if ($poster_path) {
                                $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
                            } else {
                                $base_url = "";
                            }

                            $formatted_name = str_replace([' ', '?', '¿'], '-', $name);
                            $rating = floor($vote_average * 10) / 10;

                            // insert into the latest table
                            $insert_latest = mysqli_query($connection, "INSERT INTO series (movieId, isAdult, full_name, originalTitleText, imageUrl, backdrop_path, country, language, plotText, releaseDate, releaseYear, aggregateRating, titleType, runtime, genres, trailer, status, created_at) VALUES ('$id', '$adult', '$full_name', '$formatted_name', '$base_url', '$backdrop_path', '$country', '$language', '$overview', '$first_air_date', '$year', '$rating', 'series', '', '', '', 'pending', now())");

                            if ($insert_latest) {
                                echo $full_name . " - has been added successfully" . "<br>";
                            } else {
                                echo "Failed to add " . $full_name . "<br>";
                            }
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

    public function seriesV2()
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
        $minRuntime = 60; // Minimum runtime in minutes to exclude short films
        $date = date('Y-m-d');

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.themoviedb.org/3/trending/tv/day?language=en-US&page=1&with_runtime.gte={$minRuntime}&release_date.lte=$date",
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
                $first_air_date = mysqli_real_escape_string($connection, $result['first_air_date']);
                $year = substr($first_air_date, 0, 4); // Extract the first four characters

                if ($year >= '2020' && $year <= '2024') {
                    $id = $result['id'];

                    // check if the series is already in the db

                    $fetch = mysqli_query($connection, "SELECT * FROM series WHERE movieId = '$id'");

                    if (mysqli_num_rows($fetch) == 0) {

                        // check if the series is already in the latest series table
                        $adult = $result['adult'];
                        $backdrop_path = isset($result['backdrop_path']) ? mysqli_real_escape_string($connection, $result['backdrop_path']) : 0;
                        $language = strtoupper($result['original_language']);
                        $full_name = mysqli_real_escape_string($connection, $result['name']);
                        $name = mysqli_real_escape_string($connection, $result['name'] . ' ' . $id);
                        $overview = mysqli_real_escape_string($connection, $result['overview']);
                        $poster_path = mysqli_real_escape_string($connection, $result['poster_path']);
                        $vote_average = mysqli_real_escape_string($connection, $result['vote_average']);
                        $country = $result['origin_country'][0];

                        $base_url = "";
                        if ($poster_path) {
                            $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
                        } else {
                            $base_url = "";
                        }
                        $formatted_name = str_replace([' ', '?'], '-', $name);
                        $rating = floor($vote_average * 10) / 10;

                        // insert into the series table
                        $insert = mysqli_query($connection, "INSERT INTO series (movieId, isAdult, full_name, originalTitleText, imageUrl, backdrop_path, country, language, plotText, releaseDate, releaseYear, aggregateRating, titleType, runtime, genres, trailer, status, created_at) VALUES ('$id', '$adult', '$full_name', '$formatted_name', '$base_url', '$backdrop_path', '$country', '$language', '$overview', '$first_air_date', '$year', '$rating', 'series', '', '', '', 'pending', now())");

                        if ($insert) {
                            echo "Series added successfully";
                        } else {
                            echo "Failed to add movie";
                        }
                    } else {
                        echo "Series already in database";
                    }
                } else {
                    echo "Series not in range";
                }
            }
        }
    }

    public function moviesV1()
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

        $page = [1];

        $minRuntime = 60; // Minimum runtime in minutes to exclude short films
        $date = date('Y-m-d');

        foreach ($page as $pages) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/movie/now_playing?include_adult=false&include_video=false&language=en-US&page={$pages}&with_runtime.gte={$minRuntime}&release_date.lte=$date",
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
                    $release_date = mysqli_real_escape_string($connection, isset($result['release_date']) ? $result['release_date'] : 0);
                    $year = substr($release_date, 0, 4); // Extract the first four characters
                    $full_name = mysqli_real_escape_string($connection, $result['title']);

                    if ($year >= '2020' && $release_date <= $date) {
                        $id = $result['id'];

                        // check if the series is already in the db

                        $fetch = mysqli_query($connection, "SELECT * FROM movies WHERE movieId = '$id'");

                        if (mysqli_num_rows($fetch) == 0) {
                            $adult = $result['adult'];
                            $date = date('Y-m-d');
                            $backdrop_path = isset($result['backdrop_path']) ? mysqli_real_escape_string($connection, $result['backdrop_path']) : 0;
                            $language = strtoupper($result['original_language']);
                            $full_name = mysqli_real_escape_string($connection, $result['title']);
                            $name = mysqli_real_escape_string($connection, $result['title'] . ' ' . $id);
                            $overview = mysqli_real_escape_string($connection, $result['overview']);
                            $poster_path = mysqli_real_escape_string($connection, $result['poster_path']);
                            $vote_average = mysqli_real_escape_string($connection, $result['vote_average']);

                            $base_url = "";
                            if ($poster_path) {
                                $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
                            } else {
                                $base_url = "";
                            }
                            $formatted_name = str_replace(' ', '-', $name);
                            $rating = floor($vote_average * 10) / 10;

                            // insert into the series table
                            $insert = mysqli_query($connection, "INSERT INTO movies (movieId, isAdult, full_name, originalTitleText, imageUrl, backdrop_path, country, language, plotText, releaseDate, releaseYear, aggregateRating, titleType, runtime, genres, trailer, download_url, status, created_at) VALUES ('$id', '$adult', '$full_name', '$formatted_name', '$base_url', '$backdrop_path', '', '$language', '$overview', '$release_date', '$year', '$rating', 'movie', '', '', '', '', 'pending', now())");

                            if ($insert) {
                                echo $full_name . ": has been added successfully" . "<br>";
                            } else {
                                echo "Failed to add " . $full_name . "<br>";
                            }
                        } else {
                            echo $full_name . ": already in database" . "<br>";
                        }
                    } else {
                        echo $full_name . ": not in range" . "<br>";
                    }
                }
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

        $page = [1];
        $minRuntime = 60; // Minimum runtime in minutes to exclude short films
        $date = date('Y-m-d');

        foreach ($page as $pages) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/trending/movie/day?language=en-US&page={$pages}&with_runtime.gte={$minRuntime}&release_date.lte=$date",
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
                    $release_date = mysqli_real_escape_string($connection, isset($result['release_date']) ? $result['release_date'] : 0);
                    $year = substr($release_date, 0, 4); // Extract the first four characters
                    $full_name = mysqli_real_escape_string($connection, $result['title']);

                    if ($year >= '2013' && $release_date <= $date) {
                        $id = $result['id'];

                        // check if the series is already in the db

                        $fetch = mysqli_query($connection, "SELECT * FROM movies WHERE movieId = '$id'");

                        if (mysqli_num_rows($fetch) == 0) {
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

                            // insert into the series table
                            $insert = mysqli_query($connection, "INSERT INTO movies (movieId, isAdult, full_name, originalTitleText, imageUrl, backdrop_path, country, language, plotText, releaseDate, releaseYear, aggregateRating, titleType, runtime, genres, trailer, download_url, status, created_at) VALUES ('$id', '$adult', '$full_name', '$formatted_name', '$base_url', '$backdrop_path', '', '$language', '$overview', '$release_date', '$year', '$rating', 'movie', '', '', '', '', 'pending', now())");

                            if ($insert) {
                                echo $full_name . " - has been added successfully" . "<br>";
                            } else {
                                echo "Failed to add movie " . $full_name . "<br>";
                            }
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

        $fetch = mysqli_query($connection, "SELECT * FROM movies");

        if (mysqli_num_rows($fetch) > 0) {
            while ($movie = mysqli_fetch_assoc($fetch)) {
                $id = $movie['movieId'];
                $movieId = $movie['id'];
                $movieName = $movie['full_name'];

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

                $runtime = $hours . ' ' . $hour . ' ' . $minutes . ' minutes';

                // update the movie in the database
                $update = mysqli_query($connection, "UPDATE movies SET genres = '$genres', country = '$origin_country', runtime = '$runtime' WHERE id = '$movieId'");

                if ($update) {
                    echo $movieName . " - updated successfully" . "<br>";
                }
            }
        }
    }

    public function updateSeriesInfo()
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

        $fetch = mysqli_query($connection, "SELECT * FROM series WHERE genres = ''");

        if (mysqli_num_rows($fetch) > 0) {
            while ($movie = mysqli_fetch_assoc($fetch)) {
                $id = $movie['movieId'];
                $movieId = $movie['id'];

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

                // $runtime = $data['last_episode_to_air']['runtime'];

                // $hours = intdiv($runtime, 60); // Integer division to get the number of hours
                // $minutes = $runtime % 60; // Modulus to get the remaining minutes

                // if ($hours > 1) {
                //     $hour = "hours";
                // } else {
                //     $hour = "hour";
                // }

                // $runtime = $hours . ' ' . $hour . ' ' . $minutes . ' minutes';

                // update the movie in the database
                $update = mysqli_query($connection, "UPDATE series SET genres = '$genres' WHERE id = '$movieId'");

                if ($update) {
                    echo "Series updated successfully";
                }
            }
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

        $fetch_trailer = mysqli_query($connection, "SELECT * FROM series WHERE trailer = ''");

        if (mysqli_num_rows($fetch_trailer) > 0) {

            // Create a Google_Client
            $client = new Client();
            $client->setApplicationName('CinemaHub');
            $client->setDeveloperKey('AIzaSyCUoGQhYzTPCkjEpYZvgyoFHqngLwibFiI');

            // Create a Google_Service_YouTube instance
            $youtube = new YouTube($client);

            // Fetch movies that don't have trailers
            $noTrailer = mysqli_query($connection, "SELECT * FROM series WHERE trailer = ''");

            if (mysqli_num_rows($noTrailer) > 0) {
                while ($nonTrailer = mysqli_fetch_assoc($noTrailer)) {
                    $movie_name = $nonTrailer['full_name'];

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
                        $updateTrailer = mysqli_query($connection, "UPDATE series SET trailer = '$videoTrailer' WHERE full_name = '$movieName'");
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
                    $movie_name = $nonTrailer['full_name'];

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
                        $updateTrailer = mysqli_query($connection, "UPDATE movies SET trailer = '$videoTrailer' WHERE full_name = '$movieName'");
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
            $movie_image = $data_info['imageUrl'];

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
                            $insert_query = "INSERT INTO seasons (movieId, movieName, movieType, season_number, episode_number, air_date, imageUrl, created_at) VALUES ('$movie_id', '$movie_name', '$movie_type', '$season_number', '$episode_number', '$air_date', '$movie_image', NOW())";
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
