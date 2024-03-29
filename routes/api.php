<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/track', [TrackController::class, 'getTrack']);

Route::get('/albums', [AlbumController::class, 'getAlbums']);
