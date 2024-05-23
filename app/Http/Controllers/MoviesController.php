<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Movies;
use App\Models\Series;
use App\Models\Comment;
use App\Models\Seasons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class MoviesController extends Controller
{
    //
    public function getAll()
    {
        $series_all = Series::orderByDesc('releaseYear')->latest()->paginate(24);
        $movies_all = Movies::orderByDesc('releaseYear')->latest()->paginate(24);

        return view('home', compact('series_all', 'movies_all'));
    }

    public static function getAction()
    {
        // Perform your query for each set of movies
        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Action%')->get();
        $actionMovies = Movies::where('genres', 'like', '%Action%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.action', compact('paginatedResults', 'page'));
    }

    public static function getAnimation()
    {

        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Animation%')->get();
        $actionMovies = Movies::latest()->where('genres', 'like', '%Animation%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.animation', compact('paginatedResults', 'page'));
    }

    public static function getComedy()
    {

        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Comedy%')->get();
        $actionMovies = Movies::latest()->where('genres', 'like', '%Comedy%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.comedy', compact('paginatedResults', 'page'));
    }

    public static function getDrama()
    {

        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Drama%')->get();
        $actionMovies = Movies::latest()->where('genres', 'like', '%Drama%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.drama', compact('paginatedResults', 'page'));
    }

    public static function getFantasy()
    {

        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Fantasy%')->get();
        $actionMovies = Movies::latest()->where('genres', 'like', '%Fantasy%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.fantasy', compact('paginatedResults', 'page'));
    }

    public static function getHorror()
    {

        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Horror%')->get();
        $actionMovies = Movies::latest()->where('genres', 'like', '%Horror%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.horror', compact('paginatedResults', 'page'));
    }

    public static function getMystery()
    {

        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Mystery%')->get();
        $actionMovies = Movies::latest()->where('genres', 'like', '%Mystery%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.mystery', compact('paginatedResults', 'page'));
    }

    public static function getThriller()
    {

        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Thriller%')->get();
        $actionMovies = Movies::latest()->where('genres', 'like', '%Thriller%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.thriller', compact('paginatedResults', 'page'));
    }

    public static function getScifi()
    {

        $actionMoviesSeries = Series::latest()->where('genres', 'like', '%Science Fiction%')->get();
        $actionMovies = Movies::latest()->where('genres', 'like', '%Science Fiction%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('releaseYear');

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allActionMovies->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allActionMovies), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        // Pass the current page items, total pages, start page, end page, and current page to the view
        return view('page.scifi', compact('paginatedResults', 'page'));
    }

    public static function show($name)
    {
        
        $cache = "recommend_" . $name;

        $recom = Cache::get($cache);

        if (!$recom) {

            $recommend = DB::table('series')->where('aggregateRating', '>', '7')->where('originalTitleText', '<>', $name)->inRandomOrder()->limit(9)->get();
            $recommend2 = DB::table('movies')->where('aggregateRating', '>', '7')->where('originalTitleText', '<>', $name)->inRandomOrder()->limit(9)->get();

            $recom = $recommend->union($recommend2);

            Cache::put($cache, $recom, 360);

        }

        $media = DB::table('series')
            ->where('originalTitleText', $name)
            // ->where('titleType', $type)
            ->get();

        $media2 = DB::table('movies')
            ->where('originalTitleText', $name)
            // ->where('titleType', $type)
            ->get();

        $all = $media->union($media2);

        /* 
        the below code uses the same structure as above
        read it and understand it's workings
        */
        $cacheKey = "moreSeries_" . $name;

        $merged = Cache::get($cacheKey);

        if (!$merged) {
            $merged = DB::table('series')
                ->where('originalTitleText', '<>', $name)
                ->inRandomOrder()
                ->limit(2)
                ->get();

            $merged2 = DB::table('movies')
                ->where('originalTitleText', '<>', $name)
                ->inRandomOrder()
                ->limit(4)
                ->get();

            $merged = $merged->union($merged2);

            Cache::put($cacheKey, $merged, 160);
        }

        $seasons = Seasons::where('movieName', $name)->paginate(12);

        $comments = Comment::where('movie_name', $name)->get();

        // Initialize an array to store comment IDs
        $commentIds = [];

        // Loop through comments to extract comment IDs
        foreach ($comments as $comment) {
            $commentIds[] = $comment->id;
        }

        $replies = Reply::whereIn('comment_id', $commentIds)->get();

        return view('media.show', compact('all', 'merged', 'recom', 'seasons', 'comments', 'replies'));
    }

    public static function search(Request $request)
    {

        $searchWord = $request->input('search');

        if (!$searchWord) {
            return redirect()->back()->with('error', 'Please enter a search word');
        }

        $SeriesResults = Series::where('originalTitleText', 'like', "%$searchWord%")->orderBy('releaseYear', 'Desc')->get();
        $MoviesResults = Movies::where('originalTitleText', 'like', "%$searchWord%")->orderBy('releaseYear', 'Desc')->get();

        $allResults = $SeriesResults->concat($MoviesResults);

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 36;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allResults->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allResults), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        return view('components.search', compact('paginatedResults', 'SeriesResults', 'MoviesResults', 'page', 'searchWord'));
    }

    public static function showMore()
    {
        $more_Movies = Movies::orderByDesc('releaseYear')->paginate(36);
        $more_Series = Series::orderByDesc('releaseYear')->paginate(36);

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        return view('components.show-more', compact('more_Movies', 'more_Series', 'page'));
    }
}
