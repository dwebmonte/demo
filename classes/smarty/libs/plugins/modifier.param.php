<?php

function smarty_modifier_param($string, $param_name=null) {
	$value = (int) $string;
	$param_name = iS::sq($param_name);
	$data_param = iDB::row("SELECT * FROM param WHERE name={$param_name}");
	
	return $res = iDB::value("SELECT title FROM param_set WHERE value={$value} AND param_id={$data_param->id}");
	
}



?>
