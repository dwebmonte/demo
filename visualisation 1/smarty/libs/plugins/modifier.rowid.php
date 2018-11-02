<?php

function smarty_modifier_rowid($string, $row_id, $action) {
	$string = "[{$action}]" . str_ireplace('#id#', $row_id, $string);
	
	
	return $string;
	
}



?>
