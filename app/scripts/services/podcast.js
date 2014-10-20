'use strict';

app.factory('Podcast', function (REST_URL, $http) {
  //refactor mysql rest
  
  var Podcast = {
    all: $http.get(REST_URL + 'podcasts'),
    get: function(podcastId){
      return $http.get(REST_URL + 'podcasts/'+podcastId)
    }
  };
  
  return Podcast;
});