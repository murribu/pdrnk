'use strict';

app.factory('Episode', function ($firebase, FIREBASE_URL) {
  var ref = new Firebase(FIREBASE_URL);
  
  //refactor mysql rest
  
  var Episode = {
    get: function(podcastId, episodeId){
      return $firebase(ref.child('episodes/'+podcastId+'/'+episodeId)).$asObject();
    },
    getByPodcastId: function(podcastId){
      return $firebase(ref.child('episodes/'+podcastId)).$asObject();
    }
  };
  
  return Episode;
});