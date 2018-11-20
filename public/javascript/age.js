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
	var d = new Date(year, 1, 28);
	d.setDate(d.getDate() + 1);
	return d.getMonth() === 1;
}