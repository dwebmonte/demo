<?php
class iData {
	public $data = array();
	
	function __construct() {
		$this->refresh();
	}
	
	function refresh() {

		$this->add( "server", "data", array(
			"scheme" => SCHEME, 
			"domain" => DOMAIN
		));	
		
		$this->add( "gate", "data", array(
			"version" => '1.0', 
		));			

		if (isset($_SESSION["user"])) $this->add( "sessionUser", "data", $_SESSION["user"] );	
		
		if ($res = require_once("data/data.php")) $this->data = array_merge($this->data, $data);

		
		$this->assign();	
	}
	
	
	function add($name, $class_name, $value) {
		$value["class"] = $class_name;
		$this->data[ $name ] = $value;
	}
	
	/*
	function add_data($name, $class_name, $value) {
		$this->add($name, $class_name, array("data" => $value));
	}
	*/
	

	function assign() {
		global $SM;
	
		$SM->assign("iCoreData", json_encode($this->data));
	}















}