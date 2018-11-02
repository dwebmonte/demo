<?php
	
ini_set("memory_limit", "2G");

ini_set('display_errors', E_ALL & ~E_DEPRECATED); 
error_reporting(E_ALL & ~E_DEPRECATED);

session_write_close();
$session_time = 30000;

session_set_cookie_params($session_time, "/", false, false);
//ini_set('session.cookie_path', '/');
ini_set('session.gc_maxlifetime', $session_time);
//ini_set('session.cookie_lifetime', 5000000);
ini_set('session.use_cookies', 1);
session_start();
	
	
/* Константы по работе с БД */

date_default_timezone_set('Europe/Kiev');


$server_addr = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];

	define('DB_HOST', 'LOCALHOST');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'trend1');

	define("DOMAIN", "aleney.com/crm/trend");
	define("ASSETS_PATH", "http://aleney.com/crm/.assets");
	define("CORE_PATH", "../.core/");
	
	define("DEVELOPE", true);		
	define("IS_LOCALHOST", true);

define("ADMIN_ROUTE_URL", "");

define('DB_PREFIX', 'trend_');
define('DEFAULT_LANG', 'ru');


define('DB_CHARSET','utf8');
define('DB_COLLATION','utf8_general_ci');	