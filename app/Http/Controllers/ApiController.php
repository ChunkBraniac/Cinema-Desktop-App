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

        $page = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];

        foreach ($page as $pages) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/discover/tv?include_adult=false&include_null_first_air_dates=false&language=en-US&page={$pages}&sort_by=popularity.desc",
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

                    if ($year >= '2010' && $year <= '2024') {
                        $id = $result['id'];

                        // check if the series is already in the db

                        $fetch = mysqli_query($connection, "SELECT * FROM series WHERE movieId = '$id'");

                        if (mysqli_num_rows($fetch) == 0) {
                            $adult = $result['adult'];
                            $backdrop_path = isset($result['backdrop_path']) ? mysqli_real_escape_string($connection, $result['backdrop_path']) : 0;
                            $country = $result['origin_country'][0];
                            $language = strtoupper($result['original_language']);
                            $name = mysqli_real_escape_string($connection, $result['name']);
                            $overview = mysqli_real_escape_string($connection, $result['overview']);
                            $poster_path = mysqli_real_escape_string($connection, $result['poster_path']);
                            $vote_average = mysqli_real_escape_string($connection, $result['vote_average']);

                            $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
                            $formatted_name = str_replace(' ', '-', $name);

                            // insert into the series table
                            $insert = mysqli_query($connection, "INSERT INTO series (movieId, isAdult, originalTitleText, imageUrl, backdrop_path, country, language, plotText, releaseDate, releaseYear, aggregateRating, runtime, genres, trailer, titleType, created_at) VALUES ('$id', '$adult', '$formatted_name', '$base_url', '$backdrop_path', '$country', '$language', '$overview', '$first_air_date', '$year', '$vote_average', '', '', '', 'series', now())");
                        } else {
                            echo "Series already in database";
                        }
                    } else {
                        echo "Series not in range";
                    }
                }
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

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.themoviedb.org/3/trending/tv/day?language=en-US",
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

                if ($year >= '2010' && $year <= '2024') {
                    $id = $result['id'];

                    // check if the series is already in the db

                    $fetch = mysqli_query($connection, "SELECT * FROM series WHERE movieId = '$id'");

                    if (mysqli_num_rows($fetch) == 0) {
                        $adult = $result['adult'];
                        $backdrop_path = isset($result['backdrop_path']) ? mysqli_real_escape_string($connection, $result['backdrop_path']) : 0;
                        $language = strtoupper($result['original_language']);
                        $name = mysqli_real_escape_string($connection, $result['name']);
                        $overview = mysqli_real_escape_string($connection, $result['overview']);
                        $poster_path = mysqli_real_escape_string($connection, $result['poster_path']);
                        $vote_average = mysqli_real_escape_string($connection, $result['vote_average']);
                        $country = $result['origin_country'][0];

                        $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
                        $formatted_name = str_replace(' ', '-', $name);

                        // insert into the series table
                        $insert = mysqli_query($connection, "INSERT INTO series (movieId, isAdult, originalTitleText, imageUrl, backdrop_path, country, language, plotText, releaseDate, releaseYear, aggregateRating, runtime, genres, trailer, titleType, created_at) VALUES ('$id', '$adult', '$formatted_name', '$base_url', '$backdrop_path', '$country', '$language', '$overview', '$first_air_date', '$year', '$vote_average', '', '', '', 'series', now())");

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


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.themoviedb.org/3/discover/movie?include_adult=false&include_video=false&language=en-US&page=1&sort_by=popularity.desc",
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
                $release_date = mysqli_real_escape_string($connection, $result['release_date']);
                $year = substr($release_date, 0, 4); // Extract the first four characters

                if ($year >= '2010' && $year <= '2024') {
                    $id = $result['id'];

                    // check if the series is already in the db

                    $fetch = mysqli_query($connection, "SELECT * FROM movies WHERE movieId = '$id'");

                    if (mysqli_num_rows($fetch) == 0) {
                        $adult = $result['adult'];
                        $backdrop_path = isset($result['backdrop_path']) ? mysqli_real_escape_string($connection, $result['backdrop_path']) : 0;
                        $language = strtoupper($result['original_language']);
                        $name = mysqli_real_escape_string($connection, $result['title']);
                        $overview = mysqli_real_escape_string($connection, $result['overview']);
                        $poster_path = mysqli_real_escape_string($connection, $result['poster_path']);
                        $vote_average = mysqli_real_escape_string($connection, $result['vote_average']);

                        $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
                        $formatted_name = str_replace(' ', '-', $name);

                        // insert into the series table
                        $insert = mysqli_query($connection, "INSERT INTO movies (movieId, isAdult, originalTitleText, imageUrl, backdrop_path, country, language, plotText, releaseDate, releaseYear, aggregateRating, runtime, genres, trailer, titleType, created_at) VALUES ('$id', '$adult', '$formatted_name', '$base_url', '$backdrop_path', '', '$language', '$overview', '$release_date', '$year', '$vote_average', '', '', '', 'movie', now())");

                        if ($insert) {
                            echo "Movie added successfully";
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

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.themoviedb.org/3/trending/movie/day?language=en-US",
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
                $release_date = mysqli_real_escape_string($connection, $result['release_date']);
                $year = substr($release_date, 0, 4); // Extract the first four characters

                if ($year >= '2010' && $year <= '2024') {
                    $id = $result['id'];

                    // check if the series is already in the db

                    $fetch = mysqli_query($connection, "SELECT * FROM movies WHERE movieId = '$id'");

                    if (mysqli_num_rows($fetch) == 0) {
                        $adult = $result['adult'];
                        $backdrop_path = isset($result['backdrop_path']) ? mysqli_real_escape_string($connection, $result['backdrop_path']) : 0;
                        $language = strtoupper($result['original_language']);
                        $name = mysqli_real_escape_string($connection, $result['title']);
                        $overview = mysqli_real_escape_string($connection, $result['overview']);
                        $poster_path = mysqli_real_escape_string($connection, $result['poster_path']);
                        $vote_average = mysqli_real_escape_string($connection, $result['vote_average']);

                        $base_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
                        $formatted_name = str_replace(' ', '-', $name);

                        // insert into the series table
                        $insert = mysqli_query($connection, "INSERT INTO movies (movieId, isAdult, originalTitleText, imageUrl, backdrop_path, country, language, plotText, releaseDate, releaseYear, aggregateRating, runtime, genres, trailer, titleType, created_at) VALUES ('$id', '$adult', '$formatted_name', '$base_url', '$backdrop_path', '', '$language', '$overview', '$release_date', '$year', '$vote_average', '', '', '', 'movie', now())");

                        if ($insert) {
                            echo "Movie added successfully";
                        } else {
                            echo "Failed to add movie";
                        }

                    } else {
                        echo "Movie already in database";
                    }
                } else {
                    echo "Movie not in range";
                }
            }
        }
    }

    public function seriesV3()
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

        $page = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30];

        foreach ($page as $pages) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/tv/airing_today?language=en-US&{$pages}",
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
                foreach ($data['results'] as $results) {
                    $id = $results['id'];

                    // check if the id is already in the database
                    $get_ids = mysqli_query($connection, "SELECT * FROM series");

                    while ($ids = mysqli_fetch_assoc($get_ids)) {
                        $adult = $results['false'];
                        $backdrop_path = $results['backdrop_path'];
                        $origin_country = $results['origin_country'][0];
                        
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

                $origin_country = $data['origin_country'][0];
                $runtime = $data['runtime'];

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
                    echo "Movie updated successfully";
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
                    echo "Movie updated successfully";
                }
            }
        }
    }
}
