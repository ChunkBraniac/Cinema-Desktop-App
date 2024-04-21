<?php

namespace App\Http\Controllers;

use App\Models\Top10;
use App\Models\Popular;
use App\Models\Streaming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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


    public static function getMovie($name)
    {
        $cacheKey = "moreTop10_" . $name;

        $top10 = Top10::where('originalTitleText', $name)->first();

        $moreTop10 = Cache::get($cacheKey);

        if (!$moreTop10) {
            $moreTop10 = Top10::where('originalTitleText', '<>', $name)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();
    
            Cache::put($cacheKey, $moreTop10, 60); // Cache for 1 minute
        }

        $isSeries2 = $moreTop10->first()->isSeries;

        //dd($movie);

        if ($top10 && $moreTop10) {
            $isSeries = $top10->isSeries;

            if ($isSeries == 1 && $isSeries2 == 1) {
                return view('top10.series', compact('top10', 'moreTop10'));
            } else {
                return view('top10.show', compact('top10', 'moreTop10'));
            }
        } else {
            return abort(404);
        }
    }

    public static function getStreams($name)
    {
        $cacheKey = "moreTop10_" . $name;

        $streaming = Streaming::where('originalTitleText', $name)->first();

        $moreTop10 = Cache::get($cacheKey);

        if (!$moreTop10) {
            $moreTop10 = Streaming::where('originalTitleText', '<>', $name)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();
    
            Cache::put($cacheKey, $moreTop10, 60); // Cache for 1 minute
        }

        $isSeries2 = $moreTop10->first()->isSeries;

        //dd($movie);

        if ($streaming && $moreTop10) {
            $isSeries = $streaming->isSeries;

            if ($isSeries == 1 && $isSeries2 == 1) {
                return view('streaming.series', compact('streaming', 'moreTop10'));
            } else {
                return view('streaming.show', compact('streaming', 'moreTop10'));
            }
        } else {
            return abort(404);
        }
    }

    public static function show($name, $type)
    {
        $cacheKey = "moreTop10_" . $name;

        $media = Top10::where('originalTitleText', $name)->where('titleType', $type)->first();

        $moreTop10 = Cache::get($cacheKey);

        if (!$moreTop10) {
            $moreTop10 = Top10::where('originalTitleText', '<>', $name)->inRandomOrder()->limit(4)->get();

            Cache::put($cacheKey, $moreTop10, 60);
        }

        if (!$media) {
            return abort(404);
        }

        return view('media.show', compact('media', 'type', 'moreTop10'));
    }
}

