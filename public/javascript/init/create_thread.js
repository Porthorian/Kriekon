// JavaScript Document
$(document).ready(function($) {
	"use strict";
	$('#summernote').summernote({
	height: 200,
	styleTags: ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
	toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ],

      // popover
      popover: {
        link: [
          ['link', ['linkDialogShow', 'unlink']]
        ],
        table: [
          ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
          ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
        ],
        air: [
          ['color', ['color']],
          ['font', ['bold', 'underline', 'clear']],
          ['para', ['ul', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture']]
        ]
      }
	});
	$(".js-example-basic").select2();
	$(".flatpickr").flatpickr();
	var elem = document.querySelector('.js-switch');
	var init = new Switchery(elem);
})(jQuery);