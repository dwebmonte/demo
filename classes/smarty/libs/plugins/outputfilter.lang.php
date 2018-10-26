<?php

function smarty_outputfilter_lang($source, &$smarty) {


	if (isset($GLOBALS['_lang']) && $GLOBALS['_lang'] != '*') {
		if (preg_match_all('#  <lang>(.+?)</lang>  #suix', $source, $sub, PREG_SET_ORDER)) {
			foreach ($sub as $key=>$item) {
				$key_word = $item[1];
				//var_dump($sub);
							
					
				
				$translate = iDB::value("SELECT `{$GLOBALS['_lang']}_word` FROM `lang` WHERE key_word=".iS::sq($key_word));
				if (is_null($translate)) {
					$iTranslate = new iTranslate();
					$translate = $iTranslate->word($key_word, 'ru', $GLOBALS['_lang']);
					
					$key_id = iDB::value("SELECT `id` FROM `lang` WHERE key_word=".iS::sq($key_word));
					if (is_null($key_id)) {
						$key_id = iDB::insert("INSERT INTO `lang` (`key_word`, `{$GLOBALS['_lang']}_word`)
						VALUES(".iS::sq($key_word).",".iS::sq($translate).")");		
					} else {
						iDB::update("UPDATE `lang` SET `{$GLOBALS['_lang']}_word`=".iS::sq($translate)." WHERE id={$key_id}");
					};
					
					
				};
				//exit();	
				$source = str_ireplace('<lang>'.$key_word.'</lang>', $translate, $source);
			};
		};
	};

	
	return $source;
 }