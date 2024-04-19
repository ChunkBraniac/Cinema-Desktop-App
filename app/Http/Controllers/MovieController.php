<?php

namespace App\Http\Controllers;

use App\Models\Popular;
use App\Models\Streaming;
use App\Models\Top10;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    //
    public function getAll()
    {
        $top10 = Top10::all();

        $streaming = Streaming::all();
        $streaming = Streaming::paginate(6);

        $popular = Popular::all();
        $popular = Popular::paginate(6);

        return view('home', compact('top10', 'streaming', 'popular'));
    }

    public static function getAction()
    {

        $actionMoviesTop10 = Top10::where('genres', 'like', '%Action%')->paginate(9);
        $actionMovies = Streaming::where('genres', 'like', '%Action%')->paginate(9);
        $actionMoviesPopular = Popular::where('genres', 'like', '%Action%')->paginate(9);

        $allActionMovies = $actionMoviesTop10->merge($actionMovies->merge($actionMoviesPopular));
        $allActionMovies = $allActionMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.action', compact('allActionMovies'));
    }

    public static function getAnimation()
    {

        $animationMoviesTop10 = Top10::where('genres', 'like', '%Animation%')->paginate(9);
        $animationMovies = Streaming::where('genres', 'like', '%Animation%')->paginate(9);
        $animationMoviesPopular = Popular::where('genres', 'like', '%Animation%')->paginate(9);

        $allAnimationMovies = $animationMoviesTop10->merge($animationMovies->merge($animationMoviesPopular));
        $allAnimationMovies = $allAnimationMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.animation', compact('allAnimationMovies'));
    }

    public static function getComedy()
    {

        $comedyMoviesTop10 = Top10::where('genres', 'like', '%Comedy%')->paginate(20);
        $comedyMovies = Streaming::where('genres', 'like', '%Comedy%')->paginate(20);
        $comedyMoviesPopular = Popular::where('genres', 'like', '%Comedy%')->paginate(20);

        $allComedyMovies = $comedyMoviesTop10->merge($comedyMovies->merge($comedyMoviesPopular));
        $allComedyMovies = $allComedyMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.comedy', compact('allComedyMovies'));
    }

    public static function getDrama()
    {

        $dramaMoviesTop10 = Top10::where('genres', 'like', '%Drama%')->paginate(10);
        $dramaMovies = Streaming::where('genres', 'like', '%Drama%')->paginate(10);
        $dramaMoviesPopular = Popular::where('genres', 'like', '%Drama%')->paginate(10);

        $allDramaMovies = $dramaMoviesTop10->merge($dramaMovies->merge($dramaMoviesPopular));
        $allDramaMovies = $allDramaMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.drama', compact('allDramaMovies'));
    }

    public static function getHorror()
    {

        $horrorMoviesTop10 = Top10::where('genres', 'like', '%Horror%')->paginate(10);
        $horrorMovies = Streaming::where('genres', 'like', '%Horror%')->paginate(10);
        $horrorMoviesPopular = Popular::where('genres', 'like', '%Horror%')->paginate(10);

        $allHorrorMovies = $horrorMoviesTop10->merge($horrorMovies->merge($horrorMoviesPopular));
        $allHorrorMovies = $allHorrorMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.horror', compact('allHorrorMovies'));
    }

    public static function getThriller()
    {

        $thrillerMoviesTop10 = Top10::where('genres', 'like', '%Thriller%')->paginate(10);
        $thrillerMovies = Streaming::where('genres', 'like', '%Thriller%')->paginate(10);
        $thrillerMoviesPopular = Popular::where('genres', 'like', '%Thriller%')->paginate(10);

        $allThrillerMovies = $thrillerMoviesTop10->merge($thrillerMovies->merge($thrillerMoviesPopular));
        $allThrillerMovies = $allThrillerMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.thriller', compact('allThrillerMovies'));
    }

    public static function getScifi()
    {

        $scifiMoviesTop10 = Top10::where('genres', 'like', '%Science Fiction%')->paginate(10);
        $scifiMovies = Streaming::where('genres', 'like', '%Science Fiction%')->paginate(10);
        $scifiMoviesPopular = Popular::where('genres', 'like', '%Science Fiction%')->paginate(10);

        $allScifiMovies = $scifiMoviesTop10->merge($scifiMovies->merge($scifiMoviesPopular));
        $allScifiMovies = $allScifiMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.scifi', compact('allScifiMovies'));
    }


    public static function getMovie($id)
    {
        $series = Top10::find($id);

        //dd($movie);

        if ($series) {
            $isSeries = $series->isSeries;

            if ($isSeries == 1) {
                return view('top10.series', compact('series'));
            } else {
                return view('top10.show', compact('series'));
            }
        } else {
            return abort(404);
        }
    }


}

