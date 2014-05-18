(function ($, window) {

  "use strict";

  /*
  * Konami code
  * */
  Drupal.behaviors.konamiCode = {
    attach: function (context, settings) {
      // var secret = "6577659069327769"; // Amaze me
      var secret = "777986736983"; // movies
      var input = "";
      var timer;
      //The following function sets a timer that checks for user input. You can change the variation in how long the user has to input by changing the number in ‘setTimeout.’ In this case, it’s set for 500 milliseconds or ½ second.
      $(document).keyup(function(e) {
         input += e.which;
         clearTimeout(timer);
         timer = setTimeout(function() { input = ""; }, 5000);
         check_input();
      });
      //Once the time is up, this function is run to see if the user’s input is the same as the secret code
      function check_input() {
        if(input == secret) {
          $("body").css({ background: "#363636 url('/themes/movies/images/site-bg-invert.jpg')" });
        }
      };
    }
  };

})(jQuery, window);
