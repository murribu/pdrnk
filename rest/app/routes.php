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

/*
use League\OAuth2\Server\Util\Request;
use League\OAuth2\Server\Util\SecureKey;
use League\OAuth2\Server\Storage;
use League\OAuth2\Server\Storage\ClientInterface;
use League\OAuth2\Server\Storage\ScopeInterface;
use League\OAuth2\Server\Grant\GrantTypeInterface;

$server = new \League\OAuth2\Server\AuthorizationServer;

$server->setSessionStorage(new Storage\SessionStorage);
$server->setAccessTokenStorage(new Storage\AccessTokenStorage);
$server->setClientStorage(new Storage\ClientStorage);
$server->setScopeStorage(new Storage\ScopeStorage);
$server->setAuthCodeStorage(new Storage\AuthCodeStorage);

$authCodeGrant = new \League\OAuth2\Server\Grant\AuthCodeGrant();
$server->addGrantType($authCodeGrant);
*/

Route::get('/', function(){
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

Route::post('oauth/access_token', 'OAuthController@accessToken');
Route::get('/newClient/', function(){
  $f = array('bar','bar');
  return View::make('newClient')->with('input', $f);
});
Route::post('/registerClient/', 'ClientController@addClient');

Route::get('/signin/',function(){
  if (Auth::check()){
    return View::make('loggedin');
  }else{
    $f = array('foo','bar');
    return View::make('signin')->with('test',$f);
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