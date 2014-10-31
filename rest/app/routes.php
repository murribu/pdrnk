<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Authorization');
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

Route::get('/', function(){
	return 'hello world';
});
Route::get('/podcasts/{id}','PodcastController@showPodcast');
Route::get('/podcasts','PodcastController@showPodcasts');
Route::put('/podcast', array('before' => 'oauth','uses' => 'PodcastController@addPodcast'));
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

Route::get('protected-resource', ['before' => 'oauth', function() {
  $headers = getallheaders();
  $access_token = $headers['Authorization'];
  
  return Response::json(array('protected','resource'));
}]);
Route::get('protected-resource-test', ['before' => 'oauth', function() {
    
    return Response::json(array('ownerid' => Authorizer::getResourceOwnerId(), 'clientid' => Authorizer:: getClientId()));
}]);

Route::get('/signin/',function(){
  if (Auth::check()){
    return View::make('loggedin');
  }else{
    $f = array('foo','bar');
    return View::make('signin')->with('test',$f);
  }
});
Route::post('/auth/login', 'AuthController@login');
?>