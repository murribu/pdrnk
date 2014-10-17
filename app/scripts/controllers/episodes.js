'use strict';

app.controller('EpisodesCtrl', function($scope, $routeParams, Episode){
  
  $scope.episodes = Episode.getByPodcastId($routeParams.podcastId);
  
});