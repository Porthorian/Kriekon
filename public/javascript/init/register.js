$(document).ready(function() {
	'use strict';
	function getAge(otherDateYear, otherDateMonth, otherDateDay) 
	{
		var birthDate = new Date(otherDateYear, otherDateMonth, otherDateDay), now = new Date(),
		  years = now.getFullYear() - birthDate.getFullYear();
		birthDate.setFullYear(birthDate.getFullYear() + years);
		if (birthDate > now) {
		  years--;
		  birthDate.setFullYear(birthDate.getFullYear() - 1);
		}
		var days = Math.floor((now.getTime() - birthDate.getTime()) / (3600 * 24 * 1000)),
		  yearsOld = years + days / (isLeapYear(now.getFullYear()) ? 366 : 365),
		  decimals = ((yearsOld + '').split('.')[1] || '').substr(0, 3);

		if (yearsOld >= 0) {
		  return Math.floor(yearsOld) + (decimals >= 915 ? 1:0);
		} else {
		  decimals *= 10;
		  return Math.floor(yearsOld) + (decimals <= 840 ? 1:0);
		}
	}

	function isLeapYear(year) {
		var date = new Date(year, 1, 28);
		date.setDate(date.getDate() + 1);
		return date.getMonth() === 1;
	}
	
	$.formUtils.addValidator({
		name: "age_validator",
		
		validatorFunction: function (val, $el, conf) {
		  var isValid = false;
		  var dateFormat = 'yyyy-mm-dd';
		  if ($el.valAttr('format')) {
			dateFormat = $el.valAttr('format');
		  }
		  else if (typeof conf.dateFormat !== 'undefined') {
			dateFormat = conf.dateFormat;
		  }

		  var inputDate = $.formUtils.parseDate(val, dateFormat);
		  if (!inputDate) {
			return false;
		  }

		  var year = inputDate[0],
			month = inputDate[1],
			day = inputDate[2],
			age = getAge(year, month, day),
			allowedAgeRange = ($el.valAttr('age-range') || '13-124').split('-');

			if(age >= 13)
				{
					isValid = true;
					return true;
				}
			else
				{
					isValid = false;
					return false;
				}

		  return age >= allowedAgeRange[0] && age <= allowedAgeRange[1];
		},
		errorMessage: 'You must be 13 Years or Older!'
	});
	
	$.validate({
	modules : 'location, date, security, file, sanitize',
	onModulesLoaded : function() {
	  $('input[name="register_country"]').suggestCountry();
	  $('input[name="pass_confirmation"]').displayPasswordStrength();
	}
	});
});