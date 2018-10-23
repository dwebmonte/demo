<?php
require_once( ROOT . 'classes/phpmorphy-0.3.7/src/common.php');


	
class rt extends iParser {
	public $domain = "https://russian.rt.com";	
	public $morphy;
	
	// Главная страница
	function parse_last( $page = 1) {		
		$this->cache = false;
		
		$count_page = 200;
		$page--;
		
		$content = $this->load($page_url = "https://russian.rt.com/listing/type.News.tag.novosty-glavnoe/prepare/all-news/{$count_page}/{$page}");
		

		if (!empty($content)) {
			$J = str_get_html($content);
			

			foreach ($J->find(".listing__rows li") as $oItem) {
				if (!isset($oItem->find(".card__heading a", 0)->href)) continue;
				
				$json["last"][] = array(
					"category" => $oItem->find(".card__category", 0)->plaintext,
					"title" => $oItem->find(".card__heading a", 0)->plaintext,
					"url" => $oItem->find(".card__heading a", 0)->href,
					"str_time" => $oItem->find(".card__date", 0)->plaintext,
				);
				
			};
			
			$this->add_json($json, $page_url);

			$J->clear(); 
			unset($J);
			
			iDB::updateSQL("log", array("title" => "start page", "res" => 1), "id={$this->log_insert_id}");
		} else {
			iDB::updateSQL("log", array("title" => "start page", "res" => 0), "id={$this->log_insert_id}");
		};
		
	}
	
	
	// парсинг статей
	function parse_detail($max_count = 3) {
		$this->cache = false;
		$this->use_proxy = false;
				
		$data_article = iDB::rows("SELECT id, url, title FROM article WHERE parsed=0 AND url LIKE 'https://russian.rt.com%' ORDER BY id LIMIT {$max_count}");
		
		if (is_array($data_article))
		foreach ($data_article as $oArticle) {
	
	
			$content = $this->load( $oArticle->url );
			
			if (!empty($content)) {
				$J = str_get_html($content);
				$json = array("parsed" => true, "text" => "");

			
				// Удаляем ненужное
				if ($J->find("h1", 0)) foreach ($J->find("h1") as $item) $item->outertext = "";	
				if ($J->find(".article__date-autor-shortcode", 0)) foreach ($J->find(".article__date-autor-shortcode") as $item) $item->outertext = "";	
				if ($J->find(".article__share", 0)) foreach ($J->find(".article__share") as $item) $item->outertext = "";	
				if ($J->find(".rtcode", 0)) foreach ($J->find(".rtcode") as $item) $item->outertext = "";	
				
				if ($J->find(".js-mediator-article", 0)) foreach ($J->find(".js-mediator-article") as $item) {
					$one_text = trim($item->plaintext);
					


					if (strpos($one_text, ".Ранее") !== false) {
						$temp = explode(".Ранее", $one_text);
						$json["text"] .= $temp[0] . ".";
						break;
					};					
					
					
					$json["text"] .= $one_text . " \r\n";
				};
				
				//$json["text"] = trim(html_entity_decode($json["text"]));
				//var_dump( $json["text"] );

				$json["response"] = $this->response;
				iDB::updateSQL("article", $json, "id={$oArticle->id}");				
				//iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 1), "id={$this->log_insert_id}");
			} else {
				//iDB::updateSQL("log", array("title" => $oArticle->title, "res" => 0), "id={$this->log_insert_id}");
			};
			
			
		};
	}	
	
	
	
	
	
	
	
	
	
	
	
	function lemma( $text_orig, $sort = false ) {
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
			$text_obr = $this->morphy->lemmatize($text);
			$text_obr = (is_array($text_obr)) ? mb_strtolower($text_obr[0]) : mb_strtolower($text);
			$text_obr = str_ireplace( array("ё", "й"), array("е", "и"), $text_obr);
			
			//if (in_array($text_obr, $this->row_del_all)) continue;
			//if (count($lemma) == 0 && in_array($text_obr, $this->row_del_start)) continue;
			
			//if (!preg_match('#\D#', $text_obr)) continue;
			
			$lemma[$text_obr] = $text_obr;
		};		
		if ($sort) asort($lemma);
		
		return trim(mb_strtolower(implode(" ", $lemma)));
	}	
	
	
	
	
	
	
	function __construct() {
		parent::__construct();
		
		$dir = ROOT . 'classes/phpmorphy-0.3.7/dicts';
		$lang = 'ru_RU';
		 
		// Список поддерживаемых опций см. ниже
		$opts = array(			'storage' => PHPMORPHY_STORAGE_FILE,		);
		 
		// создаем экземпляр класса phpMorphy
		try {
			$this->morphy = new phpMorphy($dir, $lang, $opts);
		} catch(phpMorphy_Exception $e) {
			die('Error occured while creating phpMorphy instance: ' . $e->getMessage());
		};			
	}


	function __destruct() {
		parent::__destruct();
	}






}