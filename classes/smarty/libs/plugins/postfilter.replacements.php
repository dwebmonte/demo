<?php

function smarty_postfilter_replacements($source, &$smarty)  {
	if (!isset($GLOBALS["_css_code"][$smarty->_current_file])) {
		if (preg_match_all("#    \{css\}  (.+?)    \{/css\}    #suix", $source, $sub, PREG_SET_ORDER)) {
		
			foreach ($sub as $key=>$item) {
				$content = trim($item[1]);	

				if (!isset($GLOBALS["_css_code"])) $GLOBALS["_css_code"] = array();
				if (!isset($GLOBALS["_css_code"][$smarty->_current_file])) $GLOBALS["_css_code"][$smarty->_current_file] = "";
					
				$GLOBALS["_css_code"][$smarty->_current_file] .= $content."\r\n";
			};
		};
	};
	
	$source = preg_replace("#    \{css\}  (.+?)    \{/css\}    #suix", "", $source);
	


	if (!isset($GLOBALS["_js_code"][$smarty->_current_file])) {
		if (preg_match_all("#    \{script \s* ([^}]*?)  \}  (.+?)    \{/script\}    #suix", $source, $sub, PREG_SET_ORDER)) {
			foreach ($sub as $key=>$item) {
				$content = trim(str_ireplace(array('<script>','</script>'),'',$item[2]));

				if (!isset($GLOBALS["_js_code"])) $GLOBALS["_js_code"] = array();
				if (!isset($GLOBALS["_js_code"][$smarty->_current_file])) $GLOBALS["_js_code"][$smarty->_current_file] = "";
					
				if (empty($item[1])) $GLOBALS["_js_code"][$smarty->_current_file] .= '$(function() {'."\r\n\r\n".$content."\r\n\r\n});\r\n\r\n";
				else $GLOBALS["_js_code"][$smarty->_current_file] .= $content."\r\n";
			};
		};
	};	

	$source = preg_replace("#    \{script \s* ([^}]*?)  \}  (.+?)    \{/script\}    #suix", "", $source);
	
	
	var_dump($source);
	
	return $source;

}