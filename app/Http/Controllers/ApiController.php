<?php

namespace App\Http\Controllers;

use Google\Client;
use App\Models\Movies;
use App\Models\Series;
use App\Models\Seasons;
use Google\Service\YouTube;
use App\Jobs\FetchMovieData;
use Illuminate\Http\Request;
use App\Jobs\FetchSeriesData;
use App\Jobs\getSeasons;
use App\Jobs\UpdateMoviesInfo;
use App\Jobs\UpdateMoviesTrailer;
use App\Jobs\UpdateMoviesTrailerV2;
use App\Jobs\UpdateSeriesInfo;
use App\Jobs\UpdateSeriesTrailer;
use App\Jobs\UpdateSeriesTrailerV2;
use Illuminate\Support\Carbon;

class ApiController extends Controller
{

    public function seriesV1()
    {

        FetchSeriesData::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }

    public function moviesV2()
    {

        FetchMovieData::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }

    public function updateMoviesInfo()
    {

        UpdateMoviesInfo::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }

    public function updateSeriesInfo()
    {

        UpdateSeriesInfo::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }

    public function updateSeriesTrailer()
    {

        UpdateSeriesTrailer::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }

    public function updateSeriesTrailerV2()
    {

        UpdateSeriesTrailerV2::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }

    public function updateMoviesTrailer()
    {

        UpdateMoviesTrailer::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }

    public function updateMoviesTrailerV2()
    {

        UpdateMoviesTrailerV2::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }

    public function getSeasons()
    {

        getSeasons::dispatch();
        return response()->json(['status' => 'Job dispatched']);
    }
}
