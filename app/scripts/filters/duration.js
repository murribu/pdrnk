'use strict';

app.filter('duration', function () {
  return function(a){
    var ret = a + ' ... ';
    if (a >= 3600){
      ret = Math.floor(a/3600) + ':';
      a -= Math.floor(a/3600)*3600;
    }
    var minutes = Math.floor(a/60);
    if (minutes < 10){
      ret += '0';
    }
    ret += minutes + ':';
    a -= Math.floor(a/60)*60;
    if (a < 10){
      ret += '0';
    }
    ret += a;
    return ret;
  };
});