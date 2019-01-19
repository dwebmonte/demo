<?php
define("FILENAME_CD", ROOT . "json/CD.json");		

require_once( "api_functions.php" );

class coreAPI {
	public $call_method;
	public $cd;
	public $output = array("res" => null, "data" => null, "action" => array(), "errors" => array(), "warnings" => array(), "notices" => array());

	
	
	function loginned() {
		if (isset($_SESSION["user"])) {
			return true;
		} else {
			$this->output["action"][] = array("do" => "href", "href" => "");
			return false;
		};			
	}
	

	function onRequest($do = null, $params = null, $call_method = null) {
		//var_dump($do, $params);
		
		if (is_null($do)) {
			$do = $_REQUEST["do"];
			$this->call_method = "request";
		} else {
			$this->call_method = "local";
		};

		if (!is_null($call_method)) $this->call_method = $call_method;
		
		if (is_null($params) && isset($_REQUEST["params"])) $params = $_REQUEST["params"];
		
		$res = false;
		
		$do = mb_strtolower($do);
		
		$paramsForm = array();	
		if (!is_null($params) && isset($params[0]["value"]) && isset($params[0]["name"])) {
			
			foreach ($params as $key => $item) $paramsForm[ $item["name"] ] = $item["value"];		
			
		} elseif (!is_null($params) && isset($params["data"][0]["value"]) && isset($params["data"][0]["name"])) {
			
			foreach ($params["data"] as $key => $item) $paramsForm[ $item["name"] ] = $item["value"];		
			
		} else {
			$paramsForm = $params;
		};
		
		

		switch ($do) {
		
			// устаревшее убрать
			case stristr($do, "SetTable"):
				if (isset($_SESSION["user"])) {
					iDB::exec("TRUNCATE `{$paramsForm["table"]}`");
					iDB::insertDataSQL($paramsForm["table"], $paramsForm["data"]);
				} else {
					$this->output["action"][] = array("do" => "href", "href" => "");
				};
				
				$res = true;
			break;
			
			// устаревшее убрать
			case stristr($do, "GetTable"):
				if (isset($_SESSION["user"])) {
					foreach ($paramsForm["fields"] as $key => $field) $paramsForm["fields"][$key] = '`'. $field .'`';
				
				
					$data = iDB::rows_assoc($query = "SELECT ".  implode(",", $paramsForm["fields"]) ." FROM `{$paramsForm["table"]}");
					if (is_null($data)) $data = array();
					
					//header("Content-type: application/json; charset=utf-8");
					echo json_encode(array("data" => $data));
					exit();
				} else {
					$this->output["action"][] = array("do" => "href", "href" => "");
				};
				
				$res = true;
			break;			
			
			
			case stristr($do, "DBSet"):
				if (!isset( $paramsForm ) || empty($paramsForm["entity"])) trigger_error("Error API DBSET - entity is not defined", E_USER_ERROR);
				else {
					$entity = $paramsForm["entity"];
					
					if (defined("AUTOCREATE_SQL") && AUTOCREATE_SQL) iDB::check_table( $entity );
					
					// получить
					if (isset($paramsForm["get"])) {
						
						$data = iDB::rows("SELECT * FROM `" . iS::s($entity) . "`");
						if (is_null($data)) $data = array();
				
						echo json_encode(array("data" => $data));
						exit();						
					};
					
					// добавление
					if (isset($paramsForm["post"])) {
						foreach ($paramsForm["post"] as $item_put) {
							unset( $item_put["undefined"] );
							
							if (!isset($item_put["id"])) trigger_error("Error API DBSET - id is not defined for post", E_USER_ERROR);
							if (defined("AUTOCREATE_SQL") && AUTOCREATE_SQL) iDB::check_fields( $entity, array_keys($item_put) );		
							
							//unset( $item_put["id"] );
							iDB::insertSQL( $entity, $item_put );
						};
					};
					
					// редактирование
					if (isset($paramsForm["put"])) {
						foreach ($paramsForm["put"] as $item_put) {
							if (!isset($item_put["id"])) trigger_error("Error API DBSET - id is not defined for put", E_USER_ERROR);
							if (defined("AUTOCREATE_SQL") && AUTOCREATE_SQL) iDB::check_fields( $entity, array_keys($item_put) );		
							
							iDB::updateSQL( $entity, $item_put, "`id` = " . iS::n($item_put["id"]) );
						};
					};		
					
					// удаление
					if (isset($paramsForm["remove"])) {
						$row_delete_id = array();
						
						foreach ($paramsForm["remove"] as $item) $row_delete_id[] = iS::n( $item );
				
						if (count($row_delete_id > 0)) iDB::exec( "DELETE FROM `" . iS::s($entity) . "` WHERE id IN (". implode(",", $row_delete_id) . ")" );
					};		
					
					
				};
				///var_dump( $paramsForm );
				trigger_error("Данные успешно сохранены");
			
			
			
			break;
			
		};
		
		
		
		return array( $do, $params, $paramsForm, $res);
	}


	protected function prepare_output() {
		global $SM;
	
	
		// обработка ошибка
		
		/*
		if (isset($this->output["error"])) {
			foreach ($this->output["error"] as $num => $row_error) {
				// если это текст, то значит массив с title
				if (is_string($row_error))  $row_error = array("title" => $row_error);
				
				// если это просто массив с длиной 1, то значит массив с параметрами
				if (is_array($row_error) && count($row_error) == 1 && isset($row_error[0]))  
					$row_error = array("params" => $row_error);
				
				// если это просто массив с длиной 2, то значит массив с параметрами
				if (is_array($row_error) && count($row_error) == 2 && isset($row_error[0]) && isset($row_error[1]))  
					$row_error = array("title" => $row_error[0], "params" => $row_error[1]);

				// если это просто массив с длиной 2, то значит массив с параметрами
				if (is_array($row_error) && count($row_error) == 3 && isset($row_error[0]) && isset($row_error[1]) && isset($row_error[2]))  
					$row_error = array("title" => $row_error[0], "text" => $row_error[1], "params" => $row_error[2]);

				if (!isset($row_error["params"])) $row_error["params"] = array();
				
			
				// берем текст из конфигурационного файла
				$sm_title = isset($row_error["config_title"]) ? $SM->get_config_vars("error_" . $row_error["config_title"]) : $SM->get_config_vars("error_{$num}");
				if (!is_null($sm_title)) $row_error["title"] = vsprintf($sm_title, $row_error["params"]);
				
				$sm_text = isset($row_error["config_text"]) ? $SM->get_config_vars("error_" . $row_error["config_text"]) : $SM->get_config_vars("error_text_{$num}");
				if (!is_null($sm_text)) $row_error["text"] = vsprintf($sm_text, $row_error["params"]);
					
				if (!isset($row_error["text"])) $row_error["text"] = "";
				if (!isset($row_error["title"])) {
					if (empty($row_error["description"])) $row_error["title"] = $SM->get_config_vars("error_api");
					else $row_error["title"] = $SM->get_config_vars("error_unknown_api");
				};
		
		
				$this->output["error"][$num] = $row_error; 
				
				if ($this->call_method == "local") {
					if (isset($row_error["text"])) trigger_error($row_error["title"] .":  " . $row_error["text"], E_USER_ERROR);
					else trigger_error($row_error["title"], E_USER_ERROR); 
				} else {
					$this->infoError($row_error["title"], $row_error["text"]);
				}
			};
		};
		*/
		
		
		if (empty($this->output["errors"])) unset($this->output["errors"]);
		if (empty($this->output["warnings"])) unset($this->output["warnings"]);
		if (empty($this->output["notices"])) unset($this->output["notices"]);
		

		if ($this->call_method == "request") {
			//unset($this->output["error"]);
			
			echo json_encode( $this->output );
			return true;	
		} else {
			//var_dump( $this->output );
			return $this->output["data"];
		};	
	
	
	
	
	
	}
	
	
	
	public function __get ($name) {
		return $this->onRequest( "get_" . $name );
	}

	public function __set ($name, $params) {
		if (!is_array($params)) $params = array("value" => $params);
		return $this->onRequest("set_" . $name, $params);
	}	
	
    public function __call($name, $params) {
		if (!is_array($params)) $params = array("value" => $params);
		return $this->onRequest($name, $params);
    }	
	
	
	
	
	
	
	


	function infoSuccess($title, $text) {
		//$this->output["action"][] = array("do" => "success", "title" => $title, "description" => $description);
		$this->output["notices"][] = array("title" => $title, "text" => $text);
	}
	
	function infoError($title, $text) {
		//$this->output["action"][] = array("do" => "error", "title" => $title, "description" => $description);
		$this->output["errors"][] = array("title" => $title, "text" => $text);
	}
	
	function jqueryText($uid, $value) {
		$this->output["action"][] = array("do" => '$uid.func', "uid" => $uid, "value" => $value, "func" => "text");
	}

	function jqueryDataText($data) {
		foreach ($data as $key => $value) {
			$this->output["action"][] = array("do" => '$uid.func', "uid" => $key, "value" => $value, "func" => "text");
		};
	}
	
	function jqueryHTML($uid, $value) {
		$this->output["action"][] = array("do" => '$uid.func', "uid" => $uid, "value" => $value, "func" => "html");
	}
	
	function jqueryDataHTML($data) {
		foreach ($data as $key => $value) {
			$this->output["action"][] = array("do" => '$uid.func', "uid" => $key, "value" => $value, "func" => "html");
		};
	}
	
	function jqueryValue($uid, $value) {
		$this->output["action"][] = array("do" => '$uid.func', "uid" => $uid, "value" => $value, "func" => "val");
	}

	function jqueryRemoveClass($uid, $value) {
		$this->output["action"][] = array("do" => '$uid.func', "uid" => $uid, "value" => $value, "func" => "removeClass");
	}
	
	function dtSetData($uid, $data_in) {
		if (!is_array($data_in)) {
			$this->output["action"][] = array("do" => 'dtSetData', "uid" => $uid, "data" => array());
		} else {
			$data = array();
			foreach ($data_in as $item) $data[] = $item;		
			
			
			foreach ($data as $row_id => $item_row) {
				foreach ($item_row as $field => $value) {
					if (in_array($field, array("OPERATION_DATE", "OPEN_DATE", "CLOSE_DATE"))) $data[ $row_id ][ $field ] = str_ireplace(' ', '&nbsp;', date("H:i:s, d.m.Y", $value));
				};
			};
		
			$this->output["action"][] = array("do" => 'dtSetData', "uid" => $uid, "data" => $data);
			
			return true;
		};
	}

	
	// обработчик ошибок
	function error_handler($errno, $errstr, $errfile, $errline) {	
		if (!(error_reporting() & $errno)) {
			// Этот код ошибки не включен в error_reporting
			return;
		}		
		
		$row_split = explode("--", $errstr);
		if (count($row_split) == 1) {
			$title = trim($row_split[0]);
			$description = null;
		} else {
			$title = trim($row_split[0]);
			$description = trim($row_split[1]);
		};
	
	
		switch ($errno) {
			case E_USER_ERROR:
				if ($this->call_method == "request") {
					$this->output["action"][] = array("do" => "error", "title" => $title, "description" => $description  );
					return true;
				};
			break;
			case E_USER_WARNING:
				if ($this->call_method == "request") {
					$this->output["action"][] = array("do" => "warning", "title" => $title, "description" => $description);
					return true;
				};
			break;
			case E_USER_NOTICE:
				if ($this->call_method == "request") {
					$this->output["action"][] = array("do" => "success", "title" => $title, "description" => $description);
					return true;
				};
			break;
			default:
				if ($this->call_method == "request") {
					$this->output["action"][] = array("do" => "error", "title" => "Неизвестная ошибка", "description" => "Неизвестная ошибка: [{$errno}] {$errstr}"  . "\r\n in file=\"{$errfile}[{$errline}]\"");
					return true;
				};
			break;
		}
	 
	
		return false;
	}

	function __construct() {
		if (!file_exists(FILENAME_CD)) file_put_contents(FILENAME_CD, json_encode(array()));
		$this->cd = json_decode(file_get_contents( FILENAME_CD), true);		
		
		set_error_handler( array(&$this, 'error_handler') );
	}

	function __destruct() {
		asort($this->cd);
		file_put_contents(FILENAME_CD, json_encode( $this->cd ));
	} 

	
	
	// оповещения и переводчик
	
	static function error( $text, $params = array() ) {
		$text = self::t($text, "Error message");
		if (count($params) > 0) vsprintf( $text, $params );
		trigger_error($text, E_USER_ERROR);			
	}

	static function warning( $text, $params = array() ) {
		$text = self::t($text, "Warning message");
		if (count($params) > 0) vsprintf( $text, $params );
		trigger_error($text, E_USER_WARNING);			
	}

	static function notice( $text, $params = array() ) {
		$text = self::t($text, "Notice message");
		if (count($params) > 0) vsprintf( $text, $params );
		trigger_error($text, E_USER_NOTICE);			
	}
	
	static function t( $uid, $page = "" ) {
		if (!defined('DEFAULT_LANG')) return $uid;
		
		$lang = LANG;
		if (empty($lang)) $lang = DEFAULT_LANG;
		
		
		$translate = iDB::value($query = "SELECT `{$lang}` FROM `". DB_PREFIX . "translate` WHERE `uid`=" . iS::sq($uid));
		
		if (is_null( $translate )) {
			//trigger_error("uid \"{$uid}\" is not found in translate", E_USER_ERROR);
			iDB::insertSQL(DB_PREFIX . "translate", array(
				"uid" => $uid,
				"ru" => $uid,
				"en" => $uid,
				"auto" => 1,
				"page" => $page
			));
			return $uid;
			
		} else return $translate;	
	}


	












}