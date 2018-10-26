<?php




function smarty_function_jquery($params, &$smarty) {
	echo "<script type='text/javascript' src='/nuova/js/jquery.min.js'></script>";
	/*
	if (IS_LOCAL_SERVER) echo "<script type='text/javascript' src='/nuova/js/jquery.min.js'></script>";
	else echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'></script>";
	*/
	
	if (!isset($params['no_coockie'])) 
		echo "<script type='text/javascript' src='/nuova/js/jquery.cookie.js'></script>";
	if (isset($params['ui'])) {
		echo '<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />';
		echo '<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>';
	};
	//echo "<script type='text/javascript' src='/nuova/js/jquery.easing.1.3.js'></script>";


	
}



?>
