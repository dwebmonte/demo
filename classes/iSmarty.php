<?php
require_once('smarty/libs/Smarty.class.php');


define('SMARTY_FORCE_COMPILE', 1); 
define('SMARTY_COMPILE_CHECK', 2); 
define('SMARTY_DEBUGGING', 4); 
define('SMARTY_NOT_CACHING', 8); 
define('SMARTY_COMPILE_ALL', 15); 

if (@!defined('SMARTY_COMPILE_MODE')) define('SMARTY_COMPILE_MODE', SMARTY_COMPILE_ALL); 


class iSmarty extends Smarty {
	public $css_code = '';
	public $js_code = '';
	public $js_code_ready = '';
	public $css_code_name = null;
	public $js_code_name = null;
	public $data_modules_config = null;
	
	function __construct() {
		$this->Smarty();
		
		
		

		$this->template_dir = ROOT."templates";
     	$this->compile_dir = ROOT."classes/smarty/compile";
     	$this->cache_dir = ROOT."classes/smarty/cache";
		$this->config_dir = ROOT."classes/smarty/config";
		
		@mkdir($this->template_dir);
		@mkdir($this->compile_dir);
		@mkdir($this->cache_dir);
			
		$this->compile_check = 	false;
		$this->force_compile =  true;	
		$this->caching = false;
		$this->debugging = true;
		$this->error_reporting = true;
		
		// Фильтры вывода
		$this->autoload_filters['pre'][] = 'replacements';		
		//$this->config_load(ROOT_PROJECT.'/config/modules.conf');

		

		// Временные зоны
		$GLOBALS['_default_timezone'] = date_default_timezone_get();
		
		$time_zone = $this->get_config_vars('time_zone_diff');
		if (!is_null($time_zone)) $GLOBALS['_user_timezone'] = $time_zone; else $GLOBALS['_user_timezone'] = $GLOBALS['_default_timezone']; 
		
		date_default_timezone_set($GLOBALS['_user_timezone']);	
		iDB::exec("SET `time_zone`='".date('P')."'");
	}
	
	
	
	static function plugin_exists($name) {
		$dir = ROOT_FOLDER_SMARTY.'/libs/plugins.3.0/*.'.$name.'.php';
		return count(glob($dir));
	
	}

	
	
}
?>