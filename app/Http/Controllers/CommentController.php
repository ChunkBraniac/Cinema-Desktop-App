<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Top10;
use App\Models\Popular;
use App\Models\Streaming;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function comment(Request $request, $name, $type) // Include $type parameter
    {
        // Find the movie by name and type (using corrected logic from previous discussion)
        $movie = Top10::where('originalTitleText', $name)->where('titleType', $type)->first();
        if (!$movie) {
            $movie = Streaming::where('originalTitleText', $name)->where('titleType', $type)->first();
        }
        if (!$movie) {
            $movie = Popular::where('originalTitleText', $name)->where('titleType', $type)->first();
        }

        // Validate request and create comment
        $request->validate([
            'commentor' => 'required',
            'comment' => 'required'
        ]);

        $comment = new Comment([
            'commentor' => $request->commentor,
            'comment' => $request->comment,
            'comment_on' => $movie->movieId // Use movie ID for association
        ]);

        $comment->save();

        // Redirect back to the movie page with success message
        return redirect()->route('media.show', ['name' => $name, 'type' => $type])->with('success', 'Comment added successfully');
    }

}
