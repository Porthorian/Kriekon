(function($) {
  "use strict";
  $(".player").mb_YTPlayer();
})(jQuery);

(function($) {
      "use strict";
      // CountDown
      $('#clock').countdown("2018/12/24", function(event) {
        var $this = $(this).html(event.strftime('' +
          '<div><span>%D</span> days </div> ' +
          '<div><span>%H</span> hours </div> ' +
          '<div><span>%M</span> min </div> ' +
          '<div><span>%S</span> sec</div> '));
      });
    })(jQuery);
