<?php

function smarty_outputfilter_content($output, &$smarty) {
	$output = preg_replace('# \<\!\-\-\! (.+?)  \!\-\-\> #six','',$output);


	/*
	if (strpos($output, '</head>')!==false) {
		if (!empty($smarty->css_code_name)) {
			$name = md5(implode('-',$smarty->css_code_name)).'.css';
			$ins_head = "<link rel='stylesheet' type='text/css' href='/".PATH_CSS."/site/{$name}?v=".PROJECT_VERSION."' />";
			$output = str_ireplace('</head>', $ins_head.'</head>', $output);
		};
	};
	if (strpos($output, '</body>')!==false) {
		if (!empty($smarty->js_code_name)) { 
			$name = md5(implode('-',$smarty->js_code_name)).'.js';
			$ins_head = "<script type='text/javascript' src='/".PATH_JS."/site/{$name}?v=".PROJECT_VERSION."'></script>";
			$output = str_ireplace('</body>', $ins_head.'</body>', $output);
		};
	};
	*/

	$mode = 10;
	
	
	if (strpos($output, '</head>')!==false) {
		$ins_head = "";
		
		
		
		if (isset($GLOBALS["_css_link"])) {
			foreach ($GLOBALS["_css_link"] as $item_link) {
				$ins_head .= "\t<link href='{$item_link}?v=".PROJECT_VERSION."'  rel='stylesheet' type='text/css' />\r\n";
			};
			
			unset($GLOBALS["_css_link"]);
		};		

		
		if (isset($GLOBALS["_css_code"])) {
			if ($mode == 0) {
				$name = '_css_templates.css';
				$ins_head = "\t<link rel='stylesheet' type='text/css' href='/".PATH_CSS."/site/{$name}?v=".PROJECT_VERSION."' />";
							
				
				$new_file_content = "";
				foreach ($GLOBALS["_css_code"] as $item_code) $new_file_content .= $item_code;
				
				$old_file_content = file_get_contents(ROOT_CSS.'/site/'.$name);
				
				if ($old_file_content !== $new_file_content) {
					@mkdir(ROOT_CSS.'/site');
					file_put_contents(ROOT_CSS.'/site/'.$name, $new_file_content);			
				};
			} else {
				foreach ($GLOBALS["_css_code"] as $key_code=>$item_code) {
					$name = basename($key_code, '.tpl').'_________'.md5($key_code).'.css';
					
					$ins_head .= "\t<link href='/".PATH_CSS."/site/{$name}?v=".PROJECT_VERSION."'  rel='stylesheet' type='text/css' />\r\n";	
					
					@$old_file_content = file_get_contents(ROOT_CSS.'/site/'.$name);
					
					if ($old_file_content !== $item_code) {
						@mkdir(ROOT_CSS.'/site');
						file_put_contents(ROOT_CSS.'/site/'.$name, $item_code);			
					};						
				};	
				
			};
			
			unset($GLOBALS["_css_code"]);
		};
		

		
		$output = str_ireplace('</head>', $ins_head.'</head>', $output);
	};
	
	if (strpos($output, '</body>')!==false) {
		
		$ins_head = "";
		if (isset($GLOBALS["_js_link"])) {
			foreach ($GLOBALS["_js_link"] as $item_link) {
				$ins_head .= "\t<script type='text/javascript' src='{$item_link}?v=".PROJECT_VERSION."'></script>\r\n";
			};
			
			unset($GLOBALS["_css_link"]);
		};
		
		if (!empty($GLOBALS["_js_code"])) {	
			
			
			foreach ($GLOBALS["_js_code"] as $key_code=>$item_code) {
				$name = basename($key_code, '.tpl').'_________'.md5($key_code).'.js';
				
				$ins_head .= "\t<script type='text/javascript' src='/".PATH_JS."/site/{$name}?v=".PROJECT_VERSION."'></script>\r\n";

				
				@$old_file_content = file_get_contents(ROOT_JS.'/site/'.$name);
				
				if ($old_file_content !== $item_code) {
					@mkdir(ROOT_JS.'/site');
					file_put_contents(ROOT_JS.'/site/'.$name, $item_code);			
				};						
			};			
			
			$output = str_ireplace('</body>', $ins_head.'</body>', $output);
			unset($GLOBALS["_js_code"]);
		};

	};
	/*
	if (strpos($output, '</body>')!==false) {
		if (!empty($smarty->js_code_name)) { 
			$name = '_js_templates.js';
			$ins_head = "<script type='text/javascript' src='/".PATH_JS."/site/{$name}?v=".PROJECT_VERSION."'></script>";
			$output = str_ireplace('</body>', $ins_head.'</body>', $output);
			
			// Записываем в файл
			
			$js_code = '';
			if (!empty($smarty->js_code)) $js_code .= $smarty->js_code;
			if (!empty($smarty->js_code_ready)) $js_code .= '$(document).ready(function(){'."\r\n".$smarty->js_code_ready."\r\n})";
			
			$file_content = file_get_contents(ROOT_JS.'/site/'.$name);
			if ($file_content !== $js_code) {
				@mkdir(ROOT_JS.'/site');
				file_put_contents(ROOT_JS.'/site/'.$name,$js_code);			
			};
		};
	};
*/
	
	
	/*
	$output = preg_replace('#>\s+<#six','><',$output);
	$output = preg_replace('#^\s+ | \r\n #mix','',$output);
	*/

	
	
	
	return $output;
 }