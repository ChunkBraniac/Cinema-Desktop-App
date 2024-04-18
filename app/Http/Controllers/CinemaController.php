<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CinemaController extends Controller
{
    //
    public static function home()
    {
        return view('home');
    }
}
