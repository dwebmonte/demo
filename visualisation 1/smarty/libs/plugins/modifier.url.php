<?php

function smarty_modifier_url($url, $param = 'host') {
	$data_url = parse_url( $url );	 
	
	
	switch ( $param ) {
		case "host": 
			return str_ireplace("www.", "", $data_url["host"]);
		
		break;
	
	
		default: trigger_error("Unknown param \"{$param}\" for mofifier url", E_USER_WARNING);
	};
}

/* vim: set expandtab: */

?>
