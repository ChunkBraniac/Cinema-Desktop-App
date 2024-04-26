<?php

namespace App\Http\Controllers;

use App\Models\Top10;
use App\Models\Popular;
use App\Models\Seasons;
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
                - One fetches recommendations from the `Top10` model.
                - Another fetches recommendations from the `Streaming` model.
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
            // $recommend = Top10::where('aggregateRating', '>', '7')->inRandomOrder()->limit(1);
            // $recommend2 = Streaming::where('aggregateRating', '>', '7')->inRandomOrder()->limit(1);
            // $recommend3 = Popular::where('aggregateRating', '>', '7')->inRandomOrder()->limit(1);

            $recommend= DB::table('top10s')->where('aggregateRating', '>', '7')->where('originalTitleText', '<>', $name)->inRandomOrder()->limit(9)->get();
            $recommend2 = DB::table('streamings')->where('aggregateRating', '>', '7')->where('originalTitleText', '<>', $name)->inRandomOrder()->limit(9)->get();
            $recommend3 = DB::table('populars')->where('aggregateRating', '>', '7')->where('originalTitleText', '<>', $name)->inRandomOrder()->limit(9)->get();

            $recom = $recommend->union($recommend2)->union($recommend3);

            Cache::put($cache, $recom, 60);

        }

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

        /* 
        the below code uses the same structure as above
        read it and understand it's workings
        */
        $cacheKey = "moreTop10_" . $name;

        $merged = Cache::get($cacheKey);

        if (!$merged) {
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
            - One for `Top10` models.
            - Another for `Streaming` models.
            - The last one for `Popular` models.
            - Each search uses `like` with wildcards (`%`) to search for titles containing the search word.
            - They are distinct (`distinct`) to avoid duplicates and ordered by ID in descending order (`Desc`).
            - Each search is paginated with a specific number of results (e.g., 15 for `Top10`).

            4. **Merges Results:** It combines all results from the three searches into a single `$allResults` collection using `merge`.

            5. **Passes Data to View:** It returns a view named "search" and passes the following data:
            - `allResults`: The merged collection of all search results.
            - Individual results for each category (optional for further processing in the view).

            In summary, this code validates a search term, performs separate searches across different models, combines the results, and sends them to a view for display. 
        */
        if (isset($_GET['search'])) {
            $searchWord = $_GET['search'];
        }

        $top10Results = Top10::where('originalTitleText', 'LIKE', "%$searchWord%")->paginate(15);
        $streamingResults = Streaming::where('originalTitleText', 'LIKE', "%$searchWord%")->paginate(12);
        $popularResults = Popular::where('originalTitleText', 'LIKE', "%$searchWord%")->paginate(12);

        $allResults = $top10Results->merge($streamingResults)->merge($popularResults);

        return view('search', compact('allResults', 'top10Results', 'streamingResults', 'popularResults'));
    }

    public static function seriesUpdate() {
        // Fetch all entries where titleType is 'tvMiniSeries'
        $updateSeries = Top10::where('titleType', 'tvMiniSeries')->get();
        $updateSeries2 = Streaming::where('titleType', 'tvMiniSeries')->get();
        $updateSeries3 = Popular::where('titleType', 'tvMiniSeries')->get();

        $merge = $updateSeries->merge($updateSeries2)->merge($updateSeries3);
    
        // Loop through each entry and update titleType
        foreach ($merge as $series) {
            $series->titleType = "series";
            $series->save();
        }

        // second merge
        $change = Top10::where('titleType', 'tvSeries')->get();
        $change2 = Streaming::where('titleType', 'tvSeries')->get();
        $change3 = Popular::where('titleType', 'tvSeries')->get();

        $mergeChange = $change->merge($change2)->merge($change3);

        foreach ($mergeChange as $new) {
            $new->titleType = "series";
            $new->save();
        }
    
        return view('dummy');
    }

    public function download($name, $season, $episode)
    {
        $db1 = Seasons::where('movieName', $name)->where('season_number', $season)->where('episode_number', $episode);
        
        return view('download', compact('db1'));
    }
    
}

