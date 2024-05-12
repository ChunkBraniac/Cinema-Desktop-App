<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public static function home()
    {
        return view('home');
    }

    public static function series()
    {
        return view('top10.series');
    }

    public static function action()
    {
        return view('page.action');
    }

    public static function animation()
    {
        return view('page.animation');
    }

    public static function comedy()
    {
        return view('page.comedy');
    }

    public static function drama()
    {
        return view('page.drama');
    }

    public static function horror()
    {
        return view('page.horror');
    }

    public static function thriller()
    {
        return view('page.thriller');
    }

    public static function scifi()
    {
        return view('page.scifi');
    }

    public static function error()
    {
        return view('page.404');
    }
}
