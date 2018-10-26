<?php
/*



 */
function smarty_function_link($params, &$smarty) {
	$output = "";
	$host_name = 'http://'.HOST_NAME.'/';
	
	if (isset($params["css"])) {

		$data_src = explode(";", $params["css"]);	
		foreach ($data_src as $src) {
			$file_name = trim($src);
			if (empty($file_name)) continue;
			
			if (strpos($src, "http") !== 0) {
				$file_name_replace = null;
				
				$var_data = array();
				$var_data[] = array("file"=>DOCUMENT_ROOT.$file_name,										"replace"=>$file_name );
				$var_data[] = array("file"=>ROOT.'css/'.$file_name,								"replace"=>CMS_URL.'css/'.$file_name );
				$var_data[] = array("file"=>ROOT_CSS.'/'.$file_name,							"replace"=>$host_name.PATH_CSS.'/'.$file_name );
				$var_data[] = array("file"=>ROOT.'admin_panel.3.0/css/'.$file_name,	"replace"=>CMS_URL.'admin_panel.3.0/css/'.$file_name );
				$var_data[] = array("file"=>ROOT_JS.'/'.$file_name,								"replace"=>$host_name.PATH_JS.'/'.$file_name);
				$var_data[] = array("file"=> ROOT.'admin_panel.3.0/js/'.$file_name,		"replace"=>CMS_URL.'admin_panel.3.0/js/'.$file_name);
				$var_data[] = array("file"=>ROOT.'js/'.$file_name,									"replace"=>CMS_URL.'js/'.$file_name);				
				$var_data[] = array("file"=>$file_name,										"replace"=>$file_name );
				
				foreach ($var_data as $item_file) {	
					if (file_exists($item_file["file"])) {
						$file_name_replace =$item_file["replace"];
						break;
					};
				};
				
				if (is_null($file_name_replace)) {
					var_dump($var_data);
					trigger_error("Не найден файл css - {$file_name}", E_USER_ERROR);
				} else $GLOBALS["_css_link"][] = $file_name_replace;
				
			} else $GLOBALS["_css_link"][] = $file_name;
		};
		
		
	};
	
	
	if (isset($params["js"])) {
	
		$data_src = explode(";", $params["js"]);	
		foreach ($data_src as $src) {
			$file_name = trim($src);
			if (empty($file_name)) continue;
			if (strpos($src, "http") !== 0) {
				$file_name_replace = null;
				
				$var_data = array();
				$var_data[] = array("file"=>DOCUMENT_ROOT.$file_name,					"replace"=>$file_name );
				$var_data[] = array("file"=>ROOT_JS.'/'.$file_name,							"replace"=>$host_name.PATH_JS.'/'.$file_name );
				$var_data[] = array("file"=>ROOT.'admin_panel.3.0/js/'.$file_name,		"replace"=>CMS_URL.'admin_panel.3.0/js/'.$file_name );
				$var_data[] = array("file"=>ROOT.'js/'.$file_name,								"replace"=>CMS_URL.'js/'.$file_name );
				$var_data[] = array("file"=>$file_name,											"replace"=>$file_name );
				
				foreach ($var_data as $item_file) {	
					if (file_exists($item_file["file"])) {
						$file_name_replace =$item_file["replace"];
						break;
					};
				};
				
				if (is_null($file_name_replace)) {
					var_dump($var_data);
					trigger_error("Не найден файл js - {$file_name}", E_USER_ERROR);
				} else $output .= "\r\n\t<script type='text/javascript' src='{$file_name_replace}?v=".PROJECT_VERSION."'></script>";
				
			} else $output .= "\r\n\t<script type='text/javascript' src='{$src}?v=".PROJECT_VERSION."'></script>";
		};
		
		
	};	
	
	
	return $output;
}



?>
