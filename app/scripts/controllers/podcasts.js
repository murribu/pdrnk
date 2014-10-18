'use strict';

app.controller('PodcastsCtrl', function($scope, $location, Podcast, Auth){
  
  $scope.podcasts = Podcast.all;
  $scope.user = Auth.user;
  
});