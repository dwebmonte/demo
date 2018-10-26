<?php
/*



 */
function smarty_function_include404($params, &$smarty) {
	// Убрать это в v.3.0
	$smarty->assign('params',$params);
	
	
	foreach ($params as $param_name=>$param_value) {
		$smarty->assign($param_name, $param_value);
	};
	
	
	
	if (!isset($params['cache'])) {
		if (VERSION >= 200 && isset($GLOBALS['cache_index'])) {
			$params['cache'] = $GLOBALS['cache_index'];
		} else {
			$params['cache'] = REQUEST_URI;
			$params['cache'] .= (isset($_SESSION['user'])) ? 'login':'public';
		};
	};
	
	
	
	if (VERSION >= 200 && VERSION < 300 && IS_ADMIN) {
		$params['file'] = basename($params['file']);
		
		if (file_exists(ROOT_SMARTY_TEMPLATES.'/admin/'.$params['file'])) echo $smarty->fetch('admin/'.$params['file'],$params['cache']);
		elseif (file_exists(ROOT.'admin_panel.2.0/templates/'.$params['file'])) echo $smarty->fetch(ROOT.'admin_panel.2.0/templates/'.$params['file'],$params['cache']);
		elseif (file_exists(ROOT.'admin_panel.2.0/'.$params['file'])) echo $smarty->fetch(ROOT.'admin_panel.2.0/'.$params['file'],$params['cache']);	
		else {
			if (TESTING) trigger_error('Не найден файл - '.$params['file']);
			echo $smarty->fetch('b-error404.tpl');
		};

	
	
	} elseif(VERSION >= 300) {
		echo $smarty->fetch404($params['file']);	
	} else {
		if (!isset($GLOBALS['error404'])) {
			echo $smarty->fetch($params['file'],$params['cache']);
			
		} else {
			header('HTTP/1.1 404 Not Found');
			//if (TESTING) trigger_error('Не найден файл - '.$params['file']);
			echo $smarty->fetch('b-error404.tpl');
		};
	};
	

}



?>
