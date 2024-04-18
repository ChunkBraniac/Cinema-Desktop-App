<?php

use App\Http\Controllers\CinemaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CinemaController::class, 'home']);
