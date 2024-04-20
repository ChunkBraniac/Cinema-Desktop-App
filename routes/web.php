<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Top10Controller;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [MovieController::class, 'getAll'])->name('movies.top10');
Route::get('action', [MovieController::class, 'getAction'])->name('movies.action');
Route::get('animation', [MovieController::class, 'getAnimation'])->name('movies.animation');
Route::get('comedy', [MovieController::class, 'getComedy'])->name('movies.comedy');
Route::get('drama', [MovieController::class, 'getDrama'])->name('movies.drama');
Route::get('horror', [MovieController::class, 'getHorror'])->name('movies.horror');
Route::get('thriller', [MovieController::class, 'getThriller'])->name('movies.thriller');
Route::get('scifi', [MovieController::class, 'getScifi'])->name('movies.scifi');

Route::get('top10/{name}', [MovieController::class, 'getMovie']);
Route::get('streaming/{name}', [MovieController::class, 'getStreams']);
