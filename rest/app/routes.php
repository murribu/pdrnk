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
	return 'helloaasdfsdf world';
});
Route::get('/podcasts/{id}','PodcastController@showPodcast');
Route::get('/podcasts','PodcastController@showPodcasts');
Route::put('/podcast','PodcastController@addPodcast');
Route::post('/podcast','PodcastController@updatePodcast');

Route::get('/episode/{id}','EpisodeController@showEpisode');
Route::get('/episodes/','EpisodeController@showEpisodes');
Route::put('/episode','EpisodeController@addEpisode');
Route::post('/episode','EpisodeController@updateEpisode');