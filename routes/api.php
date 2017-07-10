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
Route::group(['prefix' => 'v1'], function(){
  Route::get('/', 'Api\v1\RankMePublic@home');
  Route::get('/players', 'Api\v1\RankMePublic@listAllPlayers');
  Route::get('/players/paginate', 'Api\v1\RankMePublic@listAllPaginate');
  Route::get('/player/{id}', 'Api\v1\RankMePublic@listPlayer');

});
