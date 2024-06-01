<?php

namespace App\Http\Controllers;

use App\Models\Seasons;

class SeasonsController extends Controller
{
    //
    public static function download($name, $season, $episode)
    {
        $download_series = Seasons::where('movieName', $name)->where('season_number', $season)->where('episode_number', $episode)->get();

        return view('components.download', compact('download_series'));
    }
}
