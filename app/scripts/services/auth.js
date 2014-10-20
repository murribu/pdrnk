'use strict';

app.factory('Auth', function (REST_URL, $rootScope) {
  
  //refactor mysql rest

  var Auth = {
    register: function (user) {
      return false;
    },
    createProfile: function (user) {
      var profile = {
        username: user.username
      };
      
      return false;
    },
    login: function (user) {
      return false;
    },
    logout: function () {
      return false;
    },
    resolveUser: function() {
      return false;
    },
    signedIn: function() {
      return false;
    },
    user: {}
  };

  return Auth;
});
