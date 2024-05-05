<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SeasonsController;
use App\Models\Api;

Route::get('/', [PageController::class, 'home']);
Route::get('top10', [PageController::class, 'series']);

Route::get('fetch', [ApiController::class, 'fetchMovies']);

// page routes
Route::get('action', [PageController::class, 'action']);
Route::get('animation', [PageController::class, 'animation']);
Route::get('comedy', [PageController::class, 'comedy']);
Route::get('drama', [PageController::class, 'drama']);
Route::get('horror', [PageController::class, 'horror']);
Route::get('thriller', [PageController::class, 'thriller']);
Route::get('scifi', [PageController::class, 'scifi']);


Route::get('/', [MoviesController::class, 'getAll'])->name('movies.top10');
Route::get('action', [MoviesController::class, 'getAction'])->name('movies.action');
Route::get('animation', [MoviesController::class, 'getAnimation'])->name('movies.animation');
Route::get('comedy', [MoviesController::class, 'getComedy'])->name('movies.comedy');
Route::get('drama', [MoviesController::class, 'getDrama'])->name('movies.drama');
Route::get('horror', [MoviesController::class, 'getHorror'])->name('movies.horror');
Route::get('thriller', [MoviesController::class, 'getThriller'])->name('movies.thriller');
Route::get('scifi', [MoviesController::class, 'getScifi'])->name('movies.scifi');

Route::group(['middleware' => 'xframe'], function() {
    Route::get('/media/{name}/{type}', [MoviesController::class, 'show'])->name('media.show');
});

Route::get('search', [MoviesController::class, 'search'])->name('movie.search');

Route::post('media/{name}/{type}/comment', [CommentController::class, 'store'])->name('comment');
Route::post('media/{name}/{type}/reply', [ReplyController::class, 'reply'])->name('reply');

// Admin Routes
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('admin/register', [AdminController::class, 'registerPage'])->name('admin.home.register');
Route::post('admin/register', [AdminController::class, 'register'])->name('register.admin');
Route::get('admin', [AdminController::class, 'loginPage'])->name('admin.home.login');
Route::post('admin', [AdminController::class, 'login'])->name('admin.login');

Route::group(['middleware' => 'admin'], function() {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('admin/movies', [AdminController::class, 'showMovies'])->name('admin.movies');
    Route::get('admin/movies', [AdminController::class, 'movies'])->name('admin.all');
    Route::get('admin/comments', [AdminController::class, 'displayComments'])->name('admin.comments');

    // route to fetch the movies and series and other settings
    Route::get('admin/series', [ApiController::class, 'fetchSeries'])->name('fetch.series');
    Route::get('admin/fetch', [ApiController::class, 'fetchMovies'])->name('fetch.movies');
    Route::get('admin/update', [ApiController::class, 'updateSeriesType'])->name('update.series');
    Route::get('admin/series/genre', [ApiController::class, 'updateSeriesGenre'])->name('update.series.genre');
    Route::get('admin/movies/genre', [ApiController::class, 'updateMoviesGenre'])->name('update.movies.genre');
    Route::get('admin/series/genre2', [ApiController::class, 'updateSeriesGenre2'])->name('update.series.genre');
    Route::get('admin/movies/genre2', [ApiController::class, 'updateMoviesGenre2'])->name('update.movies.genre');
    Route::get('admin/series/description', [ApiController::class, 'updateSeriesDescription'])->name('series.description');
    Route::get('admin/movies/description', [ApiController::class, 'updateMoviesDescription'])->name('movies.description');
    Route::get('admin/series/trailer', [ApiController::class, 'updateSeriesTrailer'])->name('series.trailer');
    Route::get('admin/movies/trailer', [ApiController::class, 'updateMoviesTrailer'])->name('movies.trailer');
    Route::get('admin/series/tmdb', [ApiController::class, 'getTmdbIdSeries'])->name('series.tmdb');
    Route::get('admin/series/seasons', [ApiController::class, 'getSeasons'])->name('series.seasons');
    Route::get('admin/series/seasons2', [ApiController::class, 'getSeriesSeasons'])->name('series.seasons.2');

    // popular movies
    Route::get('admin/popular', [ApiController::class, 'popularMovies'])->name('fetch.popular');
});

// Download page
Route::get('download/{name}/season/{season}/episode/{episode}', [SeasonsController::class, 'download'])->name('download');

Route::get('show-more', [MoviesController::class, 'showMore'])->name('moremovies');

