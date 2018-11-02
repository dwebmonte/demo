<?php


/*
	 data-mask="fdecimal" 
	 placeholder="Formatted Decimal" 
	 data-dec="," 
	 data-rad="." 
	 maxlength="10"
	
	
*/

class iWM extends iEvent {
	public $def_access = "111";
	
	
	function __construct() {
		parent::__construct();

		if (!file_exists('manifest/document.xml')) return false;
		
		if (!defined('LANG') || LANG == "") $xml_filename = 'manifest/document.xml'; else $xml_filename = 'manifest/document-'. LANG .'.xml';
		
		if (file_exists($xml_filename)) $xml = simplexml_load_file($xml_filename);
		else trigger_error("\"{$xml_filename}\" - does not exist", E_USER_ERROR);

		// доступ по умолчанию
		$this->def_access = isset($xml["access"]) ? (string) $xml["access"] : 0;
		
		
		
		$document = array("page" => array(), "action" => array());
		
		// конфигурационный файл smarty
		$document["config"] = $this->config_load( $xml );
		// левое меню
		$document["action"][] = $this->left_menu( $xml );
		// пользователи
		$document["users"] = $this->fetch_users( $xml );
		
		// var_dump( $document );		exit();
		
		
		$CD = array();
		if (isset($xml->cd->var)) {
			foreach ($xml->cd->var as $var) {
				$rowCD = array("p" => (string) $var["name"], "v" => (string) $var["value"]);
				
				if (isset($var["parent"])) $rowCD["o"] = $var["parent"];
				if (isset($var["class"])) $rowCD["c"] = $var["class"];
					
				$CD[] = $rowCD;
			};
		};
		if (count($CD) > 0) $document["action"][] = array("do" => "cd", "data" => $CD);	

		
		
		// документ
		foreach ($xml->page as $pageXML) {
			$url = (string) $pageXML["url"];
			$document["page"][$url]["access"] = isset($pageXML["access"]) ? (string) $pageXML["access"] : $this->def_access;
			$document["page"][$url]["template-index"] = isset($pageXML["template-index"]) ? (string) $pageXML["template-index"] : "index.tpl";
			$document["page"][$url]["template-page"] = isset($pageXML["template-page"]) ? (string) $pageXML["template-page"] : "home.tpl";
			
			
		
			$CD = array(
				array("o"=>"page", "p"=>"title", "v"=> (string) $pageXML["title"], "c" => "crPage"),
				array("o"=>"page", "p"=>"description", "v"=> (string) $pageXML["description"], "c" => "crPage"),
			);

		
			if (isset($pageXML->cd->var)) {
				foreach ($pageXML->cd->var as $var) {
					$rowCD = array("p" => (string) $var["name"], "v" => (string) $var["value"]);
					
					if (isset($var["parent"])) $rowCD["o"] = $var["parent"];
					if (isset($var["class"])) $rowCD["c"] = $var["class"];
						
					$CD[] = $rowCD;
				};		
			};
		
			$document["page"][$url]["action"][] = array("do" => "cd", "data" => $CD);
		
		
			$data_table_params = array(
				"api_get" => array("xml" => array("api_get", "api-get", "api-load", "api_load")),
				"api_set" => array("xml" => array("api_set", "api-set", "api-save", "api_save")),
				"autoinc" => array("xml" => array("autoinc", "autoincrement", "auto-inc"), "type" => "boolean"),
				"info" => array("xml" => array("info"), "type" => "boolean"),
				"last_index" => array("xml" => array("last_index"), "default" => 0, "type" => "int"),
				"paging" => array("xml" => array("paging"), "type" => "boolean"),
				"panel" => array("xml" => array("panel-wrap", "panel", "panel_wrap"), "type" => "boolean", "default" => true),				
				"parent" => array("xml" => array("parent")),
				"read_only" => array("xml" => array("read_only", "read-only", "read", "readonly"), "type" => "boolean"),
				"scrollY" => array("xml" => array("scrollY"), "type" => "int"),
				"searching" => array("xml" => array("searching"), "type" => "boolean"),
				"title" => array("xml" => array("title"), "default" => ""),
			);
		
			foreach ($pageXML->table as $key_table => $table) { 
				$data = array("do" => "datatable", "fields" => array(), "data" => array(), "dt_fields" => array());
			
				// имя
				$data["name"] = isset($table["name"]) ? (string) $table["name"] : "wm_table_" . $key_table;
				$data["uid"] = isset($table["uid"]) ? (string) $table["uid"] : $table["name"];
				

				// параметры таблицы
				foreach ($data_table_params as $param => $row_param) {
					foreach ($row_param["xml"] as $xml_param) {
						if (isset($table[ $xml_param ])) {
							if (!isset($row_param["type"])) $row_param["type"] = "string";
							$data[ $param ] = (string) $table[ $xml_param ];
							
							switch ( $row_param["type"] ) {
								case "bool":
								case "boolean": if (in_array($data[ $param ], array("false", "0"))) $data[ $param ] = false; else $data[ $param ] = true; break;
								case "int": $data[ $param ] = (int) $data[ $param ]; break;
							};
							
							
						};
					};
					if (!isset( $data[ $param ] ) && isset($row_param["default"])) $data[ $param ] = $row_param["default"];
				};
				
				if (isset( $table["api"] )) {
					$data["api_get"] = (string)  "Get" . $table["api"];
					$data["api_set"] = (string)  "Set" .  $table["api"];
				};
				
				// поля
				if (isset($table->fields)) $node_fields = $table->fields->field; elseif (isset($table->field)) $node_fields = $table->field; else trigger_error("В table[name={$data["name"]}] нет fields", E_USER_ERROR);
				// формат полей по умолчанию
				if (isset( $table->fields ) && isset( $table->fields["format"])) $default_format = (string) $table->fields["format"]; else $default_format = "text"; 
				
				$line_fields = $columnDefs = array();
				$num_field = 0;
				
				
				foreach ($node_fields as $key_field => $field) {
					$num_field++;
					$field_name = $field_title = null;
					
					// name field
					$field_name = (isset($field["name"])) ? (string) $field["name"] : "{$data["name"]}_field_{$num_field}";
					// проверка name на повтор
					if (!isset($line_fields[ $field_name ])) $line_fields[ $field_name ] = true; else trigger_error("name = \"{$field_name}\" is already exsist", E_USER_ERROR);
					
					// title field
					if (isset($field["title"])) $field_title = (string) $field["title"];
					else {
						$field_title = trim( (string) $field );
						if (empty($field_title)) $field_title = $field_name;
					};
						
					// format field	
					$field_format = isset($field["format"]) ? (string) $field["format"] : $default_format;
					
					
					
					$row_field = array( );
					
					// общие параметры столбца
					
					if (!is_null($field_title)) $row_field["title"] = $field_title;
					if (!is_null($field_name)) $row_field["name"] = $field_name;
					if ($field_format != "text") $row_field["format"] = $field_format;

					// атрибуты столбца
					
					$options = array();
					$row_attr = array(
						"data-mask", "data-dec", "data-rad", "placeholder", "maxlength",
						"addon-fa", "addon-fa-left", "addon-fa-right", "value-eval", "value-cd",
					);
					foreach ($row_attr as $attr) {
						if (isset($field[ $attr ])) $options[ $attr ] = $this->json_value( $field[ $attr ] );
					};
					if (count($options) > 0) $row_field["attr"] = $options;
					
					
					// значение по умолчанию
					
					if (isset($field["default"])) {
						$row_field["default"] = ($field["default"] == "html") ? (string) $field : $field["default"];
					} else $row_field["default"] = "";
					
					
					// columnDefs
					$columnDefs[ $num_field-1 ] = array("targets" => $num_field-1, "data" => $field_name, "title" => $field_title);
					
					$row_dt_options = array("className", "orderable", "defaultContent", "width", "visible", "render", "default");
					
					foreach ($row_dt_options as $dt_option) {
						if (isset($field[ $dt_option ])) {
							$dt_real_option = $dt_option;
							
							if ($dt_option == "default") $dt_real_option = "defaultContent";
							elseif ($dt_option == "render") $field[ $dt_option ] = "render_cell_" . $field[ $dt_option ];

							$columnDefs[ $num_field-1 ][ $dt_real_option ] = $this->json_value( $field[ $dt_option ] );
						};
					};
					
					
					
					
					$data["fields"][] = $row_field;
		
					
				};				
				$data["columnDefs"] = $columnDefs;
				
				//exit();
				// данные
				if (isset($table->data)) {
					// случайные данные
					if (isset($table->data["random_rows"])) {
						$count_rows = (int) $table->data["random_rows"];
						for ($row_id = 0; $row_id < $count_rows; $row_id++) {
							
							$row_data = array();
							for ($cell_id = 0; $cell_id < count($data["fields"]); $cell_id++) {
								if (!isset($data["fields"][$cell_id]["name"])) continue;
								$value = (isset($data["fields"][$cell_id]["title"])) ? $data["fields"][$cell_id]["title"] . "_" . $row_id : $cell_id . "_" . $row_id;
								$row_data[ $data["fields"][$cell_id]["name"] ] = $value;
							};
							$row_data["id"] = $row_id;
							
							$data["data"][] = $row_data;
						};
						$data["last_index"] = $count_rows;
					};
					
					if (isset($table->data["local"])) {
					
					
					};
				};
				
				$document["page"][ $url ]["action"][] = $data;
			};
		
			
		};
		// $data_action[] = array("uid" => ".sidebar-user-info-inner > .user-links", "do" => "ah");
		
		//var_dump( $xml->pages );		exit();
		//exit();
		
		// добавляем CD
		
		if (!defined('LANG') || LANG == "") $cdp_filename = 'json/CDP.json'; else $cdp_filename = 'json/CDP-'. LANG .'.json';
		
		file_put_contents($cdp_filename, json_encode( $document ));
		//exit();
	}


	function json_value($value) {
		$value = (string) $value;
		switch ($value) {
			case "true": $value = true; break;
			case "false": $value = false; break;
			case "null": $value = null; break;
		};
	
		return $value;
	}
	
	
	function left_menu( $xml ) {
		$data = array("do" => "leftMenu", "items" => array());
		
		if (isset($xml->leftMenu->item)) {
			foreach ($xml->leftMenu->item as $item) {
				$row = array("url" => (string) $item["url"], "title" => (string) $item);
				$class = array();

				if ( (string) $item["active"] ) $class[] = "active";
				if ( (string) $item["expanded"] ) $class[] = "expanded";
				if (count($class) > 0) $row["class"] = implode(" ", $class);
				
				$row["icon"] = ( (string) $item["icon"] ) ? (string) $item["icon"] : "fa-cogs";
				
				$data["items"][] = $row;
			}; 
		
			return $data;
		} else return null;
	}
	
	function config_load( $xml ) {
		$data_config = array();
		$output = "";
		$data_config = array();
	
		foreach ($xml->config->var as $var) {
			
			$name = (string) $var["name"];
			$value = (string) $var["value"] ? $var["value"] : $var;
			$value = addslashes( (string)  $value );
			
			$output .= "{$name} = \"{$value}\"\r\n";
			$data_config[$name] = $value;
		
		};
		
		file_put_contents($GLOBALS["SM"]->config_dir . '/document.conf',  $output);
		return $data_config;
	}
	
	function fetch_users($xml) {
		$data_user = array();
		
		foreach ($xml->users->user as $user) {
			$info  = array();
			
			if (!isset($user["name"]) || !isset($user["login"]) || !isset($user["password"]) || !isset($user["id"])) trigger_error("Achtung", E_USER_ERROR);
			
			$info["id"] = (string) $user["id"];
			$info["name"] = (string) $user["name"];
			$info["login"] = (string) $user["login"];
			$info["password"] = (string) $user["password"];
			$info["access"] = isset($user["password"]) ? (string) $user["password"] : $this->def_access;
			
		
			$data_user[ $info["login"] ] = $info;
			
		};
		
		return $data_user;
	}
	
}


