// JavaScript Document
$(document).ready(function($) {
	   "use strict";
      // owl carousel
      $('.owl-logos').owlCarousel({
        margin: 100,
        nav: false,
        autoplay: true,
        dots: false,
        responsive: {
          0: {
            items: 1
          },
          500: {
            items: 2
          },
          701: {
            items: 3
          },
          1000: {
            items: 5
          }
        }
      });

      $('.owl-videos').owlCarousel({
        margin: 15,
        loop: true,
        dots: false,
        autoplay: true,
        responsive: {
          0: {
            items: 1
          },
          700: {
            items: 2
          },
          800: {
            items: 3
          },
          1000: {
            items: 4
          },
          1200: {
            items: 6
          }
        }
      });
      // Background Player
      $(".player").mb_YTPlayer();
    })(jQuery);