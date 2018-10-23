<?php

function smarty_function_stop($params, &$smarty) {
	echo "event.stopPropagation ? event.stopPropagation() : (event.cancelBubble=true);";
}



?>
