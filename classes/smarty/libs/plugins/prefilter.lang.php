<?php
function smarty_prefilter_lang($source, &$smarty)  {
	//exit();

	if (isset($GLOBALS['_lang']) && $GLOBALS['_lang'] != '*') {
		if (preg_match_all('#  <lang>([^$] .+?)</lang>  #suix', $source, $sub, PREG_SET_ORDER)) {
			foreach ($sub as $key=>$item) {
				$key_word = $item[1];
			
				$translate = iDB::value("SELECT `{$GLOBALS['_lang']}_word` FROM `lang` WHERE key_word=".iS::sq($key_word));
				if (!is_null($translate)) {
					$source = str_ireplace('<lang>'.$key_word.'</lang>', $translate, $source);
					
				};
			};
		};
	} else {
		$source = str_ireplace('<lang>', '', $source);
		$source = str_ireplace('</lang>', '', $source);
	};
	
	return $source;


}
