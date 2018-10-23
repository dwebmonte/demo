<?php

function smarty_modifier_param_name($string) {
	$name = iS::sq($string);
	return $res = iDB::value("SELECT title FROM param WHERE name={$name}");
	
}



?>
