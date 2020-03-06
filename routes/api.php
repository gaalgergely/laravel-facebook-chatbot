<?php

use Illuminate\Http\Request;

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
    return \Thujohn\Twitter\Facades\Twitter::getTrendsAvailable();
});
Route::get('/twitter-trends-place', function () {
    return \Thujohn\Twitter\Facades\Twitter::getTrendsPlace(['id' => 628886]);
});
