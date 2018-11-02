<?php
function smarty_prefilter_content($source, &$smarty)  {
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~					onSmartyPostfilter
	$event_name = "onSmartyPretfilter";
	
	if (isset($GLOBALS['__queue'][$event_name])) {
		foreach ($GLOBALS['__queue'][$event_name] as $row_event) {
			$source = call_user_func_array(array($row_event['obj'], $event_name), array($smarty->_current_file, $source));
		};
	};	
	
	
	if (DEVELOPE) {
		$source = "<!-- start prefilter file=\"{$smarty->_current_file}\" -->\r\n{$source}\r\n<!-- end prefilter file=\"{$smarty->_current_file}\" -->\r\n";
	};
	
	return $source;
}
