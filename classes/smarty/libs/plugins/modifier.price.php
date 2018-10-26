<?php

function smarty_modifier_price($string, $format=1) {
	if ($format==1) return number_format($string, 2, '.', ' ');
	elseif ($format==2)  return number_format($string, 0, '.', ' ');
	elseif ($format==3)  return ceil($string);
}



?>
