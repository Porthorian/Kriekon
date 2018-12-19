<?php

class Functions {

	/**
	 * For debuging output
	 * @method dump
	 * @param  string $value Data needed to be displayed
	 * @return string        Raw data, may be in an array
	 */
	public function dump($value)
	{
		echo "<pre>";
		var_dump($value);
		echo "</pre>";
	}

	/**
	 * Can be used before storing in database.
	 * May not be needed but added security
	 * @method escape
	 * @param  string $value data needing to striped and encoded
	 * @return string        Encoded string
	 */
	public function escape($value)
	{
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}

	/**
	 * This function will allow us to send text to the console.
	 * @param  string $data The message you want in the console.
	 * @return string       This returns a message to the console.
	 * @example debug('This is the error message');
	 */
	//TODO: Would it not be better to throw an exception to kill the page?
	public function debug($data)
	{
		$output = $data;
		if ( is_array($output))
				$output = implode( ',', $output);

		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}

	function fixObject (&$object)
	{
	  if (!is_object ($object) && gettype ($object) == 'object')
	    return ($object = unserialize (serialize ($object)));
	  return $object;
	}

	// This will take the database time and adjust it to the user's timezone!
	function adjustTime($date, $format = null)
	{
		$timezone_array = array(
			'Eastern Standard Time (US)'=>-5,
			'Central Standard Time (US)'=>-6,
			'Mountain Standard Time (US)'=>-7,
			'Pacific Standard Time (US)'=>-8
			);

		if(isset($_SESSION['user']))
		{
			$user = new User();
            $user = unserialize($_SESSION[Config::get('session/user_session')]);
            if($user->getUserTimezone() != null){
            	$user_timezone = $user->getUserTimezone();
            } else {
            	$user_timezone = Config::get('site/timezone');
            }
            
            $time_diff = $timezone_array[$user_timezone];

			$new_date = new DateTime($date);
			$new_date->modify("{$time_diff} hours");
			if($format == null)
			{
				return $new_date->format('Y-m-d H:i:s');
			} elseif($format == 'date') {
				return $new_date->format('Y-m-d');
			}
			
			
		} else {

            $time_diff = Config::get('site/timezone');

			$new_date = new DateTime($date);
			$new_date->modify("{$time_diff} hours");

			if($format == null)
			{
				return $new_date->format('Y-m-d H:i:s');
			} elseif($format == 'date') {
				return $new_date->format('Y-m-d');
			}
		}
	}
	
	//Calculates the number of days since the date
	public function getTimeAdjustment($post_date)
	{
		$time_past = '';
		$current_time = time();
		
		$interval = $current_time - strtotime($post_date);
		$seconds = floor($interval); //21600 adjusts for EST, TODO INCOOPERATE TIMEZONES FROM USER HERE
		$minutes = floor($seconds / 60);
		$hours = floor($seconds / 3600);
		
		if($seconds > 60)
		{
			if($minutes > 60)
			{
				if($hours >= 24)
				{
					$leap_year = date("L", $current_time);
					$days = round($hours / 24);

					if($days >= 28)
					{
						$years = round($days / 365.25);

						if($years < 1)
						{
							if($leap_year == 1)
							{
								$months = round($days / 30.5);
								$remainder_days = round(30.5 / $months);
							}
							else
							{
								$months = round($days / 30.4166667);
								$remainder_days = round(30.4166667 / $months);
							}
							
							if($months == 1)
								$time_past = $months . ' Month & ' . $remainder_days . ' Days Ago';
							else
								$time_past = $months . ' Months & ' . $remainder_days . ' Days Ago';
						}
						else
						{
							if($years == 1)
								$time_past = $years . " Year Ago";
							else
								$time_past = $years . " Years Ago";
						}
					}
					else
					{
						if($days == 1)
							$time_past = $days . ' Day Ago';
						else
							$time_past = $days . ' Days Ago';
					}
				}
				else
				{
					if($hours == 1)
						$time_past = $hours . ' Hour Ago';
					else
						$time_past = $hours . ' Hours Ago';
				}
			}
			else
			{
				if($minutes == 1)
					$time_past = $minutes . ' Minute Ago';
				else
					$time_past = $minutes . ' Minutes Ago';
				
			}
		}
		else
		{
			$time_past = $seconds . ' Seconds Ago';
		}
		
		return $time_past;
	}
	
	//Takes Unix Timestamp and Splits it up into an Array
	public function getDateArray($date)
	{
		$new_date = explode('-', $date);
		$final_date = explode(' ', $new_date[2]);
		
		$date = array('year'=>$new_date[0],
					  'month'=>$new_date[1],
					  'day'=>$final_date[0],
					  'time'=>$final_date[1]);
		
		$dateArray = array();
		$month = '';
		$short = '';
		
		switch($date['month']) 
		{
			case '1':
				$month = 'January';
				$short = 'JAN';
				break;
			case '2':
				$month = 'Feburary';
				$short = 'FEB';
				break;
			case '3':
				$month = "March";
				$short = 'MAR';
				break;
			case '4':
				$month = "April";
				$short = "APR";
				break;
			case '5':
				$month = "May";
				$short = 'MAY';
				break;
			case '6':
				$month = "June";
				$short = "JUNE";
				break;
			case '7':
				$month = "July";
				$short = "JULY";
				break;
			case '8':
				$month = "August";
				$short = "AUG";
				break;
			case '9':
				$month = "September";
				$short = "SEPT";
				break;
			case '10':
				$month = "October";
				$short = "OCT";
				break;
			case '11':
				$month = "November";
				$short = "NOV";
				break;
			case '12':
				$month = "December";
				$short = "DEC";
				break;
				
		}
		
		$dateArray = array('year'=>$date['year'],
						  'month'=>$month,
						  'short'=>$short,
						  'day'=>$date['day'],
						  'time'=>$date['time']);
		
		return $dateArray;
	}
	
	public function adjustStringSEO($string)
	{
		$name = str_replace(' ','-', $string);
		$final = strtolower($name);
		
		return $final;
	}
	
	public function get_ip_address() 
	{
    	// check for shared internet/ISP IP
		if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		// check for IPs passing through proxies
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// check if multiple ips exist in var
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
				$iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				foreach ($iplist as $ip) {
					if ($this->validate_ip($ip))
						return $ip;
				}
			} else {
				if ($this->validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
					return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_X_FORWARDED']))
			return $_SERVER['HTTP_X_FORWARDED'];
		if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && $this->validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
			return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && $this->validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
			return $_SERVER['HTTP_FORWARDED_FOR'];
		if (!empty($_SERVER['HTTP_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_FORWARDED']))
			return $_SERVER['HTTP_FORWARDED'];

		// return unreliable ip since all else failed
		return $_SERVER['REMOTE_ADDR'];
	}

	/**
	 * Ensures an ip address is both a valid IP and does not fall within
	 * a private network range.
	 */
	private function validate_ip($ip) 
	{
		if (strtolower($ip) === 'unknown')
			return false;

		// generate ipv4 network address
		$ip = ip2long($ip);

		// if the ip is set and not equivalent to 255.255.255.255
		if ($ip !== false && $ip !== -1) {
			// make sure to get unsigned long representation of ip
			// due to discrepancies between 32 and 64 bit OSes and
			// signed numbers (ints default to signed in PHP)
			$ip = sprintf('%u', $ip);
			// do private network range checking
			if ($ip >= 0 && $ip <= 50331647) return false;
			if ($ip >= 167772160 && $ip <= 184549375) return false;
			if ($ip >= 2130706432 && $ip <= 2147483647) return false;
			if ($ip >= 2851995648 && $ip <= 2852061183) return false;
			if ($ip >= 2886729728 && $ip <= 2887778303) return false;
			if ($ip >= 3221225984 && $ip <= 3221226239) return false;
			if ($ip >= 3232235520 && $ip <= 3232301055) return false;
			if ($ip >= 4294967040) return false;
		}
		return true;
	}

}
