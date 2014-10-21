<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
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

$server = new \League\OAuth2\Server\AuthorizationServer;

$server->setSessionStorage(new Storage\SessionStorage);
$server->setAccessTokenStorage(new Storage\AccessTokenStorage);
$server->setClientStorage(new Storage\ClientStorage);
$server->setScopeStorage(new Storage\ScopeStorage);
$server->setAuthCodeStorage(new Storage\AuthCodeStorage);

$authCodeGrant = new \League\OAuth2\Server\Grant\AuthCodeGrant();
$server->addGrantType($authCodeGrant);

Route::get('/', function()
{
	return 'hello world';
});
Route::get('/podcasts/{id}','PodcastController@showPodcast');
Route::get('/podcasts','PodcastController@showPodcasts');
Route::put('/podcast','PodcastController@addPodcast');
Route::post('/podcast','PodcastController@updatePodcast');

Route::get('/episode/{id}','EpisodeController@showEpisode');
Route::get('/episodes/','EpisodeController@showEpisodes');
Route::put('/episode','EpisodeController@addEpisode');
Route::post('/episode','EpisodeController@updateEpisode');

Route::get('/signin/',function(){
  if (Auth::check()){
    return View::make('loggedin');
  }else{
    return View::make('signin');
  }
});
Route::post('/auth/login', 'AuthController@login');
/*
Route::get('/auth/logout', 'AuthController@logout');
Route::get('/auth/status', 'AuthController@status');

Route::post('/auth/register', 'AuthController@register');

Route::get('/auth/test',function(){
  return Response::json(array(Auth::check());
});
*/