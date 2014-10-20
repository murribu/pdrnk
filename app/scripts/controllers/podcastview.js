'use strict';

app.controller('PodcastViewCtrl', function($scope, $routeParams, Podcast, Episode){
  Podcast.get($routeParams.podcastId).success(function(d){
    $scope.podcast = d;
  });
  Episode.getByPodcastId($routeParams.podcastId).success(function(d){
    $scope.episodes = d;
    console.log($scope.episodes);
  });
});