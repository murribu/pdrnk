<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return 'helloasdf world';
});
Route::get('/podcast/{id}', function($id){
  //if ($id == ""){
    $podcasts = Podcast::all();
  //}
  return Response::json(array($id,$podcasts));
});
Route::get('/podcasts','PodcastController@showPodcasts');
Route::put('/podcast','PodcastController@addPodcast');