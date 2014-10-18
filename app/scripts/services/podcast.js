'use strict';

app.factory('Podcast', function ($firebase, FIREBASE_URL) {
  var ref = new Firebase(FIREBASE_URL);
  var podcasts = $firebase(ref.child('podcasts')).$asArray();
  
  //refactor mysql rest
  
  var Podcast = {
    all: podcasts,
    get: function(podcastId){
      return $firebase(ref.child('podcasts').child(podcastId)).$asObject();
    }
  };
  
  return Podcast;
});