<?php

function smarty_modifier_date_admin($string) {
	if (empty($string) || $string == "0000-00-00 00:00:00") return date('d-m-Y H:i');  else return date('Y.m.d H:i', strtotime($string));
}



?>
