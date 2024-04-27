<?php

namespace App\Http\Controllers;

use App\Models\Movies;
use App\Models\Series;
use App\Models\Seasons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MoviesController extends Controller
{
    //
    public function getAll()
    {
        $series_all = Series::paginate(6)->sortByDesc('releaseDate');
        $movies_all = Movies::paginate(6)->sortByDesc('releaseDate');

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

        /*
            fetching recommended movies

            This code snippet represents a caching mechanism in Laravel to retrieve and display recommended content. Here's a breakdown of the process:

            **1. Cache Key Generation:**

            - The code starts by creating a cache key using string concatenation. The variable `$name` is likely used to identify a specific user or context for the recommendations. The key is constructed as `"recommend_" . $name` (e.g., "recommend_user123").

            **2. Checking the Cache:**

            - It then attempts to retrieve data from the Laravel cache using the `Cache::get($cache)` method. This method takes the cache key (`$cache`) as an argument and returns the cached data if it exists, or `null` otherwise.

            **3. Processing If No Cache Exists:**

            - If the cache lookup returns `null` (meaning there's no cached data for the given key), the code proceeds to fetch recommendations from the database:
            - Three separate queries are executed:
                - One fetches recommendations from the `Series` model.
                - Another fetches recommendations from the `Movies` model.
                - The last one fetches recommendations from the `Popular` model.
            - Each query filters for items with an `aggregateRating` greater than 7 and applies `inRandomOrder` to randomize the results.
            - The `paginate(4)` method is used on each query to retrieve only the first 4 results (this can be customized).
            - The results from these three queries are then merged together using the `merge` method, creating a single collection of recommendations.

            **4. Caching the Results:**

            - The merged collection of recommendations is stored in the cache using the `Cache::put($cache, $recom, 60)` method:
            - The first argument (`$cache`) is the same cache key used earlier.
            - The second argument (`$recom`) is the collection of recommendations to be cached.
            - The third argument (`60`) specifies the cache duration in minutes (here, 60 minutes). This means the recommendations will be kept in cache for 1 hour before being refreshed.

            **5. Returning the Recommendations:**

            - Presumably, the `$recom` variable (containing the cached or fetched recommendations) would be used in your application to display them to the user.

            **Overall, this code snippet improves performance by efficiently retrieving recommendations. If the recommendations haven't changed within the past hour, they'll be retrieved from the cache, saving database queries. Otherwise, fresh recommendations will be fetched and cached for future use.**
        */
        $cache = "recommend_" . $name;

        $recom = Cache::get($cache);

        if (!$recom) {
            // $recommend = Series::where('aggregateRating', '>', '7')->inRandomOrder()->limit(1);
            // $recommend2 = Movies::where('aggregateRating', '>', '7')->inRandomOrder()->limit(1);
            // $recommend3 = Popular::where('aggregateRating', '>', '7')->inRandomOrder()->limit(1);

            $recommend= DB::table('series')->where('aggregateRating', '>', '7')->where('originalTitleText', '<>', $name)->inRandomOrder()->limit(9)->get();
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

            Cache::put($cacheKey, $merged, 60);
        }

        $seasons = Seasons::where('movieName', $name)->get();

        return view('media.show', compact('all', 'type', 'merged', 'recom', 'seasons'));
    }

    public static function search(Request $request)
    {

        /*
            This code handles a search request in Laravel:

            1. **Retrieves Search Term:** It grabs the "search" input from the user's request using `$request->input('search')`.

            2. **Validates Search Term:** If no search term is provided (`!$searchWord`), it redirects the user back with an error message.

            3. **Performs Separate Searches:** It executes three separate database searches:
            - One for `Series` models.
            - Another for `Movies` models.
            - The last one for `Popular` models.
            - Each search uses `like` with wildcards (`%`) to search for titles containing the search word.
            - They are distinct (`distinct`) to avoid duplicates and ordered by ID in descending order (`Desc`).
            - Each search is paginated with a specific number of results (e.g., 15 for `Series`).

            4. **Merges Results:** It combines all results from the three searches into a single `$allResults` collection using `merge`.

            5. **Passes Data to View:** It returns a view named "search" and passes the following data:
            - `allResults`: The merged collection of all search results.
            - Individual results for each category (optional for further processing in the view).

            In summary, this code validates a search term, performs separate searches across different models, combines the results, and sends them to a view for display. 
        */

        $searchWord = $request->input('search');

        if (!$searchWord) {
            return redirect()->back()->with('error', 'Please enter a search word');
        }

        $SeriesResults = Series::where('originalTitleText', 'like', "%$searchWord%")->distinct()->orderBy('id', 'Desc')->paginate(15);
        $MoviesResults = Movies::where('originalTitleText', 'like', "%$searchWord%")->distinct()->orderBy('id', 'Desc')->paginate(15);

        $allResults = $SeriesResults->merge($MoviesResults);

        return view('components.search', compact('allResults', 'SeriesResults', 'MoviesResults'));
    }

    public static function seriesUpdate() {
        // Fetch all entries where titleType is 'tvMiniSeries'
        $updateSeries = Series::where('titleType', 'tvMiniSeries')->get();

        $merge = $updateSeries;
    
        // Loop through each entry and update titleType
        foreach ($merge as $series) {
            $series->titleType = "series";
            $series->save();
        }

        // second merge
        $change = Series::where('titleType', 'tvSeries')->get();

        $mergeChange = $change;

        foreach ($mergeChange as $new) {
            $new->titleType = "series";
            $new->save();
        }
    
        return view('dummy');
    }

    public static function showMore()
    {
        $more_Movies = Movies::paginate(36);
        $more_Series = Series::paginate(36);

        return view('components.show-more', compact('more_Movies', 'more_Series'));
    }
}
