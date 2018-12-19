// JavaScript Document
var child_reply = function(url, full_url, username, reply_token, reply_parent_id)
{
	var html = "<form action='" + full_url +  "' method='POST'>";
		html +=	"<textarea class='summernote' name='reply_content'><a style='color: green; font-weight: 700;' href='" + url + "user/p/" + username + "'>@" + username + "</a></textarea>";
		html +=	"<input type='hidden' value='" + reply_token + "' name='reply_token'/>";
		html += "<input type='hidden' value='" + reply_parent_id + "' name='reply_parent_id'/>";
		html +=	"<button class='btn btn-primary btn-shadow float-right' type='submit'>Submit</button></form>";

	var parent_div = document.getElementById("comment-" + reply_parent_id);

	parent_div.innerHTML = html;
	(function($) {
		"use strict";
		$('.summernote').summernote({
			height: 160,
			toolbar: [
			  ['style', ['bold', 'italic', 'underline']],
			  ['para', ['ul', 'ol', 'paragraph']],
			  ['insert', ['link']]
			]
		});
	})(jQuery);
};
$(document).ready(function($) {
	"use strict";
	$('.summernote').summernote({
		height: 160,
		toolbar: [
		  ['style', ['bold', 'italic', 'underline']],
		  ['para', ['ul', 'ol', 'paragraph']],
		  ['insert', ['link']]
		]
	});
})(jQuery);