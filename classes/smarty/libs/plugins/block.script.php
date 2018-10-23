<?php

function smarty_block_script($params, $content, &$smarty) {
	
	
	exit();
	
	/*
	if ($content) {
		$content = trim($content);
		$name = basename($smarty->_config[0]['vars']['content']);
		
		$smarty->js_code_name[$name] = $name;
		$content = str_ireplace(array('<script>','</script>'),'',$content);
		
		if (!isset($params['ready']) || $params['ready'] == 0) $smarty->js_code_ready .= $content;
		else $smarty->js_code .= $content;
	};
	*/
	
	
	/*
	if ($content) {
		$content = trim(str_ireplace(array('<script>','</script>'),'',$content));

		$filename = $smarty->_smarty_debug_info[ count($smarty->_smarty_debug_info)-1 ]["filename"];
	
		
		if (!isset($smarty->js_code_name[$filename])) {
			$smarty->js_code_name[$filename] = $content;
			
			if (!isset($params['ready']) || $params['ready'] == 0) $smarty->js_code_ready .= $content."\r\n";
			else $smarty->js_code .= $content."\r\n";	
		};
	};
	*/
	
	
	return '';
	
};