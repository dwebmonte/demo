<?php

function smarty_modifier_date($string, $format = 'd.m.Y H:i', $convert_to_unix = false) {
	if ($string == 0 || empty($string)) return '';
	
	if ($convert_to_unix) $string = strtotime($string); else $string = (int) $string;
	
	
	
	if (is_numeric($format) && $format == 1) {
		if (date('dmY', $string) == date('dmY')) $res = date("Сегодня, H:i", $string);
		elseif (date('dmY', $string) ==  date('dmY', time()-60*60*24)) $res = date("Вчера, H:i", $string);
		else {	
			
			$rus_short_month = array('янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек');
			$month_id = (int) date('m', $string);
			$month_id = $month_id-1;
			$res = date("d {$rus_short_month[$month_id]} Y H:i", $string);
		};
	} elseif (is_numeric($format) && $format == 10) {
		$rus_short_month = array('янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек');
		$month_id = (int) date('m', $string);
		$month_id = $month_id-1;
		$res = date("d {$rus_short_month[$month_id]} Y", $string);
		
		
	} elseif (is_numeric($format) && $format == 2) {
		if (date('dmY', $string) == date('dmY')) $res = date("Сегодня, H:i", $string);
		elseif (date('dmY', $string) ==  date('dmY', time()-60*60*24)) $res = date("Вчера, H:i", $string);
		else {	
			$rus_long_month = array('январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
			$month_id = (int) date('m', $string);
			$month_id = $month_id-1;
			$res = date("d {$rus_long_month[$month_id]} Y, H:i", $string);
		};
	
	} elseif (is_numeric($format) && $format == 20) {
		$rus_long_month = array('январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
		$month_id = (int) date('m', $string);
		$month_id = $month_id-1;
		$res = date("d {$rus_long_month[$month_id]}, Yг", $string);
		
	} elseif (is_numeric($format) && $format == 3) {
		if (date('dmY', $string) == date('dmY')) $res = date("Сегодня, H:i", $string);
		elseif (date('dmY', $string) ==  date('dmY', time()-60*60*24)) $res = date("Вчера, H:i", $string);
		elseif (date('Y', $string) == date('Y')) $res = date("d.m H:i", $string);
		else $res = date("d.m.Y H:i", $string);
	} elseif (is_numeric($format) && $format == 4) {
		if (date('dmY', $string) == date('dmY')) $res = date("H:i", $string);
		elseif (date('dmY', $string) ==  date('dmY', time()-60*60*24)) $res = date("вчера, H:i", $string);
		elseif (date('Y', $string) == date('Y')) $res = date("d.m H:i", $string);
		else $res = date("d.m.Y H:i", $string);
	} elseif (is_numeric($format) && $format == 5) {
		if (date('dmY', $string) == date('dmY')) $res = date("H:i:s", $string);
		elseif (date('dmY', $string) ==  date('dmY', time()-60*60*24)) $res = date("вчера, H:i:s", $string);
		else $res = date("d.m.Y H:i:s", $string);
	} else $res = date($format, $string);
	
	
	
	return $res;
}



?>
