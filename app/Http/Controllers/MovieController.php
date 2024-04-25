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
        // Determine the current page
        $page = request()->get('page', 1);

        // Define the number of items per page
        $perPage = 24;

        // Perform your query for each set of movies
        $actionMoviesTop10 = Top10::where('genres', 'like', '%Action%')->get();
        $actionMovies = Streaming::where('genres', 'like', '%Action%')->get();
        $actionMoviesPopular = Popular::where('genres', 'like', '%Action%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesTop10->merge($actionMovies)->merge($actionMoviesPopular);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('created_at');

        // Calculate the total number of pages
        $totalPages = ceil($allActionMovies->count() / $perPage);

        // Define the number of pages to display before and after the "..." separator
        $pagesToShow = 3;

        // Calculate the start and end page numbers to display
        $startPage = max(1, $page - $pagesToShow);
        $endPage = min($totalPages, $page + $pagesToShow);

        // Adjust the start and end page numbers if they are too close to the boundaries
        if ($startPage == 1) {
            $endPage = min($totalPages, $startPage + ($pagesToShow * 2));
        } elseif ($endPage == $totalPages) {
            $startPage = max(1, $endPage - ($pagesToShow * 2));
        }

        $currentPageItems = $allActionMovies
        ->slice(($page - 1) * $perPage, $perPage)
        ->values();

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.action', compact('totalPages', 'startPage', 'endPage', 'page', 'currentPageItems'));
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

    public static function show($name, $type)
    {
        $cacheKey = "moreTop10_" . $name;

        // $media = Top10::where('originalTitleText', $name)->where('titleType', $type)->get();
        // $media2 = Streaming::where('originalTitleText', $name)->where('titleType', $type)->get();
        // $media3 = Popular::where('originalTitleText', $name)->where('titleType', $type)->get();

        $media = DB::table('top10s')
            ->where('originalTitleText', $name)
            ->where('titleType', $type)
            ->get();

        $media2 = DB::table('streamings')
            ->where('originalTitleText', $name)
            ->where('titleType', $type)
            ->get();

        $media3 = DB::table('populars')
            ->where('originalTitleText', $name)
            ->where('titleType', $type)
            ->get();

        $all = $media->union($media2)->union($media3);

        $merged = Cache::get($cacheKey);

        if (!$merged) {
            // $merged = Top10::where('originalTitleText', '<>', $name)->inRandomOrder()->limit(2)->get();
            // $merged2 = Streaming::where('originalTitleText', '<>', $name)->inRandomOrder()->limit(1)->get();
            // $merged3 = Popular::where('originalTitleText', '<>', $name)->inRandomOrder()->limit(1)->get();
            $merged = DB::table('top10s')
                ->where('originalTitleText', '<>', $name)
                ->inRandomOrder()
                ->limit(2)
                ->get();

            $merged2 = DB::table('streamings')
                ->where('originalTitleText', '<>', $name)
                ->inRandomOrder()
                ->limit(4)
                ->get();

            $merged3 = DB::table('populars')
                ->where('originalTitleText', '<>', $name)
                ->inRandomOrder()
                ->limit(1)
                ->get();

            $merged = $merged->union($merged2)->union($merged3);

            Cache::put($cacheKey, $merged, 60);
        }

        return view('media.show', compact('all', 'type', 'merged'));
    }

    public static function search(Request $request)
    {
        $searchWord = $request->input('search');

        if (!$searchWord) {
            return redirect()->back()->with('error', 'Please enter a search word');
        }

        $top10Results = Top10::where('originalTitleText', 'like', "%$searchWord%")->distinct()->orderBy('id', 'Desc')->paginate(15);
        $streamingResults = Streaming::where('originalTitleText', 'like', "%$searchWord%")->distinct()->orderBy('id', 'Desc')->paginate(12);
        $popularResults = Popular::where('originalTitleText', 'like', "%$searchWord%")->distinct()->orderBy('id', 'Desc')->paginate(12);

        $allResults = $top10Results->merge($streamingResults)->merge($popularResults);

        return view('search', compact('allResults', 'top10Results', 'streamingResults', 'popularResults'));
    }
}

