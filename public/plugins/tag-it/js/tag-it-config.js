$(function(){
	$("#myTags").tagit({

		// Options
		fieldName: "tag",
		availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"],
		autocomplete: {delay: 0, minLength: 2},
		showAutocompleteOnFocus: false,
		removeConfirmation: false,
		caseSensitive: false,
		allowDuplicates: false,
		allowSpaces: true,
		readOnly: false,
		tagLimit: 5,
		singleField: true,
		singleFieldDelimiter: ',',
		singleFieldNode: $('#mySingleField'),
		tabIndex: null,
		placeholderText: "Tags - Insert up to 5",

		/*// Events
		beforeTagAdded: function(event, ui) {
			console.log(ui.tag);
		},
		afterTagAdded: function(event, ui) {
			console.log(ui.tag);
		},
		beforeTagRemoved: function(event, ui) {
			console.log(ui.tag);
		},
		onTagExists: function(event, ui) {
			console.log(ui.tag);
		},
		onTagClicked: function(event, ui) {
			console.log(ui.tag);
		},
		onTagLimitExceeded: function(event, ui) {
			console.log(ui.tag);
		}*/

	});
});