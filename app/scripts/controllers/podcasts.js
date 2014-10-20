'use strict';

app.controller('PodcastsCtrl', function($scope, $location, Podcast, Auth){
  
  Podcast.all.success(function(d){
    $scope.podcasts = d;
  });
  $scope.user = Auth.user;
  
});