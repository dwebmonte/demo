<?php

function smarty_modifier_url($title, $url = null) {
	
	
	if (is_null($url)) {
		$url = $title;
		$info = parse_url($url);
		$title = $info['host'];
	};
	
	
	
	return "<a href='{$url}' target='_blank'>{$title}</a>";
}



?>
