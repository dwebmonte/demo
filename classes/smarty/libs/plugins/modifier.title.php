<?php

function smarty_modifier_title($id, $table, $field='title') {
	$id = iS::n($id);
	$table = iS::s($table);
	
	return $res = iDB::value("SELECT {$field} FROM {$table} WHERE id={$id}");
	
}



?>
