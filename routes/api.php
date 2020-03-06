<?php

use Illuminate\Http\Request;
use Thujohn\Twitter\Facades\Twitter;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/webhook', 'MessengerController@webHook');
Route::post('/webhook', 'MessengerController@webHookPost');

/**
 * Test Twitter API
 */
Route::get('/twitter-trends', function () {
    return Twitter::getTrendsAvailable();
});
Route::get('/twitter-trends-locations', function () {
    return array_column(Twitter::getTrendsAvailable(), 'name', 'woeid');
});
Route::get('/twitter-trends-place', function () {
    return Twitter::getTrendsPlace(['id' => 628886]);
});
