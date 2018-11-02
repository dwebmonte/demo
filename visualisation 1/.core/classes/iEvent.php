<?php

class iEvent {
	function __construct() {
		global $SM;
		
		$this->register_class();
		
		$SM->assign(get_class($this), $this);
	}
	
	
	function register_class_trigger($event_name, $obj = null) {
		if ( is_null($obj) ) $obj = $this;
		$GLOBALS['__queue'][$event_name][] = array('obj'=>$obj);	
		return true;
	}
	
	function register_class($obj = null) {
		if ( is_null($obj) ) $obj = $this;
		$data_method = get_class_methods( get_class( $obj) );	
		foreach ($data_method as $event_name ) {
			if (strpos($event_name, "on") === 0) {
				$this->register_class_trigger($event_name, $obj);
			};
		
		};
	}	
	
	static function fire( ) {
		if (func_num_args() == 0) trigger_error("Achtung 1", E_USER_ERROR);
		$res = null;
		
		$args = func_get_args();
		$event_name = array_shift( $args );
		// var_dump($event_name);
		
		if (isset($GLOBALS['__queue'][$event_name])) {
			foreach ($GLOBALS['__queue'][$event_name] as $row_event) {
				$res = call_user_func_array(array($row_event['obj'], $event_name), $args);
			};
		};
		
		return $res;
	}
	
	function call( ) {
		if (func_num_args() == 0) trigger_error("Achtung 1", E_USER_ERROR);
		$res = null;
		
		$args = func_get_args();
		$event_name = array_shift( $args );
		
		if (isset($GLOBALS['__queue'][$event_name])) {
			foreach ($GLOBALS['__queue'][$event_name] as $row_event) {
				$res = call_user_func_array(array($row_event['obj'], $event_name), $args);
			};
		};
		
		return $res;
	}
	
	static function check_for_ajax() {
		if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
			self::fire("onCheckAjax");
			define("IS_AJAX", true);
		
		
			$class = isset($_REQUEST["c"]) ? $_REQUEST["c"] : 'iComDataTable';
			$event = $_REQUEST["e"];
			
			$obj = new $class();
			$obj->$event( );
		
			return true;
		} else {
			return false;
		
		};
	}
	
	static function check_for_ajax_test($data) {
		self::fire("onCheckAjax");
		define("IS_AJAX", true);
	
		$class = isset($_REQUEST["c"]) ? $_REQUEST["c"] : 'iComDataTable';
		$event = $data["e"];
		$obj = new $class();
		$obj->$event( $data );
	
		return true;
	}	
	
	function error($text, $type_error = 2) {
		switch ($type_error) {
			case 0: $error = E_USER_NOTICE; break;
			case 1: $error = E_USER_WARNING; break;
			case 2: $error = E_USER_ERROR; break;
			default: $error = E_USER_ERROR;
		};
		
		if (defined("IS_AJAX")) {
			echo json_encode(array("data" => array(array("html"=>$text, "type"=>"error", "action"=>"info"))));		
			exit();		
		} else {
			trigger_error( $text, $error );		
		};
	}
	
	function get_info_type($table) {
		$typeinfo = array();
		$data_info = iDB::rows("DESCRIBE `{$table}`");
		
		foreach ($data_info as $key => $item) {
			$field = $item->Field;
			$type = $item->Type;
			
			$info_type = array();
			if ( $type == "float") $info_type["type"] = "float";
			elseif ( $type == "datetime"|| $type == "timestamp") $info_type["type"] = "datetime";
			elseif (preg_match('#int   \((\d+)\)  \s+ unsigned#six', $type, $match)) {
				$info_type["type"] = "int";	$info_type["size"] = $match[1];	$info_type["sign"] = false;
			}
			elseif (preg_match('#int   \((\d+)\)#six', $type, $match)) {
				$info_type["type"] = "int";	$info_type["size"] = $match[1];	$info_type["sign"] = true;
			}
			elseif (preg_match('#char   \((\d+)\)#six', $type, $match)) {
				$info_type["type"] = "string";	$info_type["size"] = $match[1];	
			}
			else trigger_error("Achtung with {$type}", E_USER_ERROR);
			
			$typeinfo[$field] = $info_type;
		};
		
		return $typeinfo;
	}	
	
	
	
	
	
	
	

	
	
	
}