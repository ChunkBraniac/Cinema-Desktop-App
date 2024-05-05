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
        $series_all = Series::paginate(24)->sortByDesc('releaseDate');
        $movies_all = Movies::paginate(24)->sortByDesc('releaseDate');

        return view('home', compact('series_all', 'movies_all'));
    }

    public static function getAction()
    {
        // Determine the current page
        $page = request()->get('page', 1);

        // Define the number of items per page
        $perPage = 30;

        // Perform your query for each set of movies
        $actionMoviesSeries = Series::where('genres', 'like', '%Action%')->get();
        $actionMovies = Movies::where('genres', 'like', '%Action%')->get();

        // Merge the collections
        $allActionMovies = $actionMoviesSeries->merge($actionMovies);

        // Sort the merged collection
        $allActionMovies = $allActionMovies->sortByDesc('id');

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

        $animationMoviesSeries = Series::where('genres', 'like', '%Animation%')->paginate(9);
        $animationMovies = Movies::where('genres', 'like', '%Animation%')->paginate(9);

        $allAnimationMovies = $animationMoviesSeries->merge($animationMovies);
        $allAnimationMovies = $allAnimationMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.animation', compact('allAnimationMovies'));
    }

    public static function getComedy()
    {

        $comedyMoviesSeries = Series::where('genres', 'like', '%Comedy%')->paginate(20);
        $comedyMovies = Movies::where('genres', 'like', '%Comedy%')->paginate(20);

        $allComedyMovies = $comedyMoviesSeries->merge($comedyMovies);
        $allComedyMovies = $allComedyMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.comedy', compact('allComedyMovies'));
    }

    public static function getDrama()
    {

        $dramaMoviesSeries = Series::where('genres', 'like', '%Drama%')->paginate(10);
        $dramaMovies = Movies::where('genres', 'like', '%Drama%')->paginate(10);

        $allDramaMovies = $dramaMoviesSeries->merge($dramaMovies);
        $allDramaMovies = $allDramaMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.drama', compact('allDramaMovies'));
    }

    public static function getHorror()
    {

        $horrorMoviesSeries = Series::where('genres', 'like', '%Horror%')->paginate(10);
        $horrorMovies = Movies::where('genres', 'like', '%Horror%')->paginate(10);

        $allHorrorMovies = $horrorMoviesSeries->merge($horrorMovies);
        $allHorrorMovies = $allHorrorMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.horror', compact('allHorrorMovies'));
    }

    public static function getThriller()
    {

        $thrillerMoviesSeries = Series::where('genres', 'like', '%Thriller%')->paginate(10);
        $thrillerMovies = Movies::where('genres', 'like', '%Thriller%')->paginate(10);

        $allThrillerMovies = $thrillerMoviesSeries->merge($thrillerMovies);
        $allThrillerMovies = $allThrillerMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.thriller', compact('allThrillerMovies'));
    }

    public static function getScifi()
    {

        $scifiMoviesSeries = Series::where('genres', 'like', '%Science Fiction%')->paginate(10);
        $scifiMovies = Movies::where('genres', 'like', '%Science Fiction%')->paginate(10);

        $allScifiMovies = $scifiMoviesSeries->merge($scifiMovies);
        $allScifiMovies = $allScifiMovies->sortByDesc('created_at'); // Or any sorting criteria

        return view('page.scifi', compact('allScifiMovies'));
    }

    public static function show($name, $type)
    {
        $cache = "recommend_" . $name;

        $recom = Cache::get($cache);

        if (!$recom) {

            $recommend = DB::table('series')->where('aggregateRating', '>', '7')->where('originalTitleText', '<>', $name)->inRandomOrder()->limit(9)->get();
            $recommend2 = DB::table('movies')->where('aggregateRating', '>', '7')->where('originalTitleText', '<>', $name)->inRandomOrder()->limit(9)->get();

            $recom = $recommend->union($recommend2);

            Cache::put($cache, $recom, 60);

        }

        $media = DB::table('series')
            ->where('originalTitleText', $name)
            ->where('titleType', $type)
            ->get();

        $media2 = DB::table('movies')
            ->where('originalTitleText', $name)
            ->where('titleType', $type)
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

        return view('media.show', compact('all', 'type', 'merged', 'recom', 'seasons', 'comments', 'replies'));
    }

    public static function search(Request $request)
    {

        $searchWord = $request->input('search');

        if (!$searchWord) {
            return redirect()->back()->with('error', 'Please enter a search word');
        }

        $SeriesResults = Series::where('originalTitleText', 'like', "%$searchWord%")->orderBy('id', 'Desc')->get();
        $MoviesResults = Movies::where('originalTitleText', 'like', "%$searchWord%")->orderBy('id', 'Desc')->get();

        $allResults = $SeriesResults->concat($MoviesResults);

        $page = LengthAwarePaginator::resolveCurrentPage() ?: 1;

        // Items per page
        $perPage = 24;

        // Slice the collection to get the items to display in current page
        $currentPageResults = $allResults->slice(($page * $perPage) - $perPage, $perPage)->values();

        // Create our paginator and add it to the view
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($allResults), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        return view('components.search', compact('paginatedResults', 'SeriesResults', 'MoviesResults'));
    }

    public static function showMore()
    {
        $more_Movies = Movies::paginate(36);
        $more_Series = Series::paginate(36);

        return view('components.show-more', compact('more_Movies', 'more_Series'));
    }
}
