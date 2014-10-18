'use strict';

app.factory('Profile', function ($window, FIREBASE_URL, $firebase, Post, $q) {
  var ref = new $window.Firebase(FIREBASE_URL);

  var profile = {
    get: function (userId) {
      //refactor mysql rest
      return $firebase(ref.child('profile').child(userId)).$asObject();
    }
  };

  return profile;
});