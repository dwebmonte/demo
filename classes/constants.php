<?php
mb_internal_encoding("utf-8");

$session_time = 30000;

session_set_cookie_params($session_time, "/", false, false);
ini_set('session.gc_maxlifetime', $session_time);
ini_set('session.use_cookies', 1);
session_start();


$self_fn = str_ireplace('\\','/',__FILE__);
define("ROOT", str_ireplace( "classes/".basename($self_fn ), "", $self_fn ));


define('DB_CHARSET','utf8');
define('DB_COLLATION','utf8_general_ci');



define("TEMP_DIR", ROOT . "tmp");
if (!file_exists(TEMP_DIR)) mkdir(TEMP_DIR);

/* Константы по работе с БД */

if ($_SERVER["SERVER_ADDR"] == "127.0.0.1") {
	define("IS_LOCAL_SERVER", true);
	define('DB_HOST', 'LOCALHOST');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'trend');
	
	ini_set('display_errors', E_ALL); 
	error_reporting(E_ALL);
		
	define('IS_LOCALHOST', true);		
} else {
	define("IS_LOCAL_SERVER", false);
	define('DB_HOST', 'LOCALHOST');

	define('IS_LOCALHOST', false);


	define('DB_USER', 'aleneyne_trend');
	define('DB_PASSWORD', 'g%^fildo*~I[');
	define('DB_NAME', 'aleneyne_trend');

	
	/*
	define('DB_USER', 'u659833849_new');
	define('DB_PASSWORD', 'new12345');
	define('DB_NAME', 'u659833849_new');	
	*/
	
	ini_set('display_errors', E_ALL & ~E_DEPRECATED); 
	error_reporting(E_ALL & ~E_DEPRECATED);
	
};





// ~~~~~~~~~~~~~~~~~~~~~~~		Автозагрузка
function main_autoload($class_name) {
	$class_name = "classes/" . $class_name . ".php";
	
	if ($res = file_exists($class_name)) require_once($class_name); 
	else trigger_error("Не найден файл = {$class_name}", E_USER_WARNING);
};
spl_autoload_register('main_autoload');




$GLOBALS["SM"] = new iSmarty();