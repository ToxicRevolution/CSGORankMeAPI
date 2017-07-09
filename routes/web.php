<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
  // Returning blank view for / for now we will get back to that later.
    return view('home');
});
// V1 API Route group
$app->group(['prefix' => 'api/v1'], function () use ($app){
  // List all players
  $app->get('/players', 'Api\v1\RankMeWebMain@listPlayers');
  // List single players
  $app->get('player/{id}', 'Api\v1\RankMeWebMain@listPlayer');
});
