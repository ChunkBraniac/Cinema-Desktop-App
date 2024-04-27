<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\Top10Controller;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SeasonsController;

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

Route::get('top10/{name}', [MoviesController::class, 'getMovie']);
Route::get('streaming/{name}', [MoviesController::class, 'getStreams']);

Route::group(['middleware' => 'xframe'], function() {
    Route::get('/media/{name}/{type}', [MoviesController::class, 'show'])->name('media.show');
});

Route::get('search', [MoviesController::class, 'search'])->name('movie.search');

Route::post('media/{name}/{type}', [CommentController::class, 'store'])->name('comment');

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
});

Route::get('update', [MoviesController::class, 'seriesUpdate']);

// Download page
Route::get('download/{name}/season/{season}/episode/{episode}', [SeasonsController::class, 'download'])->name('download');

Route::get('show-more', [MoviesController::class, 'showMore'])->name('moremovies');