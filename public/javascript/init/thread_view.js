// JavaScript Document
$(document).ready(function($) {
	"use strict";
      $('.summernote').summernote({
        height: 160,
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'picture']],
          ['para', ['ul', 'ol', 'paragraph']]
        ]
      });
    })(jQuery);