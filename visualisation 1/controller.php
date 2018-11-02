<?php
	header('Content-Type: application/json');
	
	if (isset($_REQUEST["do"])) {
		$output = array();
	
	
		switch (trim($_REQUEST["do"])) {
			
			case "load data":
				// получаем текущий json из CD
				$output = array(
					"CDP" => json_decode(file_get_contents("json/CDP.json")),
					"CD" => json_decode(file_get_contents("json/CD.json")),
					"success" => true
				);
			break;
			
			case "cd delete rows":
				$json = json_decode( file_get_contents("json/CD.json") );
				$prop = $_REQUEST["prop"];
			
				$data_row = json_decode($_REQUEST["json"]);
				foreach ($data_row as $row_id) {
					unset($json->$prop->$row_id);
				};
				file_put_contents("json/CD.json", json_encode( $json ));
			
				$output = array("success" => true	);
			break;
			
			
			case "cd load":
				// получаем текущий json из CD
				$output = array("CD" => file_get_contents("json/CD.json"),			"success" => true				);
			break;
			
			
			case "cd save":
				// получаем текущий json из CD
				$json = file_get_contents("json/CD.json");
				
				// объединяем объекты
				if (!empty($json)) {
					$json = array_merge( (array) json_decode($json), (array) json_decode($_REQUEST["json"]) );
					file_put_contents("json/CD.json", json_encode( $json ));
					
				} else {
					file_put_contents("json/CD.json", $_REQUEST["json"]);
				};
				
				

				
				$output["success"] = true;
			break;
			default: trigger_error("Unknown action do=\"{$_REQUEST["do"]}\"", E_USER_ERROR);
	
	
	
	
		};
		
		
		
		echo json_encode( $output );
	} else {
	
	
	/*
	$data_json = json_decode(file_get_contents("json/document.json"));
	
	$page_url = (isset($_REQUEST["page"])) ? $_REQUEST["page"] : "";

	
	if (isset($data_json->doc->$page_url)) {
		$out_json = $data_json->doc->$page_url;	
	} else {
		$out_json = $data_json->doc->{"_empty_"};	
	};
	

	
	$out_json->action = array_merge($data_json->action, $out_json->action);
	
	// echo json_encode( $out_json );
	*/
	
	
		//echo file_get_contents("json/document.json");
	};