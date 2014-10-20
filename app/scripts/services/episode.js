'use strict';

app.factory('Episode', function (REST_URL, $http) {
  
  var Episode = {
    get: function(episodeId){
      return $http.get(REST_URL + 'episodes/'+episodeId)
    },
    getByPodcastId: function(podcastId){
      return $http.get(REST_URL + 'episodes?po_key='+podcastId);
    }
  };
  
  return Episode;
});