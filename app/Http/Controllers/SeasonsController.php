<?php

namespace App\Http\Controllers;

use App\Models\Seasons;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    //
    public static function download($name, $season, $episode)
    {
        $db = Seasons::where('movieName', $name)->where('season_number', $season)->where('episode_number', $episode)->get();
        
        return view('download', compact('db'));
    }
}
