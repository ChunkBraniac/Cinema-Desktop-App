<?php

namespace App\Http\Controllers;

use App\Models\MovieRequest;
use Illuminate\Http\Request;

class MovieRequestController extends Controller
{
    //
    public function create()
    {
        return view('components.movie-request');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'movie_title' => 'required|string',
            'comment' => 'required|string'
        ]);

        if (MovieRequest::create($request->all())) {
            return redirect()->route('request.movie')->with('success', 'Your request has been sent. Admins will review your request and you will be notified once it has been processed. Thank you for your suggestion');
        }
    }
}
