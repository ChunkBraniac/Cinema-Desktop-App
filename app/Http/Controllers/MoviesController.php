<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movies;
use App\Models\Reply;
use App\Models\Seasons;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
    //
    public function getAll()
    {
        $series_all = Series::where('status', '!=', 'pending')->orderByDesc('updated_at')->paginate(24);
        $movies_all = Movies::where('status', '!=', 'pending')->orderByDesc('updated_at')->paginate(18);

        $seasons = DB::table('seasons as s1')
            ->select('s1.*')
            ->join(DB::raw('(SELECT MAX(id) as id, movieId FROM seasons GROUP BY movieId ORDER BY episode_number DESC) as s2'), function ($join) {
                $join->on('s1.id', '=', 's2.id');
                $join->on('s1.movieId', '=', 's2.movieId');
            })
            ->latest('s1.id')
            ->paginate(9);

        return view('home', compact('series_all', 'movies_all', 'seasons'));
    }

    public static function getAction()
    {
        // Perform your query for each set of movies
        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Action%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->where('genres', 'like', '%Action%')->get();

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

        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Animation%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Animation%')->get();

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

        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Comedy%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Comedy%')->get();

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

        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Drama%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Drama%')->get();

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

        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Fantasy%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Fantasy%')->get();

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

        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Horror%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Horror%')->get();

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

        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Mystery%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Mystery%')->get();

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

        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Thriller%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Thriller%')->get();

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

        $actionMoviesSeries = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Science Fiction%')->get();
        $actionMovies = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Science Fiction%')->get();
        $actionMovies2 = Series::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Sci-Fi%')->get();
        $actionMovies3 = Movies::where('status', '!=', 'pending')->latest()->where('genres', 'like', '%Sci-Fi%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->concat($actionMovies)->concat($actionMovies2)->concat($actionMovies3);

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

        $cache = 'recommend_'.$name;

        $recom = Cache::get($cache);

        if (! $recom) {

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
        $cacheKey = 'moreSeries_'.$name;

        $merged = Cache::get($cacheKey);

        if (! $merged) {
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

        if (! $searchWord) {
            return redirect()->back()->with('error', 'Please enter a search word');
        }

        $SeriesResults = Series::where('status', '!=', 'pending')->where('full_name', 'LIKE', "%$searchWord%")->orderBy('releaseYear', 'Desc')->get();
        $MoviesResults = Movies::where('status', '!=', 'pending')->where('full_name', 'LIKE', "%$searchWord%")->orderBy('releaseYear', 'Desc')->get();

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
        $more_Movies = Movies::where('status', '!=', 'pending')->orderByDesc('releaseYear')->paginate(36);
        $more_Series = Series::where('status', '!=', 'pending')->orderByDesc('releaseYear')->paginate(36);

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        return view('components.show-more', compact('more_Movies', 'more_Series', 'page'));
    }

    public function showMoreSeries()
    {
        $more_Series = Series::where('status', '!=', 'pending')->orderByDesc('releaseYear')->paginate(36);
        $tv_series = Series::where('status', '!=', 'pending')->orderByDesc('releaseYear')->paginate(36);

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        return view('components.show-more-series', compact('more_Series', 'page'));
    }

    public function showMoreMovies()
    {
        $more_Series = Movies::where('status', '!=', 'pending')->orderByDesc('releaseYear')->paginate(36);

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        return view('components.show-more-movies', compact('more_Series', 'page'));
    }

    public function tv_series()
    {
        $tv_series = Series::where('status', '!=', 'pending')->orderByDesc('releaseYear')->paginate(36);

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        return view('others.tv-series', compact('tv_series', 'page'));
    }

    public function movies()
    {
        $movies = Movies::where('status', '!=', 'pending')->orderByDesc('releaseYear')->paginate(36);

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        return view('others.movies', compact('movies', 'page'));
    }
}
