<?php

// http://php.net/manual/en/datetime.diff.php
// Credit: sgmurphy19
// THANK YOU!!!!!

class TimeComparison
{
    function get_timespan_string($older, $newer) {
        $Y1 = $older->format('Y');
        $Y2 = $newer->format('Y');
        $Y = $Y2 - $Y1;

        $m1 = $older->format('m');
        $m2 = $newer->format('m');
        $m = $m2 - $m1;

        $d1 = $older->format('d');
        $d2 = $newer->format('d');
        $d = $d2 - $d1;

        $H1 = $older->format('H');
        $H2 = $newer->format('H');
        $H = $H2 - $H1;

        $i1 = $older->format('i');
        $i2 = $newer->format('i');
        $i = $i2 - $i1;

        $s1 = $older->format('s');
        $s2 = $newer->format('s');
        $s = $s2 - $s1;

        if($s < 0) {
            $i = $i -1;
            $s = $s + 60;
        }
        if($i < 0) {
            $H = $H - 1;
            $i = $i + 60;
        }
        if($H < 0) {
            $d = $d - 1;
            $H = $H + 24;
        }
        if($d < 0) {
            $m = $m - 1;
            $d = $d + TimeComparison::get_days_for_previous_month($m2, $Y2);
        }
        if($m < 0) {
            $Y = $Y - 1;
            $m = $m + 12;
        }
        
        $timespan_string = TimeComparison::create_timespan_string($Y, $m, $d, $H, $i, $s);
        
        return $timespan_string;
    }

    function get_days_for_previous_month($current_month, $current_year) {
        $previous_month = $current_month - 1;
        
        if($current_month == 1) {
            $current_year = $current_year - 1; //going from January to previous December
            $previous_month = 12;
        }
        if($previous_month == 11 || $previous_month == 9 || $previous_month == 6 || $previous_month == 4) {
            return 30;
        } else if($previous_month == 2) {
            if(($current_year % 4) == 0) { //remainder 0 for leap years
                return 29;
            } else {
                return 28;
            }
        } else {
            return 31;
        }
    }

    function create_timespan_string($Y, $m, $d, $H, $i, $s)
    {
        $timespan_string = '';
        $found_first_diff = false;
        if($Y >= 1) {
            $found_first_diff = true;
            $timespan_string .= TimeComparison::pluralize($Y, 'year').' ';
        }
        if($m >= 1 || $found_first_diff) {
            $found_first_diff = true;
            $timespan_string .= TimeComparison::pluralize($m, 'month').' ';
        }
        if($d >= 1 || $found_first_diff) {
            $found_first_diff = true;
            $timespan_string .= TimeComparison::pluralize($d, 'day').' ';
        }
        if($H >= 1 || $found_first_diff) {
            $found_first_diff = true;
            $timespan_string .= TimeComparison::pluralize($H, 'hour').' ';
        }
        if($i >= 1 || $found_first_diff) {
            $found_first_diff = true;
            $timespan_string .= TimeComparison::pluralize($i, 'minute').' ';
        }
        if($found_first_diff) {
            $timespan_string .= 'and ';
        }
        
        $timespan_string .= TimeComparison::pluralize($s, 'second');
        return $timespan_string;
    }

    function pluralize( $count, $text )
    {
        return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
    }
}

?>