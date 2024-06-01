<?php

// Define the namespace for this file

namespace App\Http\Controllers;

// Import the necessary classes
use App\Jobs\FetchMovieData;
use App\Jobs\FetchSeriesData;
use App\Jobs\getSeasons;
use App\Jobs\UpdateMoviesInfo;
use App\Jobs\UpdateMoviesTrailer;
use App\Jobs\UpdateMoviesTrailerV2;
use App\Jobs\UpdateSeriesInfo;
use App\Jobs\UpdateSeriesTrailer;
use App\Jobs\UpdateSeriesTrailerV2;
use App\Models\Seasons;
use App\Models\Series;

// Define the ApiController class which extends the base Controller class
class ApiController extends Controller
{
    // Define a method to fetch series data
    public function seriesV1()
    {
        // Dispatch the FetchSeriesData job
        FetchSeriesData::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    // Define a method to fetch movie data
    public function moviesV2()
    {
        // Dispatch the FetchMovieData job
        FetchMovieData::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    // Define a method to update movie information
    public function updateMoviesInfo()
    {
        // Dispatch the UpdateMoviesInfo job
        UpdateMoviesInfo::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    // Define a method to update series information
    public function updateSeriesInfo()
    {
        // Dispatch the UpdateSeriesInfo job
        UpdateSeriesInfo::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    // Define a method to update series trailer
    public function updateSeriesTrailer()
    {
        // Dispatch the UpdateSeriesTrailer job
        UpdateSeriesTrailer::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    // Define a method to update series trailer version 2
    public function updateSeriesTrailerV2()
    {
        // Dispatch the UpdateSeriesTrailerV2 job
        UpdateSeriesTrailerV2::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    // Define a method to update movie trailer
    public function updateMoviesTrailer()
    {
        // Dispatch the UpdateMoviesTrailer job
        UpdateMoviesTrailer::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    // Define a method to update movie trailer version 2
    public function updateMoviesTrailerV2()
    {
        // Dispatch the UpdateMoviesTrailerV2 job
        UpdateMoviesTrailerV2::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    // Define a method to get seasons
    public function getSeasons()
    {
        // Dispatch the getSeasons job
        getSeasons::dispatch();

        // Redirect to the admin dashboard with a status message
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }
}
