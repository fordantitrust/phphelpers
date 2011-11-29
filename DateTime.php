<?php
function dateTimeAgo($timestamp, $granularity = 2, $format='d-m-Y H:i:s'){

		if (preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $timestamp)) {
			$timestamp = strtotime($timestamp);
		}

        $alias = array('week' => 'week','day' => 'day','hour' => 'hour','minute' => 'minute','second' => 'second');

        $difference = time() - $timestamp;
        if($difference < 0) return '0 '.t('second').' '.t('ago');
        elseif($difference < 864000){
                $periods = array('week' => 604800,'day' => 86400,'hour' => 3600,'minute' => 60,'second' => 1);
                $output = '';
                foreach($periods as $key => $value){
                        if($difference >= $value){
                                $time = round($difference / $value);
                                $difference %= $value;
                                $output .= ($output ? ' ' : '').$time.' ';
                                $output .= (($time > 1 && $alias[$key] == 'day') ? $alias[$key].'' : $alias[$key]);
                                $granularity--;
                        }
                        if($granularity == 0) break;
                }
                return ($output ? $output : '0 '.t('second')).' '.t('ago');
        }
        else return date($format, $timestamp);
}

function dateAgo($timestamp){

		if (preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $timestamp)) {
			$timestamp = strtotime($timestamp);
		}
        $format = 'd/m/Y';
        return date($format, $timestamp);
}