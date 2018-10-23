<?php

function smarty_prefilter_replacements($source, &$smarty)  {

	
	$Q = '["'."']"; $NQ = '[^"'."']";
	

	// Удаляем <? 	внутри {php}
	$source = preg_replace("#    \{php\} \s* \<\?  (.+?)  \?\> \s*  \{/php\}    #suix", "{php}$1{/php}", $source);
	if (is_null($source)) trigger_error("Ошибка в регулярном выражении - проверьте кодировку документа (должна быть в UTF-8)", E_USER_ERROR);
	

	
	return $source;

}