<?php

namespace App\Http\Controllers;

use Google\Client;
use App\Models\Movies;
use App\Models\Series;
use App\Models\Seasons;
use App\Jobs\getSeasons;
use Google\Service\YouTube;
use App\Jobs\FetchMovieData;
use Illuminate\Http\Request;
use App\Jobs\FetchSeriesData;
use App\Jobs\UpdateMoviesInfo;
use App\Jobs\UpdateSeriesInfo;
use Illuminate\Support\Carbon;
use App\Jobs\UpdateMoviesTrailer;
use App\Jobs\UpdateSeriesTrailer;
use App\Jobs\UpdateMoviesTrailerV2;
use App\Jobs\UpdateSeriesTrailerV2;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{

    public function seriesV1()
    {

        FetchSeriesData::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    public function moviesV2()
    {

        FetchMovieData::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    public function updateMoviesInfo()
    {

        UpdateMoviesInfo::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    public function updateSeriesInfo()
    {

        UpdateSeriesInfo::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    public function updateSeriesTrailer()
    {

        UpdateSeriesTrailer::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    public function updateSeriesTrailerV2()
    {

        UpdateSeriesTrailerV2::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    public function updateMoviesTrailer()
    {

        UpdateMoviesTrailer::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    public function updateMoviesTrailerV2()
    {

        UpdateMoviesTrailerV2::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }

    public function getSeasons()
    {
        

        getSeasons::dispatch();
        return redirect()->route('admin.dashboard')->with('status', 'Job Dispatched');
    }
}
