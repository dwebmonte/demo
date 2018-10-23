<?php

function smarty_modifier_rel_param($string, $table_name, $table_field='title') {
	$id = (int) $string;
	
	return $value = iDB::value("SELECT {$table_field} FROM {$table_name} WHERE id={$id}");

	
}



?>
