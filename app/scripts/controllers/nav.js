'use strict';

app.controller('NavCtrl', function ($scope, $location, Podcast, Auth) {
  $scope.post = {url: 'http://', title: ''};
  $scope.user = Auth.user;
  
  $scope.signedIn = Auth.signedIn;
  $scope.logout = Auth.logout;
  
});