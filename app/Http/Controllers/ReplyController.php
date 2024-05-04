<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    //
    public function reply(Request $request, $name, $type)
    {

        $request->validate([
            'reply_name' => 'required|string',
            'reply_text' => 'required|string',
            'comment_id',
            'movie_name',
            'movie_id'
        ]);

        $reply = new Reply([
            'comment_id' => $request->comment_id,
            'reply_name' => $request->reply_name,
            'reply_text' => $request->reply_text,
            'movie_id' => $request->movie_id,
            'movie_name' => $request->movie_name
        ]);

        $reply->save();

        return redirect()->route('media.show', ['name' => $name, 'type' => $type])->with('success', 'Comment added successfully');
    }
}
