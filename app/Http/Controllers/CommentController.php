<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Top10;
use App\Models\Popular;
use App\Models\Streaming;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request, $name)
    {
        $request->validate([
            'commentor' => 'required|string',
            'comment' => 'required|string',
            'movie_id',
            'movie_name',
        ]);

        $storeComment = new Comment([
            'commentor' => $request->commentor,
            'comment' => $request->comment,
            'movie_id' => $request->movie_id,
            'movie_name' => $request->movie_name
        ]);

        $storeComment->save();

        return redirect()->route('media.show', ['name' => $name])->with('success', 'Comment added successfully');
    }

}
