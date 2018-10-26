<?php

function smarty_modifier_query_string($url='', $param='') {
	if (empty($url)) {
		if (REQUEST_URI == '/') $url = 'http://'.HOST_NAME; else $url = 'http://'.HOST_NAME.REQUEST_URI;
	};
	
	if (empty($param)) return $url;
	
	$param_name = explode('=',$param);
	$param_name = $param_name[0];
	
	if (isset($_SERVER["QUERY_STRING"]) && !empty($_SERVER["QUERY_STRING"])) {
		$url = $url.'?'.$_SERVER["QUERY_STRING"];
		if (strpos($_SERVER["QUERY_STRING"], $param_name)===false) $url .= "&{$param}";
		else {
			$url = preg_replace("#{$param_name}=[^&]*#si",$param, $url);
		}
	} else {
		$url .= "?{$param}";
	
	};
	return $url;
}



?>
