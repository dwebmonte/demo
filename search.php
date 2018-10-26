<?php

require_once("classes/constants.php");
require_once("classes/simple_html_dom.php");
require_once( ROOT . 'classes/phpmorphy-0.3.7/src/common.php');



$max_percent = 30;


$from = "2018-08-21";
$to = "2018-08-22";

$from1 = "2018-08-21";

$table_article = "article";

$data_compare = $str_article_id = array();
$data_article_diapazon = iDB::rows("SELECT id, title, `text`, time_added  FROM `{$table_article}` WHERE time_added BETWEEN '{$from}' AND '{$to}'");

// получаем номера
foreach ($data_article_diapazon as $item) $str_article_id[] = $item->id;
$str_article_id = implode(",", $str_article_id);




foreach ($data_article_diapazon as $item_article_diapazon) {
	$article_id = $item_article_diapazon->id;
	$search_word = $item_article_diapazon->text;
	
	$boolean_mode = 'IN BOOLEAN MODE';
	$boolean_mode = '';

	$data_article = iDB::rows($query = "
	SELECT S.article_id, S.title,MATCH (S.`title`, S.`text`) AGAINST (". iS::sq($search_word) ." {$boolean_mode}) koef
	FROM `search` S 
	
	WHERE S.article_id IN ({$str_article_id}) AND 
	
	MATCH (S.`title`, S.`text`) AGAINST (". iS::sq($search_word) ."  {$boolean_mode}) > 0
	ORDER BY MATCH (S.`title`, S.`text`) AGAINST (". iS::sq($search_word) ."  {$boolean_mode}) DESC
	LIMIT 30
	");
	
	
	if (is_null($data_article)) continue;
	
	foreach ($data_article as $key => $item) {
		if ($key == 0) $max_koef = $item->koef;
		$percent = $data_article[$key]->percent = ceil(100 * ($item->koef / $max_koef));
		if ($percent < $max_percent) break;
		
		if ($item->article_id != $item_article_diapazon->id) {
			if (!isset( $data_compare[ $item_article_diapazon->id ] )) {
				$data_compare[ $item_article_diapazon->id ] = array("title" => $item_article_diapazon->title, "items" => array());
			};
			$data_compare[ $item_article_diapazon->id ]["items"][ md5($item->title) ] = array(
				"id" => $item->article_id,
				"title" => $item->title,
				"percent" => $percent
			);
		};
		
		//var_dump( $item->id . ") " . $item->title . " - " . $percent . "%" );
	};
	flush();
	
};

var_dump( $data_compare );
exit();






















$dir = ROOT . 'classes/phpmorphy-0.3.7/dicts';
$lang = 'ru_RU';
 
// Список поддерживаемых опций см. ниже
$opts = array(			'storage' => PHPMORPHY_STORAGE_FILE,		);
 
// создаем экземпляр класса phpMorphy
try {
	$iMorphy = new phpMorphy($dir, $lang, $opts);
} catch(phpMorphy_Exception $e) {
	die('Error occured while creating phpMorphy instance: ' . $e->getMessage());
};

$data_search = array();

$max_id = iDB::value("SELECT MAX(article_id) FROM `search`");
if (is_null($max_id)) $max_id = 0;
$data_article = iDB::rows("SELECT id, title, `text` FROM article_korr WHERE id>{$max_id} ORDER BY id LIMIT 500");
foreach ($data_article as $row_article) {

	$data_search[] = array(
		"title" =>  lemma( $row_article->title ),
		"text" =>  lemma( $row_article->text ),
		"article_id" => $row_article->id,
//		"table_id" => 1
	);
	
};

iDB::insertDataSQL("search", $data_search);



	function lemma( $text_orig, $sort = false ) {
		global $iMorphy;
		
		$text = $text_orig;
		$lemma = array();

		$text = mb_strtolower( str_ireplace("ё", "е", $text ));
		$text = preg_replace('#[^.а-яa-z0-9ґіїєі]#suix', ' ', $text);
		$text = str_replace('.', '', $text);
		
		// Удаляем числа
		//$text = preg_replace('#\D (\d+) \D#suix', ' ', $text);			$text = preg_replace('#^ (\d+) \D#suix', ' ', $text);		$text = preg_replace('#\D (\d+) $#suix', ' ', $text);
		
		$text = trim(preg_replace("# \s+ #six", " ", $text));
		
		$row_text = explode(" ", mb_strtoupper($text));
		
		
		
		foreach($row_text as $key_text => $text) {
			$text_obr = $iMorphy->lemmatize($text);
			$text_obr = (is_array($text_obr)) ? mb_strtolower($text_obr[0]) : mb_strtolower($text);
			$text_obr = str_ireplace( array("ё", "й"), array("е", "и"), $text_obr);
			
			if (in_array($text_obr, array('в', 'без', 'до', 'из', 'к', 'на', 'по', 'о', 'от', 'перед', 'при', 'через', 'с', 'у', 'за', 'над', 
			'об', 'под', 'про', 'для'))) continue;
			
			$lemma[$text_obr] = $text_obr;
		};		
		if ($sort) asort($lemma);
		
		return trim(mb_strtolower(implode(" ", $lemma)));
	}
	
	
	
/*
	
ALTER TABLE `search` MODIFY COLUMN `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
 ADD FULLTEXT `fulltext`(`title`, `text`);

 */