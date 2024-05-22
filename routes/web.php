<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SeasonsController;

Route::get('/', [PageController::class, 'home'])->name('home.page');

// page routes
Route::get('/', [MoviesController::class, 'getAll'])->name('movies.top10');
Route::get('action', [MoviesController::class, 'getAction'])->name('movies.action');
Route::get('animation', [MoviesController::class, 'getAnimation'])->name('movies.animation');
Route::get('comedy', [MoviesController::class, 'getComedy'])->name('movies.comedy');
Route::get('drama', [MoviesController::class, 'getDrama'])->name('movies.drama');
Route::get('fantasy', [MoviesController::class, 'getFantasy'])->name('movies.fantasy');
Route::get('horror', [MoviesController::class, 'getHorror'])->name('movies.horror');
Route::get('thriller', [MoviesController::class, 'getThriller'])->name('movies.thriller');
Route::get('mystery', [MoviesController::class, 'getMystery'])->name('movies.mystery');
Route::get('scifi', [MoviesController::class, 'getScifi'])->name('movies.scifi');

// 404 page
Route::get('404', [PageController::class, 'error'])->name('error.404');

Route::group(['middleware' => 'xframe'], function () {
    Route::get('/media/{name}/{type}', [MoviesController::class, 'show'])->name('media.show');
});

Route::get('search', [MoviesController::class, 'search'])->name('movie.search');

Route::post('media/{name}/{type}/comment', [CommentController::class, 'store'])->name('comment');
Route::post('media/{name}/{type}/reply', [ReplyController::class, 'reply'])->name('reply');

// Admin Routes
Route::get('admin/register', [AdminController::class, 'registerPage'])->name('admin.home.register');
Route::post('admin/register', [AdminController::class, 'register'])->name('register.admin');
Route::get('admin', [AdminController::class, 'loginPage'])->name('admin.home.login');
Route::post('admin', [AdminController::class, 'login'])->name('admin.login');

Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('admin/movies', [AdminController::class, 'movies'])->name('admin.all');
    Route::get('admin/comments', [AdminController::class, 'displayComments'])->name('admin.comments');

    // route to fetch the movies and series and other settings
    Route::get('admin/series/v1', [ApiController::class, 'seriesV1'])->name('seriesV1.api');
    Route::get('admin/series/v2', [ApiController::class, 'seriesV2'])->name('seriesV2.api');
    Route::get('admin/series/v3', [ApiController::class, 'seriesV3'])->name('seriesV3.api');

    // route to fetch the movies
    Route::get('admin/movies/v1', [ApiController::class, 'moviesV1'])->name('moviesV1.api');
    Route::get('admin/movies/v2', [ApiController::class, 'moviesV2'])->name('moviesV2.api');
    Route::get('admin/movies/v3', [ApiController::class, 'moviesV3'])->name('moviesV3.api');

    // update the movies and series
    Route::get('admin/update/movies', [ApiController::class, 'updateMoviesInfo'])->name('moviesUpdate.api');
    Route::get('admin/update/series', [ApiController::class, 'updateSeriesInfo'])->name('seriesUpdate.api');

    // update the trailer
    Route::get('admin/series/trailer', [ApiController::class, 'updateSeriesTrailer'])->name('series.trailer');
    Route::get('admin/movies/trailer', [ApiController::class, 'updateMoviesTrailer'])->name('movies.trailer');

    Route::post('admin/reset', [AdminController::class, 'reset'])->name('admin.reset');

    // get seasons
    Route::get('admin/seasons', [ApiController::class, 'getSeasons'])->name('admin.seasons');
});

// Download page
Route::get('download/{name}/season/{season}/episode/{episode}', [SeasonsController::class, 'download'])->name('download');

Route::get('show-more', [MoviesController::class, 'showMore'])->name('moremovies');

