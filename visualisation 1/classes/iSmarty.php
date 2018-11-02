<?php
require_once(ROOT . 'smarty/libs/Smarty.class.php');


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
     	$this->compile_dir = ROOT."smarty/compile";
     	$this->cache_dir = ROOT."smarty/cache";
		$this->config_dir = ROOT."smarty/config";
		
		if (DEVELOPE) {@mkdir($this->template_dir);@mkdir($this->compile_dir);@mkdir($this->cache_dir);};
		$this->compile_check = 	true;
		$this->force_compile =  true;	
		$this->caching = false;
		$this->debugging = true;
		$this->error_reporting = true;
		
		// Фильтры вывода
		$this->autoload_filters['pre'][] = 'content';		
		$this->autoload_filters['post'][] = 'content';
		$this->autoload_filters['output'][] = 'content';
		$this->config_load('document.conf');
		

	}
	
	
	
	static function plugin_exists($name) {
		$dir = ROOT_FOLDER_SMARTY.'/libs/plugins.3.0/*.'.$name.'.php';
		return count(glob($dir));
	
	}

	
	
}
?>