// JavaScript Document
$(document).ready(function($) {
	"use strict";
      // owl carousel
      $('.owl-carousel').owlCarousel({
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
    })(jQuery);