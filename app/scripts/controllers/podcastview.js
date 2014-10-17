'use strict';

app.controller('PodcastViewCtrl', function($scope, $routeParams, Podcast, Episode){
  $scope.podcast = Podcast.get($routeParams.podcastId);
  $scope.episodes = Episode.getByPodcastId($routeParams.podcastId);
  $scope.predicate = 'episode.rand';
  console.log($scope.episodes);
});