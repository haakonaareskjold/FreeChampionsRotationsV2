<?php

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

use Illuminate\Support\Facades\Route;
use App\Models\FreeChampionRotation;

Route::get('/getchampions', static function() {
    return FreeChampionRotation::query()->get('champions')->firstOrFail();
});
