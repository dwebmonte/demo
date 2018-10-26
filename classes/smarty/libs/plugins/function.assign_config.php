<?php 
function smarty_function_assign_config($params, &$smarty)  {
	if (!isset($params['var'])) $params['var'] = $params['value'];
	$var = $smarty->get_config_vars($params['value']);	
	$smarty->assign($params['var'],unserialize($var));
};


